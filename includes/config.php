<?php

class Config {

	private $db = array(
			"default" => array(
					"name" => "forum-project",
					"user" => "root",
					"pass" => "",
					"host" => "localhost",
			)
	);

	static public function get_property($property) {
		if (property_exists($this, $property)) {
			return $this->$property;
		}

	}
}