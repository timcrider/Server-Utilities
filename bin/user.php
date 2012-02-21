<?php

require_once dirname(dirname(__FILE__)).'/environment.php';
$line = str_repeat('-', 80);

if (empty($argv[1])) {
	print "Usage: {$argv[0]} username\n";
	exit(1);
}

$userObj = new SystemUser;

if ($user = $userObj->profile($argv[1])) {
	print_r($user);
} else {
	print "Sorry '{$argv[1]}' does not exist.\n";
}
