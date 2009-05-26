<?php

class Misc {

	public function __construct(){
	}
	
	public function encrypt( $String ) {
		
		$String = md5( $String );
		$String = crypt( $String, 'sAlT40x' );
		
		return $String;
	
	}
	
	public function clean( $String ) {
	
		global $db;
		
		$String = urldecode( $String );
		$String = stripslashes( $String );
		$String	= htmlspecialchars( $String );
		$String	= htmlentities( $String );
		$String	= $db->mysqlRealEscape( $String );
		
		return $String;
	
	}
	
	public function arrayClean( $Array ) {
	
		if( is_array( $Array ) !== false ) {
   
			foreach( $Array as $K => $V ) {
   
				if( is_array( $V ) !== false ) {
   
					$Array[ $K ] = self::arrayClean( $V );
   
				} else {
   
					$Array[ $K ] = self::clean( $V );
   
				}
   
			}
			
		} else {
		
			return self::clean( $Array );
		
		}

		return $Array;
	
	}
	
	public function json_encode( $Str ) {
	
		if( function_exists( 'json_encode' ) !== false ) {
			
			return json_encode( $Str );
		
		} else {
			
			return JSON_PHP::encode( $Str );
		
		}
	
	}

	public function json_decode( $Str ) {

		if( function_exists( 'json_decode' ) !== false ) {

			return json_decode( $Str );

		} else {

			return JSON_PHP::decode( $Str );

		}

	}
	
}