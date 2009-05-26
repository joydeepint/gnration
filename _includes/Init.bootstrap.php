<?php

error_reporting(E_ALL);
ini_set("display_errors", 1); 

function __autoload( $Class ) {

	$Parts = explode( '_', $Class );
	$Size  = count( $Parts );
	
	$Path  = '';
		
	for( $i = 0; $i < $Size; $i++ ) {
		
		if( $i !== ( $Size - 1 ) ) {
			
			$Path .= $Parts[ $i ] . '/';
		
		} else {
	
			$ModelPath = $Path . $Parts[ $i ] . '.php';
			$Path .= $Parts[ $i ] . '.class.php';
		
		}
	
	}
	
	if( file_exists( INCLUDE_PATH . $Path ) !== false ) {
	
		require_once INCLUDE_PATH . $Path;
	
	} else if( file_exists( MODEL_PATH . $ModelPath ) !== false ) {
	
		require_once MODEL_PATH . $ModelPath;
	
	}
	
}

class Init {

	public  $absolutePath;
	private $Controller;
	private $View;
	
	public function __construct( $Root, $File ) {
		
		define( 'INCLUDE_PATH', '_includes/' );
		define( 'LIBRARY_PATH', INCLUDE_PATH . 'Library/' );
		define( 'CONTROLLER_PATH', '_application/_controllers/' );
		define( 'VIEW_PATH', '_application/_views/' );
		define( 'MODEL_PATH', '_application/_models/' );
		define( 'TMP_PATH', '_application/_tmp/' );
		
		$this->absolutePath	= $Root;
		$this->setPaths();
		
		if( file_exists( INCLUDE_PATH . 'Settings.ini' ) !== false ) {
		
			$this->Configuration = parse_ini_file( $File, true );
			$this->Configuration = (object)$this->Configuration; // Objectify
		
		} else {
		
			throw new GNR_Exception( 'Could not load settings file, please make sure Settings.ini exists.' );
		
		}
				
	}
	
	private function setPaths() {
	
		$Path = $this->absolutePath;
		
		set_include_path( get_include_path() . PATH_SEPARATOR . $Path );
		chdir( $Path );
		
	}
	
	public function initTimers() {
		
		$this->Timer = new Timer();
		$this->Timer->begin();
	
	}
	
	public function bootstrap() {
	
		$this->initDb();
		$this->loadClasses();
	
	}
	
	private function initDb() {
	
		global $db;
		
		$this->MySQL = new MySQL();
		
		$db = $this->MySQL->loadDriver( $this->Configuration->Database[ 'driver' ], Array(
			
			'hostname' => $this->Configuration->Database[ 'hostname' ],
			'username' => $this->Configuration->Database[ 'username' ],
			'password' => $this->Configuration->Database[ 'password' ],
			'database' => $this->Configuration->Database[ 'database' ]
			
		));
			
	}

	private function loadClasses() {
		
		$required	= Array(
		
			'core'	=> 'Core',
			//'misc'	=> 'Misc'
					
		);
		
		foreach( $required as $K => $V ) {
		
			global $$K;
			$$K = new $V();
		
		}
	
	}
	
	private function initController() {
	
		$this->Controller = new Controller();
	
	}
	
	private function initView() {
	
		$this->View	= new View();
	
	}
	
	public function setup() {
	
		$Path = $_SERVER[ 'REQUEST_URI' ];
				
		$Path = explode( '/', $Path );
		$Size = count( $Path );
		
		if( $Path[ 2 ] == '' ) {
		
			$Controller = 'Index';
			$Action		= 'Index';
		
		} else {
		
			$Controller	= @$Path[ 2 ];
			$Action		= @$Path[ 3 ];
			
		}
		
		if( $Action == '' ) {
			
			$Action = 'Index';
		
		}
		
		$Query = Array();
		
		for( $i = 4; $i < $Size; $i++ ) {
		
			$Query[] = $Path[ $i ];
		
		}
				
		$this->initController();
		
		if( $this->Controller->load( $Controller, $Action, $Query ) ) {
			
			// We're done.		
		
		} else {
			
			$Cont = $this->Controller->load( 'Error', 'Index', '404' );
		
		}
	
	}

}