<?php
/**
 * PHPRouter
 * @author All-3kcis <contact@all-3kcis.fr>
 */


require_once ('config/config.php'); // Config file


USE all3kcis\PHPRouter\Router;


// Default route with callback function
Router::add('', function(){
	echo '<h1>Hello World !</h1>';
	echo '<p>This is a basic url router.</p>';

	echo '<h2>Test routes :</h2>';
	$routes = Router::debugGetRoutes();
	if(!empty($routes)){
		foreach ($routes as $route) {
			echo '<ul>';
			if(!empty($route)){
				echo '<li><a href="'.APP_URL_ROOT.$route.'?params=here&id=1337&author=all3kcis">'.$route.'</a></li>';
			}
			echo '</ul>';
		}
	}
});

// Test closure function
Router::add('test-closure', function(){
	echo '<h1>Hello World !</h1>';
	echo '<p>This is a closure function</p>';
	echo '<a href="'.APP_URL_ROOT.'">Return home</a>';
});

// Test option with closure function
Router::add('test-option-auth-closure', function(){
	echo 'Hello World !';
}, ['auth']);

// Test option with class
Router::add('test-option-auth-class', 'Unknown', ['auth']);

// Test unknown class
Router::add('unknown', 'Unknown');

// Run default method
Router::add('classTest-default-method', 'Test');

// Run test method
Router::add('classTest-other-method', 'Test@other');

// Run params method
Router::add('classTest-params-method', 'Test@params');


Router::fire();