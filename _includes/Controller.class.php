<?php

class Controller {

	protected $queryString;
	
	public function __construct() {
		
	}
	
	public function load( $Controller, $Action, $Query ) {
	
		$Controller	= ucwords( strtolower( $Controller ) );
		
		if( file_exists( CONTROLLER_PATH . $Controller . 'Controller.php' ) !== false ) {
		
			require_once CONTROLLER_PATH . $Controller . 'Controller.php';
			
			$controllerClass = $Controller . 'Controller';
				
			$this->Controller = new $controllerClass();
			
			if( is_array( $Query ) !== false ) {
   
				if( count( $Query ) > 1 ) {
   
					$this->Controller->queryString = $Query;
   
				} elseif( count( $Query ) > 0 ) {
   
					$this->Controller->queryString = $Query[ 0 ];
   
				} else {
   
					$this->Controller->queryString = '';
   
				}
			
			} else {
				
				$this->Controller->queryString = $Query;
			
			}
					
			if( method_exists( $this->Controller, 'init' ) !== false ) {
			
				call_user_func( Array( &$this->Controller, 'init' ) );
			
			}
			
			$Action = ucwords( strtolower( $Action ) );
			$ActionFile = $Action . 'Index';
			
			if( method_exists( $this->Controller, $ActionFile ) !== false ) {
			
				call_user_func( Array( &$this->Controller, $ActionFile ) );
				
			} else {
			
				$this->Controller->IndexAction();
			
			}
						
			$this->loadView( $Controller, $Action );
			
			return true;
		
		} else {
			
			return false;
		
		}
	
	}
	
	public function loadView( $Controller, $Action ) {
		
		$this->View = new View(&$this->Controller);
		
		if( file_exists( VIEW_PATH . 'scripts/' . strtolower( $Controller ) . '/' . $Action . '.html' ) !== false ) {
		
			$this->View->Layout = new Layout(&$this->View);
			$this->View->Layout->header();
			
			$this->View->Layout->load( VIEW_PATH . 'scripts/' . strtolower( $Controller ) . '/' . $Action . '.html' );
			
			$this->View->Layout->footer();
		
		} else {
			
			$Action = 'Index';
			
			if( file_exists( VIEW_PATH . 'scripts/' . strtolower( $Controller ) . '/' . $Action . '.html' ) !== false ) {
   
				$this->View->Layout = new Layout(&$this->View);
				$this->View->Layout->header();
   
				$this->View->Layout->load( VIEW_PATH . 'scripts/' . strtolower( $Controller ) . '/' . $Action . '.html' );
   
				$this->View->Layout->footer();
			
			} else {
			
				$this->load( 'Error', 'Index', '404' );
			
			}
			
		}
	
	}

}