<?php

error_reporting(E_ALL); ini_set('display_errors', 1);

require dirname(__FILE__).'/frame/WPTM.php';

$app = WPTM::setup(array(
  'path' => array(
    'base'  => get_template_directory().DIRECTORY_SEPARATOR,
    'app'   => get_template_directory().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR,
    'theme' => get_theme_root()
  ),
  'preload' => array(
    'extension' => array(
      'comment_field_star_rating'
    ),
  ),
  'theme' => array(
    'include' => array(
      'habakiri'
    )
  )
));

# Defaults
$app->frame->vendor->connect('mustache-2.10.0', 'mustache');

# Additional Frameworks
#$app->frame->vendor->connect('fuelphp-1.7.2');
#$app->frame->vendor->connect('laravel-5.2.31', 'laravel');

add_theme_support('post-thumbnails');
