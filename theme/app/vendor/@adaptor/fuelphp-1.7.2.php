<?php

# THIS IS A SAMPLE OF VENDOR ADAPTOR.

/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2014 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * Set error reporting and display errors settings.  You will want to change these when in production.
 */

/**
 * Website document root
 */
define('DOCROOT', $vendor.'public'.DIRECTORY_SEPARATOR);

/**
 * Path to the application directory.
 */
define('APPPATH', $vendor.'fuel/app/'.DIRECTORY_SEPARATOR);

/**
 * Path to the default packages directory.
 */
define('PKGPATH', $vendor.'fuel/packages/'.DIRECTORY_SEPARATOR);

/**
 * The path to the framework core.
 */
define('COREPATH', $vendor.'fuel/core/'.DIRECTORY_SEPARATOR);

// Get the start time and memory for use later
defined('FUEL_START_TIME') or define('FUEL_START_TIME', microtime(true));
defined('FUEL_START_MEM') or define('FUEL_START_MEM', memory_get_usage());

// Load in the Fuel autoloader
require COREPATH.'classes'.DIRECTORY_SEPARATOR.'autoloader.php';
class_alias('Fuel\\Core\\Autoloader', 'Autoloader');

// Boot the app
require APPPATH.'bootstrap.php';
