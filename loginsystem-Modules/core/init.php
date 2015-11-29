<?php
//auto load classes - initialise every page

session_start(); //allow users to login

//pull config information (big time saver)

$GLOBALS['config'] = array(
		'mysql' => array(
			'host' => '127.0.0.1',
			'username' => 'root',
			'db' => 'karisma_test'
		),
		'remember' => array(
				'cookie_name' => 'hash',
				'cookie_expiry' => 604800
		),
		'session' => array(
				'session_name'=> 'user'
		)
);
		//only requires classes once needed, and writes them down
spl_autoload_register(function($class) { 
	require_once 'classes/'. $class . 'php';
});

require_once 'functions/sanitize.php';


