<?php

class HTML {

	public function setHeader( $Header, $Value = '' ) {
	
		if( $Value != '' ) {
		
			header( $Header . ': ' . $Value );
		
		} else {
		
			header( $Header );
		
		}
		
	}

}