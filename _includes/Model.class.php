<?php

class Model {

	public function __construct() {
			
		global $db;
		
		$this->DB =& $db;
	
	}

}