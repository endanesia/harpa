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

/* load MX dependencies */
require_once dirname(__FILE__) . '/Modules.php';

#[AllowDynamicProperties]
class MX_Loader extends CI_Loader
{
	protected $_module;

	public $_ci_autoloader = array();

	/**
	 * Initialize the module Loader
	 *
	 * @param object $controller
	 */
	public function initialize($controller = NULL)
	{
		/* load the CI base class if not already loaded */
		if ( ! class_exists('CI', FALSE))
		{
			require_once dirname(__FILE__) . '/Base.php';
		}

		/* set CI::$APP to the main controller instance */
		if ( ! isset(CI::$APP))
		{
			$instance = get_instance();
			if ($instance !== NULL)
			{
				CI::$APP = $instance;
			}
		}

		/* set the module name */
		if (isset(CI::$APP) && CI::$APP !== NULL)
		{
			$this->_module = CI::$APP->router->fetch_module();
		}

		parent::initialize();

		/* autoload module items */
		if (is_array($this->_ci_autoloader))
		{
			$this->_autoloader($this->_ci_autoloader);
		}

		return $this;
	}

	/** Add a module path loader variables **/
	public function _add_module_paths($module = '')
	{
		if (empty($module)) return;

		foreach (Modules::$locations as $location => $offset)
		{
			/* only add a module path if it exists */
			if (is_dir($module_path = $location . $module . '/'))
			{
				array_unshift($this->_ci_library_paths, $module_path);
				array_unshift($this->_ci_model_paths, $module_path);
				$this->_ci_view_paths = array($module_path . 'views/' => TRUE) + $this->_ci_view_paths;
				break;
			}
		}
	}

	/** Load a module config file **/
	public function config($file, $use_sections = FALSE, $fail_gracefully = FALSE)
	{
		return CI::$APP->config->load($file, $use_sections, $fail_gracefully, $this->_module);
	}

	/** Load the database drivers **/
	public function database($params = '', $return = FALSE, $query_builder = NULL)
	{
		if ($return === FALSE && $query_builder === NULL &&
			isset(CI::$APP->db) && is_object(CI::$APP->db) && ! empty(CI::$APP->db->conn_id))
		{
			return FALSE;
		}

		return parent::database($params, $return, $query_builder);
	}

	/** Load a module helper **/
	public function helper($helpers = array())
	{
		if (is_array($helpers)) return $this->helpers($helpers);

		if (isset($this->_ci_helpers[$helpers])) return;

		list($path, $_helper) = Modules::find($helpers . '_helper', $this->_module, 'helpers/');

		if ($path !== FALSE)
		{
			Modules::load_file($_helper, $path);
			$this->_ci_helpers[$_helper] = TRUE;
		}
		else
		{
			parent::helper($helpers);
		}

		return $this;
	}

	/** Load an array of helpers **/
	public function helpers($helpers = array())
	{
		foreach ($helpers as $_helper) $this->helper($_helper);
		return $this;
	}

	/** Load a module language file **/
	public function language($langfile, $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '')
	{
		CI::$APP->lang->load($langfile, $idiom, $return, $add_suffix, $alt_path, $this->_module);
		return $this;
	}

	public function languages($languages)
	{
		foreach($languages as $_language) $this->language($_language);
		return $this;
	}

	/** Load a module library **/
	public function library($library, $params = NULL, $object_name = NULL)
	{
		if (is_array($library)) return $this->libraries($library);

		$class = strtolower(basename((string) $library));

		if (isset($this->_ci_classes[$class]) && $_alias = $this->_ci_classes[$class])
		{
			if (isset(CI::$APP) && isset(CI::$APP->$_alias))
			{
				return CI::$APP->$_alias;
			}
		}

		($_alias = strtolower((string) $object_name)) OR $_alias = $class;

		list($path, $_library) = Modules::find($library, $this->_module, 'libraries/');

		/* load library config file as params */
		if ($params == NULL)
		{
			list($path2, $file) = Modules::find($_alias, $this->_module, 'config/');
			($path2) && $params = Modules::load_file($file, $path2, 'config');
		}

		if ($path !== FALSE)
		{
			$this->_mx_load_library($path, $_library, $params, $object_name);
			$this->_ci_classes[$class] = $_alias;
			return $this;
		}

		return parent::library($library, $params, $object_name);
	}

	/** Load an array of libraries **/
	public function libraries($libraries)
	{
		foreach ($libraries as $library => $alias)
		{
			(is_int($library)) ? $this->library($alias) : $this->library($library, NULL, $alias);
		}
		return $this;
	}

	/** Load a module model **/
	public function model($model, $object_name = NULL, $connect = FALSE)
	{
		if (is_array($model)) return $this->models($model);

		($_alias = $object_name) OR $_alias = basename($model);

		if (in_array($_alias, $this->_ci_models, TRUE))
		{
			return $this;
		}

		/* check module */
		list($path, $_model) = Modules::find(strtolower($model), $this->_module, 'models/');

		if ($path != FALSE)
		{
			$this->_ci_models[] = $_alias;
			Modules::load_file($_model, $path);
			$model = ucfirst($_model);

			CI::$APP->$_alias = new $model();
			return $this;
		}

		return parent::model($model, $object_name, $connect);
	}

