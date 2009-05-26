<?php

class IndexController extends Controller {

	public function init() {
	}
	
	public function IndexAction() {
		
		$Cache = new Cache( 'db' );
		
		if( $Data = $Cache->get( 'sup' ) ) {
		
			$this->sup = $Data;
		
		} else {
		
			$this->sup = 'Sup dude!';
			$Cache->set( 'sup', 'This is cached data, haha.', 60 );
		
		}
		
	}

}