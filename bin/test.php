<?php

require_once dirname(dirname(__FILE__)).'/environment.php';
$line = str_repeat('-', 80);

print "{$line}\nServer Utilities are working\n{$line}\n\n";

/**
* Color testing
*/
print "{$line}\nTesting Colors:\n";

$fgs = Colors::getForegroundColors();
$bgs = Colors::getBackgroundColors();

$count = count($fgs);
for ($i = 0; $i < $count; $i++) {
	echo Colors::getColoredString("Test Foreground colors", $fgs[$i]) . "\t";
	if (isset($bgs[$i])) {
		echo Colors::getColoredString("Test Background colors", null, $bgs[$i]);
	}
	echo "\n";
}
echo "\n";
 
// Loop through all foreground and background colors
foreach ($fgs as $fg) {
	foreach ($bgs as $bg) {
		echo Colors::getColoredString("Test Colors", $fg, $bg) . "\t";
	}
	echo "\n";
}

/**
* System tools
*/
if ($config->system_tools) {
	print "\n{$line}\nSystem tools\n";
	foreach ($config->system_tools AS $key=>$tool) {
		printf("%-20s ", $key);
		
		if (!file_exists($tool)) {
			print "[".Colors::getColoredString('NOEXIST', 'red')."]\n";
		} elseif(!is_executable($tool)) {
			print "[".Colors::getColoredString('NOEXEC', 'red')."]\n";
		} else {
			print "[".Colors::getColoredString('OK', 'green')."]\n";
		}
	}

} else {
	print "{$line}\nNo system tools configured\n";
}
