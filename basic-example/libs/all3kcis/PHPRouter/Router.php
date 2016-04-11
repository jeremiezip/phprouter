<?php 
/**
 * PHPRouter
 * @author All-3kcis <contact@all-3kcis.fr>
 */

namespace all3kcis\PHPRouter;

class Router {

	private static $instance;
	private static $routes = array();
	private static $options = array(
		'default_method' => 'pageDefault'
	);
	private static $routesOptions = array();
	

	private function __construct(){
	}

	public static function getInstance(){
		if (!self::$instance instanceof self)
		{
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Set option
	 * 
	 * @param string $optionName
	 * @param string $value name of "RoutesOption"
	 * @return void
	 */
	public static function setOption($optionName, $value){
		self::$options[$optionName]=$value;
	}

	/**
	 * Set option route
	 * 
	 * @param string $optionName
	 * @param string|callable $object closure
	 * @return void
	 */
	public static function setRoutesOption($optionName, $object){
		self::$routesOptions[$optionName]=$object;
	}

	/**
	 * Create route
	 * 
	 * @param string $route
	 * @param string|callable $call closure
	 * @return void
	 */
	public static function add($route, $call, $option=[]){
		self::$routes[$route]=compact('call','option');
	}

	/**
	 * Redirects the user
	 * 
	 * @return void
	 */
	public static function fire(){

		if(!empty(self::$routes[self::$options['url']])){
			if(is_object(self::$routes[self::$options['url']]['call'])){
				$route=self::$routes[self::$options['url']];
				self::runRoutesOptions($route);
				call_user_func($route['call']);
				exit;
			}elseif(is_string(self::$routes[self::$options['url']]['call'])){
				$route=self::$routes[self::$options['url']];
				self::runRoutesOptions($route);
			}else{
				echo 'ERROR. Route must be a callback or a string'; exit;
			}
		}else{
			die('Empty ROUTE');
		}

		if(preg_match('/^([a-z0-9]{1,})(@{1}([a-z0-9]{1,})){0,1}$/i', $route['call'], $matches)){
			// $matches[1] = controller
			// $matches[3] = method
			if(class_exists($matches[1])){
				if(defined($matches[1].'::DESIGN_PATERN')){
					if($matches[1]::DESIGN_PATERN == 'multiton'){
						$controller = $matches[1]::getInstance('self');
					}else
						$controller = $matches[1]::getInstance(); // singleton
				}else{
					$controller = new $matches[1]();
				}
				
				$method = (!empty($matches[3]))?$matches[3]:self::$options['default_method'];
			}else{
				die('Class "'.$matches[1].'" not found <a href="'.(defined('APP_URL_ROOT') ?APP_URL_ROOT:'').'">Return home</a>');
			}
			$controller->$method();
		}
	}

	/**
	 * Return routes, debug function
	 * 
	 * @return array
	 */
	public static function debugGetRoutes(){
		return array_keys(self::$routes);
	}

	private static function runRoutesOptions($route){
		// Your options
		if(!empty($route['option'])){
			foreach($route['option'] as $option){
				if(is_object(self::$routesOptions[$option])){
					call_user_func(self::$routesOptions[$option]);
				}
			}
		}
	}
}
