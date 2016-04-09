<?php

require_once ('libs/all3kcis/PHPRouter/Router.php');

$url = getUrl(); // Or build your URL
define('URL', $url);
all3kcis\PHPRouter\Router::setOption('url', $url);

all3kcis\PHPRouter\Router::setRoutesOption('auth', function(){
	// Example
	$user = false;
	if($user !== true)
		die('ACCESS DENY, Not Auth. <a href="'.APP_URL_ROOT.'">Return</a>');
});

class Test{

	public function pageDefault(){
		echo 'Hello World ! Test->pageDefault() Default method <br />';
		echo '<a href="'.APP_URL_ROOT.'">Return home</a>';
	}

	public function other(){
		echo 'Hello World ! Test->other() <br />';
		echo '<a href="'.APP_URL_ROOT.'">Return home</a>';
	}

	public function params(){
		echo 'Hello World ! Test->params() <br />';
		echo '<a href="'.APP_URL_ROOT.'">Return home</a>';
		$params = json_encode($_GET);
		echo '<h2>Params :</h2>';
		echo '<pre>';
		echo $params;
		echo '</pre>';
	}
}


function getUrl(){
	$t=str_replace("index.php", "", $_SERVER["SCRIPT_NAME"]);
	define('APP_URL_ROOT',$t);
	$route = explode('?',$_SERVER["REQUEST_URI"])[0];
	if($t == '/'){
		$route = preg_replace('/^\//', '', $route);
	}else{
		$route = str_replace($t, '', $route);
	}
	return $route;
}