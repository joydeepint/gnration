<?php

class HTTP_Request {

	public $identifier;
	public $postParams;
	public $Original_URI;
	public $URI;
	public $type;

	public function __construct( $URI ) {

		$this->Original_URI = $URI;
		$this->URI			= $URI;

		// Check for cURL support	
		if( function_exists( 'curl_init' ) !== false ) {

			$this->identifier	= curl_init();
			$this->type			= 'cURL';

		} else {


		}

	}

	public function addGet( $Param, $Value ) {

		$Param	= urldecode( $Param );
		$Value	= urldecode( $Value );

		if( $this->URI == $this->Original_URI && strstr( '?', $this->URI ) !== true ) {

			$this->URI .= '?' . urlencode( $Param ) . '=' . urlencode( $Value );

		} else {

			$this->URI .= '&' . urlencode( $Param ) . '=' . urlencode( $Value );

		}

	}

	public function addPost( $Param, $Value ) {

		$Param	= urldecode( $Param );
		$Value	= urldecode( $Value );

		if( strlen( $this->postParams ) == 0 ) {

			$this->postParams = urlencode( $Param ) . '=' . urlencode( $Value );

		} else {

			$this->postParams .= '&' . urlencode( $Param ) . '=' . urlencode( $Value );

		}

	}

	public function sendRequest( $Async = false ) {

		if( $this->type == 'cURL' ) {
			
			if( $Async !== false ) {
			
				// We don't want to wait for a response
			
			} else {
   
				curl_setopt( $this->identifier, CURLOPT_URL, $this->URI );
   
				if( $this->postParams !== '' ) {
   
					curl_setopt( $this->identifier, CURLOPT_POST, true );
					curl_setopt( $this->identifier, CURLOPT_POSTFIELDS, $this->postParams );
   
				}
				
			}

		}

	}

}