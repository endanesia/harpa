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

#[AllowDynamicProperties]
class MX_Controller
{
	public $autoload = array();

	public function __construct()
	{
		$class = str_replace($this->config->item('subclass_prefix'), '', get_class($this));
		log_message('debug', $class.' MX_Controller Initialized');
		Modules::$registry[strtolower($class)] = $this;

		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader', 'core');
		$this->load->initialize($this);

		/* autoload module items */
		$this->load->_autoloader($this->autoload);
	}

	public function __get($class)
	{
		return CI::$APP->$class;
	}
}
