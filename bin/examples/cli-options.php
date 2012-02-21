<?php
/**
* This is a test script for parsing cli options for scripts
*/
require_once dirname(dirname(dirname(__FILE__))).'/environment.php';

$line = str_repeat('-', 80);

/**
* Setup the options list
*/
try {
	$Options = array(
		'first|f=s' => 'First Parameter <Required String>',
		'second|s' => 'Second Parameter',
		'third|t=i' => 'Third Parameter <Required Integer>',
		'long-form|lf=s' => 'Long Parameter <Required String>'
	);
	
	$Opts = new Zend_Console_Getopt($Options);
	$Opts->parse();
} catch (Zend_Console_Getopt_Exception $e) {
	print $e->getUsageMessage();
	exit;
}

/**
* Quick display of the script name
*/
print "Running: {$argv[0]}\n";

/**
* Check all of our required options for values
*/
if (empty($Opts->first)) {
	print "<First> is required\n";
	print $Opts->getUsageMessage();
	exit;
}

if (empty($Opts->third)) {
	print "<Third> is required\n";
	print $Opts->getUsageMessage();
	exit;
}

if (empty($Opts->lf)) {
	print "<Long Form> is required\n";
	print $Opts->getUsageMessage();
	exit;
}

/**
* Show a list of all incoming options
*/
$optArray = json_decode($Opts->toJson());
print "\n{$line}\nShow all options\n{$line}\n";
foreach ($optArray->options AS $opt) {
	print "{$opt->option->flag} => {$opt->option->parameter}\n";
}

/**
* Show direct access to parameters
*/
print "\n{$line}\nDirect Access\n{$line}\n";
print "First: {$Opts->first}\n";
print "Second: {$Opts->second}\n";
print "Third: {$Opts->third}\n";
print "Long Form: {$Opts->lf}\n";
