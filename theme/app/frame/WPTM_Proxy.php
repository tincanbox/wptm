<?php


class WPTM_Proxy {

  #
  #
  function __construct($fn, array $arguments = array()){
    $this->argument = $arguments;
    $this->callback = $fn;
  }


  # trigger
  #
  # @return {*} Result of call_user_func_array($this->callback, $this->argument)
  #
  function trigger(){
    return (is_callable($this->callback))
      ? call_user_func_array($this->callback, array_merge(func_get_args(), $this->argument))
      : null;
  }

  # bind
  #
  # @param {array|string} Array or Strign for call_user_func_array() 1st argument.
  # @param {array} Array to pass to call_user_func_array() 2nd argument.
  # @return {array} Array for call_user_func_array()
  #
  static function bind($callback, $arguments = array()){
    $instance = new self($callback, $arguments);
    return array($instance, 'trigger');
  }

}
