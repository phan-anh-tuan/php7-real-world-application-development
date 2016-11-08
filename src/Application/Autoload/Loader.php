<?php
namespace Application\Autoload;

class Loader {
	
	const UNABLE_TO_LOAD = 'Unable to load class';
	// array of directories
	protected static $dirs = array();
	protected static $registered = 0;
	
	protected static function loadFile($filename) {
		if (file_exists($filename)) {
			require_once $filename;
			return TRUE;
		}
		return FALSE;
	}
	
	public static function autoload($class) {
		$success=FALSE;
		$fn=str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
		foreach(self::$dirs as $start) {
			$filename = $start . DIRECTORY_SEPARATOR . $fn;
			if (self::loadFile($filename)) {
				$success=true;
				break;
			}
		}
		if (!$success) {
			$filename = __DIR__ . DIRECTORY_SEPARATOR . $fn;
			if (!self::loadFile($filename)) {
				throw new \Exception(self::UNABLE_TO_LOAD . ' ' . $class);
			}
		}
		
		return $success;
	}
	
	public static function addDirs($dirs) {
		if (is_array($dirs)) {
			self::$dirs = array_merge(self::$dirs, $dirs);
		} else {
			self::$dirs[] = $dirs;
		}
	}
	
	public static function init($dirs = array()) {
		if ($dirs) {
			self::addDirs($dirs);
		}
		if (self::$registered == 0 ){
			spl_autoload_register(__CLASS__ . '::autoload');
			self::$registered++;
		}
	}
	
	public function __construct($dirs = array()) {
		self::init($dirs);
	}
}