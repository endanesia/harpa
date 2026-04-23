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

class Modules
{
	public static $routes;
	public static $registry = array();
	public static $locations;

	/**
	 * Run a module controller method
	 * Output from module is buffered and returned.
	 */
	public static function run($module)
	{
		$method = 'index';

		if (($pos = strrpos($module, '/')) != FALSE)
		{
			$method = substr($module, $pos + 1);
			$module = substr($module, 0, $pos);
		}

		if ($class = self::load($module))
		{
			if (method_exists($class, $method))
			{
				ob_start();
				$args = func_get_args();
				$output = call_user_func_array(array($class, $method), array_slice($args, 1));
				$buffer = ob_get_clean();
				return ($output !== NULL) ? $output : $buffer;
			}
		}

		log_message('error', "Module controller failed to run: {$module}/{$method}");
	}

	/** Load a module controller **/
	public static function load($module)
	{
		if (is_array($module))
		{
			$key = key($module);
			$params = $module[$key];
			$module = $key;
		}
		else
		{
			$params = NULL;
		}

		/* get the requested controller class name */
		$alias = strtolower(basename($module));

		/* create or return an existing controller from the registry */
		if ( ! isset(self::$registry[$alias]))
		{
			/* find the controller */
			list($class) = CI::$APP->router->locate(explode('/', $module));

			/* controller cannot be located */
			if (empty($class)) return;

			/* set the module directory */
			$path = APPPATH . 'controllers/' . CI::$APP->router->directory;

			/* load the controller class */
			$class = ucfirst($class);

			if ( ! class_exists($class, FALSE))
			{
				$filepath = $path . $class . '.php';
				if (is_file($filepath))
				{
					require_once($filepath);
				}
			}

			/* controller class not found, skip it */
			if ( ! class_exists($class, FALSE))
			{
				return;
			}

			/* create and register the new controller */
			$controller = new $class($params);
			self::$registry[$alias] = $controller;
		}

		return self::$registry[$alias];
	}

	/** Library base class autoload **/
	public static function autoload($class)
	{
		/* don't autoload CI_ prefixed classes or those using the config subclass_prefix */
		if (strstr($class, 'CI_') OR strstr($class, config_item('subclass_prefix')))
			return;

		/* autoload the CI base class from MX/Base.php */
		if ($class === 'CI')
		{
			if (is_file($location = dirname(__FILE__) . '/Base.php'))
			{
				include_once $location;
				return;
			}
		}

		/* autoload Modular Extensions MX core classes */
		if (strstr($class, 'MX_'))
		{
			if (is_file($location = dirname(__FILE__) . '/' . substr($class, 3) . '.php'))
			{
				include_once $location;
				return;
			}
			show_error('Failed to load MX core class: ' . $class);
		}

		/* autoload core classes */
		if (is_file($location = APPPATH . 'core/' . $class . '.php'))
		{
			include_once $location;
			return;
		}

		/* autoload library classes */
		if (is_file($location = APPPATH . 'libraries/' . $class . '.php'))
		{
			include_once $location;
			return;
		}
	}

	/** Find a file **/
	public static function find($file, $module, $base)
	{
		$segments = explode('/', $file);

		$file = array_pop($segments);
		$file_ext = (pathinfo($file, PATHINFO_EXTENSION)) ? $file : $file . '.php';

		$path = ltrim(implode('/', $segments) . '/', '/');

		$module ? $modules[$module] = $path : $modules = array();

		if ( ! empty($segments))
		{
			$modules[array_shift($segments)] = ltrim(implode('/', $segments) . '/', '/');
		}

		foreach (self::$locations as $location => $offset)
		{
			foreach ($modules as $module => $subpath)
			{
				$fullpath = $location . $module . '/' . $base . $subpath;

				if ($base === 'libraries/' OR $base === 'models/')
				{
					if (is_file($fullpath . ucfirst($file_ext))) return array($fullpath, ucfirst($file));
				}

				if (is_file($fullpath . $file_ext)) return array($fullpath, $file);
			}
		}

		return array(FALSE, $file);
	}

	/** Parse module routes **/
	public static function parse_routes($module, $uri)
	{
		/* load the route file */
		if ( ! isset(self::$routes[$module]))
		{
			list($path) = self::find('routes', $module, 'config/');

			if ($path == FALSE) return;

			$route = array();
			if (is_file($path . 'routes.php'))
			{
				include($path . 'routes.php');
			}

			self::$routes[$module] = $route;
		}

		if ( ! isset(self::$routes[$module])) return;

		/* parse module routes */
		foreach (self::$routes[$module] as $key => $val)
		{
			$key = str_replace(array(':any', ':num'), array('[^/]+', '[0-9]+'), $key);

			if (preg_match('#^' . $key . '$#', $uri, $match))
			{
				if ( ! is_string($val) && is_callable($val))
				{
					array_shift($match);
					$val = call_user_func_array($val, $match);
				}
				elseif (strpos($val, '$') !== FALSE && strpos($key, '(') !== FALSE)
				{
					$val = preg_replace('#^' . $key . '$#', $val, $uri);
				}

				return explode('/', $module . '/' . $val);
			}
		}
	}

	/** Load a module file **/
	public static function load_file($file, $path, $type = 'other', $result = TRUE)
	{
		$file = str_replace('.php', '', $file);
		$location = $path . $file . '.php';

		if ($type === 'other')
		{
			if (class_exists($file, FALSE))
			{
				log_message('debug', "File already loaded: {$location}");
				return $result;
			}
			include_once $location;
		}
		else
		{
			include $location;
			if (isset($$type) && is_array($$type))
			{
				return $$type;
			}
		}

		log_message('debug', "File loaded: {$location}");
		return $result;
	}
}

/* register the autoloader */
spl_autoload_register('Modules::autoload');

/* set the module locations from config */
Modules::$locations = array(
	APPPATH . 'modules/' => '../modules/',
);
