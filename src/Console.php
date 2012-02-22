<?php
/**
* Console I/O
*/
class Console {
	static protected $ps1      = " ";
	static protected $maxTries = 5;
	static protected $width    = 80;

	/**
	*
	*/
	public function write() {
		$argv = func_get_args();
		$argc = count($argv);
		
		for ($i = 0; $i < $argc; $i++) {
			@fputs(STDOUT, $argv[$i]);
		}

		return true;
	}

	/**
	*
	*/
	public function writeLine() {
		$argv = func_get_args();
		$argc = count($argv);

		for ($i = 0; $i < $argc; $i++) {
			@fputs(STDOUT, "{$argv[$i]}\n");
		}
		return true;
	}

	/**
	*
	*/
	public function bar($fill='-') {
		self::writeLine('+' . str_repeat($fill, self::$width - 2) . '+');
		return true;
	}

	/**
	*
	*/
	public function marquee() {
		$argv = func_get_args();
		$argc = count($argv);

		for ($i = 0; $i < $argc; $i++) {
			if ($i == 0) {
				self::bar();
			}

			if ($argv[$i] == '||') {
				self::bar();
			} else {
				self::writeLine('+ ' . $argv[$i]);
			}

			if ($i == ($argc - 1)) {
				self::bar();
			}
		}

		@fputs(STDOUT, $message . "\n");
		return true;
	}

	/**
	*
	*/
	public function input($prompt=NULL, $required=NULL) {
		if (!empty($prompt)) {
			self::write($prompt . self::$ps1);
		}

		if (!empty($required)) {
			$tries = 0;

			while (empty($output)) {
				$output = trim(@fgets(STDIN));

				if (!empty($output)) {
					return $output;
				}

				if ($tries >= self::$maxTries) {
					return false;
				}

				self::write($prompt . self::$ps1);
				$tries++;
			}
		} else {
			$output = trim(@fgets(STDIN));
		}

		return $output;
	}

}
