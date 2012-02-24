<?php
/**
* Website manager 
*/
require_once dirname(dirname(__FILE__)).'/environment.php';

Console::marquee('Server Utilities: Website Management Tool');
$webObj  = new Website;

// Process cli

try {
   $Options = array(
   	'help|h' => 'Help',
		'docroot|d=s' => "DocumentRoot",
		'servername|s=s' => "ServerName"
   );

   $Opts = new Zend_Console_Getopt($Options);
   $Opts->parse();
} catch (Zend_Console_Getopt_Exception $e) {
	print $e->getUsageMessage();
	exit(1);
}

if (!empty($Opts->help)) {
	print $Opts->getUsageMessage();
	exit;
}

if (!empty($Opts->docroot)) {
	$response = $webObj->execute("set DocumentRoot {$Opts->docroot}");
	print $response->message;
}

if (!empty($Opts->servername)) {
	$response = $webObj->execute("set ServerName {$Opts->servername}");
	print $response->message;
}


// Handle interactive mode
$running = true;

while ($running) {
	$input = Console::input("Webman>", 'required');

	switch (strtolower($input)) {
		case 'quit':
		case 'exit':
		case 'q':
		case 'x':
			$running = false;
			break;
			
		default:
			if (!empty($input))  {
				$response = $webObj->execute($input);
				print $response->message;
			}
			break;
	}

}

Console::write("Exiting\n");
