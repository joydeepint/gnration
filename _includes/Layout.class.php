<?php

class Layout {

	public function __construct($A) {
		
		foreach( $A as $K => $V ) {
		
			$this->$K = $V;
		
		}
		
	}
	
	public function getMeta() {
	
		return '';
	
	}
	
	public function getCss() {
	
	}
	
	public function getJavascript() {
	
	}
	
	public function getHelper( $File ) {
	
		$Path = VIEW_PATH . 'helpers/' . $File . '.html';
	
		if( file_exists( $Path ) !== false ) {
		
			include $Path;
		
		}
	
	}
	
	public function header() {
		
		$this->getHelper( 'header' );
	
	}
	
	public function load( $View ) {
	
		if( file_exists( $View ) !== false ) {
			
			include $View;
			
		}
	
	}

	public function footer() {

		$this->getHelper( 'footer' );

	}
	
}