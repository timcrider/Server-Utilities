<?php
/**
* Website creation object (prototype)
*/
class Website {
	protected $ip;
	protected $user;
	protected $group;
	protected $documentRoot;
	protected $logDirectory;
	protected $logPrefix;
	protected $serverName;
	protected $serverAdmin;
	protected $errorDocument;
	protected $errorLog;
	protected $customLog;
	protected $port          = 80;
	protected $serverAliases = array();
	protected $scripAliases  = array();
	protected $phpvars       = array();
	protected $history       = array();

	/**
	*
	*/	
	public function __construct() {
		$this->phpvars = array(
			'php_flag'        => array(),
			'php_value'       => array(),
			'php_admin_value' => array()
		);

	}
	
	/**
	*
	*/
	public function execute($command) {
		$stack    = preg_split('/ /', $command);
		$command  = array_shift($stack);
		$response = new Base;
		$this->history[] = $command;
		
		switch (strtolower($command)) {
			//////////////////////////////////////////////////////////////////////
			// Set parameter
			case 'set':
				$option = array_shift($stack);

				switch (strtolower($option)) {
					case 'servername':
						$value = array_shift($stack);
						$this->serverName  = $value;
						$response->success = true;
						$response->message = Console::formatStatus("ServerName set to '{$value}'", "OK", "green");
						break;
						
					case 'documentroot':
						$value = array_shift($stack);
						$value = preg_replace('@/$@', '', $value);
						if (!file_exists($value) || !is_dir($value)) {
							$response->message  = Console::formatStatus("Invalid document root '{$value}'", "FAIL", "red");
						} else {
							$this->documentRoot = $value;
							$response->success  = true;
							$response->message  = Console::formatStatus("DocumentRoot set to '{$this->documentRoot}'", "OK", "green");
						}
						break;
						
					case 'ip':
						$value = array_shift($stack);
						// Do ip check or '*' check here
						$this->ip          = $value;
						$response->success = true;
						$response->message = Console::formatStatus("IP set to '{$this->ip}'", "OK", "green");
						break;

					case 'user':
						$value = array_shift($stack);
						// Do valid user check here
						$this->user        = $value;
						$response->success = true;
						$response->message = Console::formatStatus("User set to '{$this->user}'", "OK", "green");
						break;

					case 'group':
						$value = array_shift($stack);
						// Do valid group check here
						$this->group       = $value;
						$response->success = true;
						$response->message = Console::formatStatus("Group set to '{$this->group}'", "OK", "green");
						break;

					case 'port':
						$value = array_shift($stack);
						if (!preg_match('/[^0-9]/', $value) && $value > 0 && $value <= 65535) {
							$this->port        = $value;
							$response->success = true;
							$response->message = Console::formatStatus("Port set to '{$this->port}'", "OK", "green");
						} else {
							$response->message = Console::formatStatus("Error setting port to '{$value}'", "FAIL", "red");
						}
						break;
						
					default:
						$response->message = Console::formatStatus("Uknown option '{$option}'", "FAIL", "red");
						break;
				}
				break;

			//////////////////////////////////////////////////////////////////////
			// Add parameter to a stack
			case 'add':
				$response->message = "Adding\n";
				break;
			
			//////////////////////////////////////////////////////////////////////
			// Get a parameter from the stack
			case 'get':
				$response->message = "Getting\n";
				break;
			
			//////////////////////////////////////////////////////////////////////
			// Show all parameters in the stack
			case 'show':
				$response->message = "Show\n";
				break;

			//////////////////////////////////////////////////////////////////////
			// Save the file out
			case 'save':
				$response->message = "Saving\n";
				break;

			//////////////////////////////////////////////////////////////////////
			// Render the virtual host configuration
			case 'render':
				$tpl = $this->render();
				$line = str_repeat('-', 80);
				$response->message = "Rendering\n{$line}\n{$tpl}\n{$line}\n";
				break;

			//////////////////////////////////////////////////////////////////////
			// Show the help message
			case 'help':
			case '?':
				$response->success = true;
				$response->message = "Eventually some help will come.\n";
				break;
			
			//////////////////////////////////////////////////////////////////////
			// Handle unknown commands
			default:
				print "Unknown command '{$command}'\n";
				break;
		}
		
		return $response;
	}

	/**
	*
	*/	
	public function render() {
		// hack hack for demo only.
		$config = Zend_Registry::get('config');
		
		// Error checking will go here
		
		$tpl = file_get_contents($config->apache['virtualhostConfig']);

		// Template variables
		$regex = array(
			'/\{document_root\}/',
			'/\{server_name\}/',
			'/\{server_alias\}/',
			'/\{logs\}/',
			'/\{ip\}/',
			'/\{port\}/',
			'/\{user\}/',
			'/\{group\}/',
			'/\{script_alias\}/',
			'/\{status_documents\}/',
			'/\{php_values\}/',
			'/\{generated_on\}/'
		);
		
		// Template replacements
		$reps = array(
			$this->documentRoot,
			$this->serverName,
			'# Server Aliases',
			'# Logging',
			$this->ip,
			$this->port,
			$this->user,
			$this->group,
			'# Script Aliases',
			'# Status Documents',
			'# PHP Values',
			date('Y/m/d H:i:s')
		);

		// Render out
		return preg_replace($regex, $reps, $tpl);
	}

}
