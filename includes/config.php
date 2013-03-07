<?php

class Config {

	static private $config = array();

	static public function get_property($name, $subname = NULL) {
	
            if ($subname === NULL) {
                return self::$config[$name];
            }
            else {
                return self::$config[$name][$subname];
            }

	}

	static public function set_property($name, $value) {
		
		self::$config[$name] = $value;

	}
}