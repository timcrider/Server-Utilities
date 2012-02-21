<?php
/**
* Server Utilities Configuration
*/
$config = new Base;

/**
* Set system tool locations
*/
$config->system_tools = array(
	'httpd'      => '/usr/sbin/httpd',
	'apachectl'  => '/usr/sbin/apachectl',
	'mysql'      => '/usr/bin/mysql',
	'mysqladmin' => '/usr/bin/mysqladmin',
	'mysqldump'  => '/usr/bin/mysqldump',
	'php'        => '/usr/bin/php'
	'adduser'    => '/usr/sbin/adduser',
	'service'    => '/sbin/service'
);

/**
* Database configuration
*/
$config->database = array(
	'adapter'    => 'Pdo_MySQL',
	'connection' => array(
		'host'           => '',
		'username'       => '',
		'password'       => '',
		'charset'        => 'utf8',
		'driver_options' => array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
		)
	),
	'options'    => array(
		'quote_identifiers' => true
	)
);
