<?php

/**
 * @class 		Cache
 * @abstract	This class offers support for caching of dynamic data into temporary cache files
 				which are stored in the GNR tmp directory.
 */
class Cache {

	protected $host;
	protected $port;
	
	protected $cachePath;
	protected $cacheModel;
	protected $cacheHandle;
	
	public function __construct( $Type = 'flat', $Host = '', $Port = '' ) {
		$this->host = $Host;
		$this->port = $Port;
		$this->initType( $Type );
	}
	
	protected function initType( $Type ) {
		
		switch( $Type ) {
			
			case 'flat':
			
				$this->type = 'flat';
				$this->cachePath = TMP_PATH . '_cache/';
		
				break;
				
			case 'db':
			
				$this->type = 'db';
				$this->cacheModel = new CacheModel();
				
				break;
				
			case 'memcache':
			
				$this->type = 'memcache';
				$this->cacheHandle = new Library_Cache_Memcache( $this->host, $this->port );
				
				break;
				
			default:
				
				throw new GNR_Exception( 'Unsupported cache type used.' );
			
				break;
		
		}
	
	}
	
	public function set( $Name, $Data, $Expire = 60 ) {
	
		if( is_int( $Expire ) !== true && is_float( $Expire ) !== true  ) {
		
			$Expire = 60;
		
		}
		
		switch( $this->type ) {
   
   			case 'flat':
   
				$cacheFile = $Name . '.thtml';
				$contents = strtotime( '+' . $Expire . ' seconds' ) . '||Data||' . $Data;
				   
				if( $Handle = fopen( $this->cachePath . $cacheFile, 'w+' ) ) {
   
					fwrite( $Handle, $contents );
					fclose( $Handle );
   
					return true;
   
				} else {
   
					return false;
   
				}
				
				break;
				
			case 'db':
				
				$Expire = strtotime( '+' . $Expire . ' seconds' );
				
				return $this->cacheModel->save( $Name, $Data, $Expire );
			
				break;
				
			case 'memcache':
				
				return $this->cacheHandle->set( $Name, $Data, $Expire );
				
				break;
   
		}
	
	}
	
	public function get( $Name ) {
	
		switch( $this->type ) {
		
			case 'flat':
   
				if( file_exists( $this->cachePath . $Name . '.thtml' ) !== false ) {
   
					$Data 	= file_get_contents( $this->cachePath . $Name . '.thtml' );
					$Parts	= explode( '||', $Data );
					$Time	= time();
					
					if( $Time <= $Parts[ 0 ] ) {
   
						$Content = explode( 'Data||', $Data );
						$size	 = count( $Content );
						$Datas	 = Array();
   
						for( $i = 1; $i < $size; $i++ ) {
   
							$Datas[] = $Content[ $i ];
   
						}
   
						$Data = implode( $Datas );
   
						return $Data;
   
					} else {
					   
						if( unlink( $this->cachePath . $Name . '.thtml' ) !== false ) {
						
							return false;
   						
						} else {
						
							throw new GNR_Exception( 'Could not delete cache file, please check permissions of _tmp AND _cache folders.' );
						
						}
						
					}
   
				} else {
				
					return false;
				
				}
   
				break;
			
			case 'db':
			
				$Data = $this->cacheModel->getRow( $Name );
				
				if( is_array( $Data ) !== true ) {
				
					return false;
				
				} else {
				
					$Time	= time();
					
					if( $Time <= $Data[ 'expire' ] ) {
					
						return $Data[ 'value' ];	
					
					} else {
					
						$this->cacheModel->remove( $Name );
						
						return false;
					
					}
				
				}
							
				break;
			
			case 'memcache':
							
				if( $Data = $this->cacheHandle->get( $Name ) ) {
				
					return $Data;
				
				} else {
				
					return false;
				
				}
			
				break;
				
		}
	
	}
	
	public function remove( $Name ) {
	
		switch( $this->type ) {
   
   			case 'flat':
   
				if( unlink( $this->cachePath . $Name . '.thtml' ) !== false ) {
   
					return true;
   
				} else {
   
					return false;
   
				}
				
				break;
			
			case 'db':
			
				return $this->cacheModel->remove( $Name );
			
				break;
				
			case 'memcache':
			
				return $this->cacheHandle->remove( $Name );
				
				break;
		
		}
	
	}
	
}