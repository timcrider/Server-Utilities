<?php
/**
* Console I/O
*/
class Console {
	static protected $ps1      = " ";
	static protected $maxTries = 5;
	static protected $width    = 80;
	static protected $history  = array();
	
	/**
	*
	*/
	public function status() {
		self::marquee("Console Status");

		self::write(sprintf("%-20s: %s\n", "PS1", self::$ps1));
		self::write(sprintf("%-20s: %s\n", "Maximum Tries", self::$maxTries));
		self::write(sprintf("%-20s: %s\n", "Width", self::$width));

		if (function_exists('readline')) {
			$consoleType = "Readline";
		} else {
			$consoleType = "STDIN";
		}

		self::write(sprintf("%-20s: %s\n", "Console Type", $consoleType));
	}
	
	/**
	*
	*/
	public function formatStatus($message, $status, $color) {
		return sprintf("%-70s %18s\n", $message, "[".Colors::getColoredString($status, $color)."]");
	}

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
			$prompt = $prompt.self::$ps1;
		}

		if (!empty($required)) {
			$tries = 0;

			while (empty($output)) {
				if (function_exists('readline')) {
					$output = trim(@readline($prompt));
				} else {
					self::write($prompt);
					$output = trim(@fgets(STDIN));
				}

				if (!empty($output)) {
					return $output;
				}

				if ($tries >= self::$maxTries) {
					return false;
				}
				$tries++;
			}
		} else {
			if (function_exists('readline')) {
				$output = trim(@readline($prompt));
			} else {
				self::write($prompt);
				$output = trim(@fgets(STDIN));
			}
		}

		if (function_exists('readline')) {
			readline_add_history($output);
		} else {
			self::$history[] = $output;
		}

		return $output;
	}

}
