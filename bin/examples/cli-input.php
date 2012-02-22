<?php
/**
* This is a test script for parsing cli options for scripts
*/
require_once dirname(dirname(dirname(__FILE__))).'/environment.php';

Console::marquee("Cli Input Test");

$output = Console::input('What is your '.Colors::getColoredString('name', 'yellow'), true);

if (empty($output)) {
	print "Sorry, no input detected. exiting.\n";
	exit(1);
} else {
	print "You typed in: {$output}\n";
}
