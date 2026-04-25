<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Modular Extensions - HMVC
 *
 * Adapted from wiredesignz/codeigniter-modular-extensions-hmvc
 * Updated for PHP 8.2+ compatibility
 *
 * @copyright	Copyright (c) 2015 Wiredesignz
 * @license		http://opensource.org/licenses/MIT
 */

/**
 * CI is a static reference holder for the main application controller.
 * Used by HMVC modules to access the main CI instance via CI::$APP.
 */
class CI
{
	public static $APP;
}
