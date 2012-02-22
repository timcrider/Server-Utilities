<?php
/**
* Website creation object (prototype)
*/
class Website {
	protected $ip;
	protected $owner;
	protected $group;
	protected $documentRoot;
	protected $serverName;
	protected $serverAdmin;
	protected $errorDocument;
	protected $errorLog;
	protected $customLog;
	protected $port          = 80;
	protected $serverAliases = array();
	protected $scripAliases  = array();
	protected $suexec        = false;
	protected $phpvars       = array();
	
}
