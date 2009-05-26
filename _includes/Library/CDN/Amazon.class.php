<?php

class Library_CDN_Amazon extends Library {
	
	protected $publicKey;
	protected $privateKey;
	
	protected $supported = Array(
		'S3',
		'EC2'
	);
	
	public function __construct( $publicKey, $privateKey ) {
	
		global $core;
		
		$this->publicKey = $publicKey;
		$this->privateKey = $privateKey;
		
		$this->Core =& $core;
	
	}
	
	public function load( $service = 's3' ) {
	
		$service = strtoupper( $service );
		
		if( in_array( $service, $this->supported ) !== false ) {
		
			$className = 'Library_CDN_Amazon_' . $service;
			
			$this->services[ $service ][] = new $className( $this->publicKey, $this->privateKey );
		
		} else {
		
			throw new GNR_Exception( 'Unsupported Amazon service requested.' );
		
		}
	
	}
	
}