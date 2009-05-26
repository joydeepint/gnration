<?php

/**
 * @class		MySQL_Drivers
 * @inherits	MySQL
 * @definition	The MySQL_Drivers class gives an abstraction layer between the MySQL connector
 *				and the drivers by defining the methods drivers must have.
 */
abstract class MySQL_Drivers extends MySQL {

	public $identifier;
	
	public function __construct(){
	}
	
	abstract function connect( Array $Args );
	abstract function selectDb();
	
	abstract function query( $Query );
	abstract function fetchAssoc( $Query );
	abstract function fetchArray( $Query );
	abstract function fetchAll( $Query );
	abstract function numRows( $Query );
	abstract function insert( $Table, Array $Data );
	abstract function remove( $Table, Array $Where );
	abstract function select( $Table, $Select, Array $Where = Array() );
	
	abstract function mysqlRealEscape( $String );

}