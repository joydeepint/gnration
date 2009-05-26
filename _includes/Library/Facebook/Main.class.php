<?php

class Library_Facebook_Main extends Library {

	protected $API_Key;
	protected $API_Secret;

	public function __construct( $API_KEY, $API_SECRET ) {
		
		global $core;
		
		$this->Core			=& $core;
		$this->API_Key		= $API_KEY;
		$this->API_Secret	= $API_SECRET;
		$this->FB_Library	= LIBRARY_PATH . 'Facebook/Library/';
		
		require_once $this->FB_Library . 'facebook.php';
		
		$this->Facebook = new Facebook( $this->API_Key, $this->API_Secret );
	
	}

	public function connect() {
	
		if( $this->Core->get[ 'auth_token' ] !== '' ) {
		
		} else {
		
			$this->Facebook->require_login();
		
		}
		
	}

}