<?php

class Core {

	public $post	= Array();
	public $get		= Array();
	public $cookie	= Array();
	public $session = Array();

	public function __construct() {
	
		$this->cleanGlobals();
	
	}
	
	private function cleanGlobals() {

		$this->post		= Misc::arrayClean( $_POST );
		$this->get		= Misc::arrayClean( $_GET );
		$this->cookie	= Misc::arrayClean( $_COOKIE );	
		
		if( @is_array( $_SESSION ) !== false ) {
			
			$this->session	= Misc::arrayClean( $_SESSION );
		
		}
			
	}
	
	public function getConfiguration( $Key ) {
	
		$Config = new ConfigurationModel();
		
		return $Config->getConfiguration( $Key );
	
	}
	
	public function library() {
			
		return new Library();
	
	}

}