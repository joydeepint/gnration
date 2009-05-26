<?php

class Library_Cache_Memcache extends Library {

	private $Cache;
	
	public function __construct( $Host, $Port = 11211, $Persistant = true ) {
	
		if( $this->Cache == '' ) {
   
			if( class_exists( 'Memcache' ) !== false ) {
   
   				if( is_int( $Port ) !== true ) {
					
					$Port = 11211;
				
				}
				
				$this->Cache = new Memcache();
				
				if( $Persistant !== false ) {
				
					$this->Cache->pconnect( $Host, $Port );
   				
				} else {

					$this->Cache->connect( $Host, $Port );				
				
				}
				
			} else {
   
				throw new GNR_Exception( 'You must have the Memcached extension to use Library_Memcached.' );
   
			}
			
		}
		
	}
	
	public function set( $Key, $Value, $Expire = 60 ) {
	
		if( is_object( $this->Cache ) !== false ) {
   
			if( is_int( $Expire ) !== true && is_float( $Expire ) !== true || $Expire > 25920000 ) {
   
				$Expire = 60;
   
			}
			
			if( strlen( $Key ) > 250 ) {
			
				$Key = substr( $Key, 0, 250 );
			
			}
			
			$Key = str_replace( ' ', '_', $Key );
			
			if( $this->Cache->add( $Key, $Value, MEMCACHE_COMPRESSED, $Expire ) !== false ) {
				
				return true;
			
			} else {
				
				return false;
			
			}
   
   		} else {
		
			return false;
		
		}		
	
	}
	
	public function get( $Key ) {
	
		if( is_object( $this->Cache ) !== false ) {
			
			if( is_array( $Key ) !== false ) {
			
				foreach( $Key as $K => $V ) {
				
					$Key[ $K ] = str_replace( ' ', '_', $V );
				
				}
			
			} else {
			
				$Key = str_replace( ' ', '_', $Key );
			
			}
			
			if( $Return = $this->Cache->get( $Key ) ) {
				
				return $Return;
			
			} else {
			
				return false;
			
			}
			
		} else {
			
			return false;
		
		}
	
	}
	
	public function delete( $Key, $Timeout = 0 ) {
	
		if( is_object( $this->Cache ) !== false ) {

			if( is_int( $Timeout ) !== true && is_float( $Timeout ) !== true ) {

				$Timeout = 0;

			}
			
			return $this->Cache->delete( $Key, $Timeout );
		
		} else {
		
			return false;
		
		}
	
	}
	
	public function getCache() {
	
		return $this->Cache;
	
	}

}