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
class MX_Router extends CI_Router
{
	protected $module;

	public function fetch_module()
	{
		return $this->module;
	}

	public function _set_request($segments = array())
	{
		if ($this->translate_uri_dashes === TRUE)
		{
			foreach (range(0, 1) as $v)
			{
				if (isset($segments[$v]))
				{
					$segments[$v] = str_replace('-', '_', $segments[$v]);
				}
			}
		}

		$segments = $this->locate($segments);

		if ($this->located === -1)
		{
			$this->located = 0;
			show_404();
		}

		if (count($segments) > 0)
		{
			// Set the directory
			if ($this->located)
			{
				$this->set_class($segments[0]);
				if (isset($segments[1]))
				{
					$this->set_method($segments[1]);
				}
				else
				{
					$segments[1] = 'index';
				}
			}
			else
			{
				$this->set_class($segments[0]);
				if (isset($segments[1]))
				{
					$this->set_method($segments[1]);
				}
				else
				{
					$segments[1] = 'index';
				}
			}
		}
		else
		{
			$this->_set_default_controller($segments);
		}

		$this->uri->rsegments = array_values($segments);
		array_unshift($this->uri->rsegments, NULL);
		unset($this->uri->rsegments[0]);
	}

	/** Locate the controller **/
	public function locate($segments)
	{
		$this->located = 0;
		$this->module = '';
		$ext = '.php';

		/* use module route if available */
		if (isset($segments[0]) && $routes = Modules::parse_routes($segments[0], implode('/', $segments)))
		{
			$segments = $routes;
		}

		/* get the segments array elements */
		list($module, $directory, $controller) = array_pad($segments, 3, NULL);

		/* check modules */
		if ($module)
		{
			foreach (Modules::$locations as $location => $offset)
			{
				/* module controllers folder exists? */
				if (is_dir($source = $location . $module . '/controllers/'))
				{
					$this->module = $module;
					$this->directory = $offset . $module . '/controllers/';

					/* module sub-controller exists? */
					if ($directory)
					{
						/* module sub-directory exists? */
						if (is_dir($source . $directory . '/'))
						{
							$source = $source . $directory . '/';
							$this->directory .= $directory . '/';

							if ($controller)
							{
								if (is_file($source . ucfirst($controller) . $ext))
								{
									$this->located = 3;
									return array_slice($segments, 2);
								}
							}

							if (is_file($source . ucfirst($directory) . $ext))
							{
								$this->located = 2;
								return array_slice($segments, 1);
							}
						}

						if (is_file($source . ucfirst($directory) . $ext))
						{
							$this->located = 2;
							return array_slice($segments, 1);
						}
					}

					if (is_file($source . ucfirst($module) . $ext))
					{
						$this->located = 1;
						return $segments;
					}
				}
			}
		}

		return $segments;
	}

	public function _set_default_controller($segments = array())
	{
		if (empty($this->default_controller))
		{
			show_error('Unable to determine what should be displayed. A default route has not been specified in the routing file.');
		}

		if (sscanf($this->default_controller, '%[^/]/%s', $class, $method) !== 2)
		{
			$method = 'index';
		}

		if ( ! is_file(APPPATH . 'controllers/' . ucfirst($class) . '.php'))
		{
			// check for modules default controller
			return $this->_set_request(array($class, $method));
		}

		$this->set_class($class);
		$this->set_method($method);

		// Assign routed segments, index starting from 1
		$this->uri->rsegments = array(
			1 => $class,
			2 => $method
		);

		log_message('debug', 'No URI present. Default controller set.');
	}
}
