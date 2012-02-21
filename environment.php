<?php
/**
* Server Utilities environment setup
*
*  Setup the core environment for all of the server utilities. This particular environment
* is isolated from the rest of the server and its libraries. This helps maintain the
* consistency across multiple machines, or machines where not all the helpers are installed.
*
* @author Timothy M. Crider <timcrider@gmail.com>
*/

if (empty($_SERVER['USER']) || $_SERVER['USER'] != 'root') {
	print "This utility was intended to run as root. '{$_SERVER['USER']}' is not recognized.\n";
	exit(1);
}

define('BASEDIR', dirname(__FILE__).'/');

$tryConfigFile = BASEDIR.'config/configuration.php';

if (!file_exists($tryConfigFile) || !is_readable($tryConfigFile)) {
	print "Unable to load configuration file '{$tryConfigFile}'.\n";
	exit(1);
}

// Isolate our environment to only this area
$pathing = array(
	BASEDIR.'src/',
	BASEDIR.'vendor/',
	BASEDIR.'vendor/ZendFramework/library/',
	BASEDIR.'src/'
);

ini_set('include_path', implode(':', $pathing));

try {
	// Enable PSR0 autoloading through Zend Framework
	require_once 'Zend/Loader/Autoloader.php';
	$autoloader = Zend_Loader_Autoloader::getInstance();
	$autoloader->setFallbackAutoloader(true);

	// Load configuration
	require_once $tryConfigFile;

} catch (Zend_Exception $e) {
	print "There was an error loading the environment: ".$e->getMessage()."\n";
	exit(1);
}
