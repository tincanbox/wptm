<?php

namespace WPTM\Mixin;

class Configurable {

    private $_separator = '.';

    private $_data = [];

    function is_empty(){
        return (count($this->_data) === 0);
    }

    function dump($html = false){
        if ($html) {
            echo '<pre>';
            echo var_export($this->_data, true);
            echo '</pre>';
        } else {
            var_dump($this->_data);
        }
    }

    function has($name) {
        $keys = self::generate_access_keys($name);
        try {
            return $this->dig_by_access_keys($keys, $this->_data, function ($target, $key) {
                return array_key_exists($key, $target);
            });
        } catch(\Error $e) {
            return false;
        }
    }

    function set($name, $value){
        $keys = self::generate_access_keys($name);
        $this->dig_by_access_keys($keys, $this->_data, function (&$target, $key) use($value) {
            $target[$key] = $value;
        });

        return $value;
    }

    function get($name, $default = null){
        $keys = self::generate_access_keys($name);
        return $this->dig_by_access_keys($keys, $this->_data, function ($target, $key) use($default) {
            return (array_key_exists($key, $target))
                ? $target[$key]
                : $default
                ;
        });
    }

    private function dig_by_access_keys(array $keys, array &$data, $callback, $getting = false)
    {
        $last = count($keys) - 1;
        $depth = 0;
        $prev = &$data;
        foreach ($keys as $key) {
            $depth++;
            $is_last = ($depth > $last);
            if (array_key_exists($key, $prev)) {
                if ($is_last) {
                    return $callback($prev, $key);
                } else {
                    if (is_array($prev[$key])) {
                        $prev = &$prev[$key];
                    } else {
                        throw new \Error('Unreachable Name: ' . implode($this->_separator, $keys));
                    }
                }
            } else {
                if ($is_last) {
                    return $callback($prev, $key);
                } else {
                    if ($getting) {
                    } else {
                        $prev[$key] = [];
                    }
                    $prev = &$prev[$key];
                }
            }
        }
    }

    private static function generate_access_keys($name): array
    {
        switch (gettype($name)) {
            case 'string':
                $keys = explode('.', $name);
                break;
            case 'array':
                $keys = $name;
                break;
            default:
                throw new \Error('Invalid Configuration Name Designation');
        }

        return $keys;
    }

}
