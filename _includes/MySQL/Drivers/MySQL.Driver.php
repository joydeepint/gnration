<?php

class MySQL_Drivers_MySQL extends MySQL_Drivers {

	public function __construct(){
	}
	
	public function connect( Array $Args ) {
	
	
	}
	
	public function selectDb() {
	}
	
	public function query() {
	
	}

	public function fetchAssoc() {
	
	}
	
	public function fetchArray() {
	
	}
	
	public function fetchAll() {
	
	}
	
	public function numRows() {
	}

	public function mysqlRealEscape( $String ) {

		return mysql_real_escape_string( $String );

	}
		
	public function insert( $Table, Array $Data ) {
	}
	
	public function remove( $Table, Array $Where ) {
	}
	
	public function select( $Table, $Select, Array $Where = Array() ) {
	
	
	}

}