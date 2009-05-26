<?php

class Timer {
	
	protected $Times;
	
	public function begin() {
	
		$Time  = microtime();
		$Times = explode( ' ', $Time );
		
		$Time  = ( $Times[ 1 ] + $Times[ 0 ] );
		
		$this->Times[ 'begin' ] = $Time;
	
	}
	
	public function end() {

		$Time  = microtime();
		$Times = explode( ' ', $Time );

		$Time  = ( $Times[ 1 ] + $Times[ 0 ] );
			
		$this->Times[ 'end' ] = $Time;
	
	}
	
	public function getTime( $Dec = 5 ) {
	
		if( is_int( $Dec ) !== true ) {
		
			$Dec = 5;
		
		}
		
		return round( $this->Times[ 'end' ] - $this->Times[ 'begin' ], $Dec );
	
	}

}