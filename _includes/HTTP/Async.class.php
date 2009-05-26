<?php

class HTTP_Async extends HTTP_Request {
	
	protected $Curl;
	protected $Reqs = Array();
	protected $Data = Array();
	
	public function __construct() {
	
		if( function_exists( 'curl_multi_init' ) !== false ) {
		
			$this->Curl = curl_multi_init();
			
		} else {
		
			throw new GNR_Exception( 'You must have the cURL extension enabled to use HTTP_Async.' );
		
		}
	
	}
	
	public function prep( $Data ) {
	
		$this->Data = $Data;
	
	}
	
	public function send() {
	
		foreach( $this->Data as $K => $V ) {
		
			$this->Reqs[ $K ] = curl_init();
			
			curl_setopt( $this->Reqs[ $K ], CURLOPT_URL, $V[ 'url' ] );
			curl_setopt( $this->Reqs[ $K ], CURLOPT_HEADER, false );
			curl_setopt( $this->Reqs[ $K ], CURLOPT_RETURNTRANSFER, true );
		
			if( is_array( $V[ 'post' ] ) !== false ) {
			
				// Send POST data
				
				curl_setopt( $this->Reqs[ $K ], CURLOPT_POST, true );
				curl_setopt( $this->Reqs[ $K ], CURLOPT_POSTFIELDS, $V[ 'post' ] );
				
			}
			
			curl_multi_add_handle( $this->Curll, $this->Reqs[ $K ] );
		
		}
		
		$Executing = false;
		
		do {
		
			curl_multi_exec( $this->Curl, $Executing );
		
		} while( $Executing > 0 );
	
		$Results = Array();
	
		foreach( $this->Reqs as $K => $V ) {
		
			$Results[ $K ] = curl_multi_getcontent( $V );
			
			curl_multi_remove_handle( $this->Curl, $V );
			
		}
		
		return $Results;
	
	}

}