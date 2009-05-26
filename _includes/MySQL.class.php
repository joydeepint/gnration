<?php

class MySQL extends Core {
	
	public $DBs = Array();
	
	public function __construct() {
	
	}

	private function loadAbstract() {
	
		require_once INCLUDE_PATH . 'MySQL/Drivers/Driver.abstract.php';
	
	}

	public function loadDriver( $Driver, $Connection ) {
	
		$this->loadAbstract();
						
		if( file_exists( INCLUDE_PATH . 'MySQL/Drivers/' . $Driver . '.Driver.php' ) !== false ) {
		
			require_once INCLUDE_PATH . 'MySQL/Drivers/' . $Driver . '.Driver.php';
			
			$className	= 'MySQL_Drivers_' . $Driver;
			$Key		= ( count( $this->DBs ) - 1 );			
			
			$this->DBs[ $Driver ][ $Key ] = new $className;
		
			$this->DBs[ $Driver ][ $Key ]->connect( $Connection );
			
			return $this->DBs[ $Driver ][ $Key ];
		
		} else {
		
			throw new GNR_Exception( 'Could not load MySQL driver' );
		
		}
	
	}
	
}