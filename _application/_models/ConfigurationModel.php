<?php

class ConfigurationModel extends Model {

	public function getConfiguration( $Key ) {
	
		$Query	= $this->DB->query( "SELECT `key`, `value`, `serial` FROM `configuration` WHERE `key` = '" . $Key . "'" );
		$Num	= $this->DB->numRows( $Query );

		if( $Num > 0 ) {

			$Fetch	= $this->DB->fetchAssoc( $Query );

			if( $Fetch[ 'serial' ] == '1' ) {

				$Fetch[ 'value' ] = unserialize( $Fetch[ 'value' ] );

			}

			return $Fetch[ 'value' ];

		} else {

			return false;

		}
	
	}

	public function saveConfiguration( $Key, $Value ) {
	
		$Query	= $this->DB->query( "SELECT `id` FROM `configuration` WHERE `key` = '" . $Key . "'" );
		$Num	= $this->DB->numRows( $Query );
		
		if( $Num > 0 ) {
   
			if( is_array( $Value ) !== false ) {
   
				 // Serial
				 $Value		= serialize( $Value );
 				 $Serial	= '1';
				   
			} else {
			
				$Serial		= '0';
			
			}
			
			$this->DB->query( "UPDATE `configuration` SET `value` = '" . $Value . "', `serial` = '" . $Serial . "' WHERE `key` = '" . $Key . "'" );
			
		} else {
		
			return false;
		
		}
	
	}
	
	public function addConfiguration( $Key, $Value ) {
	
		$Query	= $this->DB->query( "SELECT `id` FROM `configuration` WHERE `key` = '" . $Key . "'" );
		$Num	= $this->DB->numRows( $Query );
		
		if( $Num > 0 ) {
		
			return $this->saveConfiguration( $Key, $Value );
					
		} else {

			if( is_array( $Value ) !== false ) {

				 // Serial
				 $Value		= serialize( $Value );
				 $Serial	= '1';

			} else {
			
				$Serial		= '0';
			
			}
					
			return $this->DB->query( "INSERT INTO `configuration` ( `key`, `value`, `serial` ) VALUES ( '" . $Key . "', '" . $Value . "', '" . $Serial . "' )" );
		
		}		
	
	}

}