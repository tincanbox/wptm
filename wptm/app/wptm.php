<?php
/*
Plugin Name: WordPress Theme by Matooy
Description: 
Version: 1.0.0
Author: Matooy
License: GPLv2 or later
Text Domain: wptm
*/

if(!function_exists('add_action')){
  exit;
}

#register_activation_hook( __FILE__, array('WPTM', 'plugin_activation' ) );
#register_deactivation_hook( __FILE__, array('WPTM', 'plugin_deactivation' ) );

include_once dirname(__FILE__).'/bootstrap.php';

# Sometimes, emoji related action/filter(s) occures 'Use of undefined constant' error.
!defined('SCRIPT_DEBUG') && define('SCRIPT_DEBUG', true);
