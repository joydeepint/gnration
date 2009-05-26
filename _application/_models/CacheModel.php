<?php

class CacheModel extends Model {

	public function save( $Name, $Value, $Expire ) {
	
		$this->remove( $Name ); // Remove any un-needed caches under the same key
		
		return $this->DB->insert( 'cache', Array( 'key' => $Name, 'value' => $Value, 'expire' => $Expire ) );
	
	}
	
	public function getRow( $Key ) {
	
		$Q = $this->DB->select( 'cache', Array( 'value', 'expire' ), Array( 'key' => $Key ) );
		$F = $this->DB->fetchAll( $Q );
		
		if( is_array( $F ) !== false ) {
		
			return $F[ 0 ];
		
		} else {
		
			return false;
		
		}
		
	}
	
	public function remove( $Key ) {
		
		return $this->DB->remove( 'cache', array( 'key' => $Key ) );
	
	}

}