	/** Load an array of models **/
	public function models($models)
	{
		foreach ($models as $_model) $this->model($_model);
		return $this;
	}

	/** Load a module controller **/
	public function module($module, $params = NULL)
	{
		if (is_array($module)) return $this->modules($module);

		$_alias = strtolower(basename($module));
		CI::$APP->$_alias = Modules::load(array($module => $params));
		return $this;
	}

	/** Load an array of controllers **/
	public function modules($modules)
	{
		foreach ($modules as $_module) $this->module($_module);
		return $this;
	}

	/** Load a module plugin **/
	public function plugin($plugin)
	{
		if (is_array($plugin)) return $this->plugins($plugin);

		if (isset($this->_ci_plugins[$plugin]))
			return;

		list($path, $_plugin) = Modules::find($plugin . '_pi', $this->_module, 'plugins/');

		if ($path !== FALSE && ! is_file($_plugin))
		{
			Modules::load_file($_plugin, $path);
			$this->_ci_plugins[$plugin] = TRUE;
		}
		else
		{
			parent::plugin($plugin);
		}

		return $this;
	}

	/** Load an array of plugins **/
	public function plugins($plugins)
	{
		foreach ($plugins as $_plugin) $this->plugin($_plugin);
		return $this;
	}

	/** Load a module view **/
	public function view($view, $vars = array(), $return = FALSE)
	{
		list($path, $_view) = Modules::find($view, $this->_module, 'views/');

		if ($path != FALSE)
		{
			$this->_ci_view_paths = array($path => TRUE) + $this->_ci_view_paths;
			$view = $_view;
		}

		return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_prepare_view_vars($vars), '_ci_return' => $return));
	}

	/** Autoload module items **/
	public function _autoloader($autoload)
	{
		$path = FALSE;

		if ($this->_module)
		{
			list($path, $file) = Modules::find('autoload', $this->_module, 'config/');
		}

		/* module autoload file */
		if ($path != FALSE)
		{
			$autoload = array_merge(Modules::load_file($file, $path, 'autoload'), $autoload);
		}

		/* nothing to do */
		if (count($autoload) == 0) return;

		/* autoload config */
		if (isset($autoload['config']))
		{
			foreach ($autoload['config'] as $key => $val)
			{
				$this->config($val);
			}
		}

		/* autoload helpers, plugins, languages */
		foreach (array('helper', 'plugin', 'language') as $type)
		{
			if (isset($autoload[$type]))
			{
				foreach ($autoload[$type] as $item)
				{
					$this->$type($item);
				}
			}
		}

		/* autoload database & libraries */
		if (isset($autoload['libraries']))
		{
			if (in_array('database', $autoload['libraries']))
			{
				/* autoload database */
				if ( ! $db = CI::$APP->config->item('database'))
				{
					$db['params'] = 'default';
					$db['active_record'] = TRUE;
				}
				$this->database($db['params'], FALSE, $db['active_record']);
				$autoload['libraries'] = array_diff($autoload['libraries'], array('database'));
			}

			/* autoload libraries */
			foreach ($autoload['libraries'] as $library)
			{
				$this->library($library);
			}
		}

		/* autoload models */
		if (isset($autoload['model']))
		{
			foreach ($autoload['model'] as $model => $alias)
			{
				(is_int($model)) ? $this->model($alias) : $this->model($model, $alias);
			}
		}

		/* autoload module controllers */
		if (isset($autoload['modules']))
		{
			foreach ($autoload['modules'] as $autoload_module)
			{
				($controller = Modules::load($autoload_module)) && $this->module($controller);
			}
		}
	}

	/**
	 * Internal CI library loader (for HMVC)
	 */
	protected function _mx_load_library($path, $library, $params = NULL, $object_name = NULL)
	{
		$class = ucfirst($library);

		// Is this a class extension request?
		$subclass = config_item('subclass_prefix') . $class;

		if (file_exists($path . $subclass . '.php'))
		{
			$baseclass = BASEPATH . 'libraries/' . $class . '.php';

			if ( ! file_exists($baseclass))
			{
				log_message('error', 'Unable to load the requested class: ' . $class);
				show_error('Unable to load the requested class: ' . $class);
			}

			if ( ! class_exists('CI_' . $class, FALSE))
			{
				require($baseclass);
			}

			if ( ! class_exists($subclass, FALSE))
			{
				require($path . $subclass . '.php');
			}

			return $this->_ci_init_library($subclass, config_item('subclass_prefix'), $params, $object_name);
		}

		// Lets search for the requested library file and load it.
		if ( ! class_exists($class, FALSE))
		{
			if (file_exists($path . $class . '.php'))
			{
				require($path . $class . '.php');
			}
		}

		// safety check
		if ( ! class_exists($class, FALSE) && ! class_exists('CI_' . $class, FALSE))
		{
			log_message('error', 'Unable to load the requested class: ' . $class);
			show_error('Unable to load the requested class: ' . $class);
		}

		return $this->_ci_init_library($class, '', $params, $object_name);
	}
}
