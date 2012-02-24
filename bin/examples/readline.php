<?php
/**
* This is a scratch pad for readline testing
*/
require_once dirname(dirname(dirname(__FILE__))).'/environment.php';

/**
* Simple readline callback function
*/
$fruits = array(
	'apple',
	'banana',
	'orange',
	'peach'
);

function callback_fruit($input, $index) {
	global $fruits;

	$rl_info    = readline_info();
	$full_input = substr($rl_info['line_buffer'], 0, $rl_info['end']);

   return $fruits;
}

/**
* Simple readline callback object
*/
class Fruit {
	public $fruit = array(
		'apple',
		'banana',
		'orange',
		'peach'
	);

	public function register_callback() {
		readline_completion_function(array($this, 'callback'));
	}
	
	public function callback($input, $index) {
		return $this->fruit;
	}
}

/**
* Simple readline callback static object
*/
class staticFruit {
	public static $fruit = array(
		'apple',
		'banana',
		'orange',
		'peach'
	);
	
	public function register_callback() {
		readline_completion_function(array('staticFruit', 'callback'));
	}

	public static function callback($input, $index) {
		return self::$fruit;
	}
}


///////////////////////////////////////////////////////////////////////////////
// Run it all

// Function
readline_completion_function('callback_fruit');
$FNinput = readline("(fn) Fruit: ");

// Object
$fr = new Fruit;
$fr->register_callback();
$OBJinput = readline("(obj) Fruit: ");

// Static
staticFruit::register_callback();
$STAinput = readline("(static) Fruit: ");

// Show outputs
print "Function picked: {$FNinput}\n";
print "Object picked: {$OBJinput}\n";
print "Static picked: {$STAinput}\n";
