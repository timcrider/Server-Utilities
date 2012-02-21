<?php
class SystemUser {
	/**
	*
	*/
	public function exists($username) {
		$out = exec("grep ^{$username}\: /etc/passwd", $outStack, $returnVal);
		
		if ($returnVal == 0) {
			$userStack = preg_split('/:/', $out);
			return array(
				'username' => $userStack[0],
				'userid'   => $userStack[2],
				'groupid'  => $userStack[3],
				'fullname' => $userStack[4],
				'home'     => $userStack[5],
				'shell'    => $userStack[6]
			);
		} else {
			return false;
		}
	}

	/**
	*
	*/
	public function profile($username) {
		if (!$user = $this->exists($username)) {
			return false;
		}
		
		// Fetch Groups
		$out = exec("groups {$username}|awk -F: '{ print \$2 }'", $outStack, $returnVal);
		
		if ($returnVal == 0) {
			$user['groups'] = preg_split('/ /', trim($out));
		} else {
			$user['groups'] = array();
		}
		
		// Fetch brief summary of home directory usage
		$out = exec("du -sh {$user['home']}", $outStack, $returnVal);
		
		if ($returnVal == 0) {
			list($user['diskusage']) = preg_split("/\t/", $out);
		} else {
			$user['diskusage'] = 'unknown';
		}
		
		return $user;
	}

}
