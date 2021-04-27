<?php

class EnvAdaptor {

    private $adaptorPath = __DIR__ . DIRECTORY_SEPARATOR . '.env.array.php';
    private $target = [
        'WP_DB_HOST',
        'WP_DB_NAME',
        'WP_DB_USER',
        'WP_DB_PASSWORD',
        'WP_AUTH_KEY',
        'WP_SECURE_AUTH_KEY',
        'WP_LOGGED_IN_KEY',
        'WP_NONCE_KEY',
        'WP_AUTH_SALT',
        'WP_SECURE_AUTH_SALT',
        'WP_LOGGED_IN_SALT',
        'WP_NONCE_SALT',
    ];
    private $envs = [];

    function __construct()
    {
    }

    function generate(){
        foreach ($this->target as $env) {
            $this->envs[$env] = getenv($env);
        }
        file_put_contents(
            __DIR__ . DIRECTORY_SEPARATOR . '.env.array.php',
            '<?php return ' . var_export($this->envs, true) . ';' . PHP_EOL
        );
        return $this->envs;
    }

    function retrieve(){
        $this->envs = include($this->adaptorPath);
        return $this->envs;
    }

    function all(){
        return $this->envs;
    }

    function get($envname, $default = null) {
        if (array_key_exists($envname, $this->envs)) {
            return $this->envs[$envname];
        }
        return $default;
    }
}
