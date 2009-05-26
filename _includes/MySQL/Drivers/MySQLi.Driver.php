<?php

class MySQL_Drivers_MySQLi extends MySQL_Drivers {

	public $identifier;

	public function __construct(){
	}
	
	public function connect( Array $Args ) {
		
		@$this->identifier = new mysqli( $Args[ 'hostname' ], $Args[ 'username' ], $Args[ 'password' ], $Args[ 'database' ] );
		
		if( @mysqli_connect_error() ) {
			
			throw new GNR_Exception( 'Could not connect to MySQLi' );
		
		} else {
		
			return true;
		
		}
			
	}
	
	public function selectDb() {
		
		// Not needed
	
	}
	
	public function query( $Query ) {
	
		return $this->identifier->query( $Query );
	
	}

	public function fetchAssoc( $Query ) {
	
		if( $Query !== false ) {
		
			return $Query->fetch_assoc();
		
		} else {
		
			return false;
		
		}
		
	}
	
	public function fetchArray( $Query ) {
	
		if( $Query !== false ) {
		
			return $Query->fetch_array();
		
		} else {
			
			return false;
		
		}
		
	}
	
	public function fetchAll( $Query ) {
	
		if( method_exists($Query, 'fetch_all') !== false ) {
		
			return $Query->fetch_all();
		
		} else {
			
			$Return = Array();
			
			while( $rowSet = $this->fetchAssoc( $Query ) ) {
			
				$Return[] = $rowSet;
			
			}
			
			if( count( $Return ) > 0 ) {
			
				return $Return;
			
			} else {
				
				return false;
			
			}
			
		}
		
	}
	
	public function numRows( $Query ) {

		if( is_object( $Query ) !== false ) {
		
			return $Query->num_rows;
		
		} else {
		
			return false;
		
		}
		
	}
	
	public function mysqlRealEscape( $String ) {
	
		return $this->identifier->escape_string( $String );
	
	}

	public function insert( $Table, Array $Data ) {
		
		$Columns = '';
		$Values  = '';
		$Comma   = '';
		
		foreach( $Data as $K => $V ) {
		
			$Columns .= $Comma . '`' . Misc::clean( $K ) . '`';
			$Values  .= $Comma . '\'' . Misc::clean( $V ) . '\'';
			$Comma    = ',';
		
		}
		
		$Query = "INSERT INTO `{$Table}` ( {$Columns} ) VALUES ( {$Values} )";
		
		return $this->query( $Query );

	}
	
	public function remove( $Table, Array $Where ) {
	
		$State = ' WHERE ';
		$AND   = '';
		
		foreach( $Where as $K => $V ) {
		
			$State .= $AND . '`' . $K . '` = \'' . $V . '\'';
			$AND    = ' AND ';
		
		}
		
		$Query = "DELETE FROM `{$Table}` {$State}";
		
		return $this->query( $Query );
	
	}
	
	public function select( $Table, $Select, Array $Where = Array() ) {
	
		if( is_array( $Select ) !== false ) {
			
			$Columns = '';
			$Comma   = '';
   
			foreach( $Select as $K => $V ) {
   
				$Columns .= $Comma . '`' . Misc::clean( $V ) . '`';
				$Comma    = ',';
   
			}			
		
		} else {
			
			$Columns = '`' . $Select . '`';
		
		}
		
		$State = ' WHERE ';
		$AND   = '';

		foreach( $Where as $K => $V ) {

			$State .= $AND . '`' . $K . '` = \'' . $V . '\'';
			$AND    = ' AND ';

		}
		
		$Query = "SELECT {$Columns} FROM `{$Table}`{$State}";
		
		return $this->query( $Query );
	
	}
	
}