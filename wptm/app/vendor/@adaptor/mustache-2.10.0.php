<?php

require $vendor.'/src/Mustache/Autoloader.php';
Mustache_Autoloader::register();

return new Mustache_Engine(array(
  'template_class_prefix' => '__MyTemplates_',
  'cache' => WPTM::config('path.app').'/tmp/cache/mustache',
  'cache_file_mode' => 0600,
  'cache_lambda_templates' => true,
  'logger' => new Mustache_Logger_StreamLogger('php://stderr'),
  'strict_callables' => true,
  'pragmas' => array(Mustache_Engine::PRAGMA_FILTERS),
));
