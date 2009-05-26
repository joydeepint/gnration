<?php

class ErrorController extends Controller {

	public function init() {
		
		$this->queryString = (int)$this->queryString;
		
		switch( $this->queryString ) {
		
			case 404:
			
				HTML::setHeader( 'HTTP/1.0 404 Not Found' );
				$this->message = 'Sorry, we could not find that page.';
			
			break;
			
		}
	
	}

	public function IndexAction() {
	}

}