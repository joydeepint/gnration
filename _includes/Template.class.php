<?php

class Template {

	public $Template;

	public function __construct( $Tpl ) {
		$this->Template = $Tpl;
	}
	
	public function parseVariable( $Var, $Val ) {
	
		$this->Template = str_replace( '#{' . $Var . '}', $Val, $this->Template );
	
	}
	
	protected function parseArray( Array $Array ) {
	
		foreach( $Array as $K => $V ) {
			
			$this->parseVariable( $K, $V );
		
		}
		
		return $this->Template;
		
	}
	
	public function evaluate( $Array ) {
	
		// An alias for parseArray() basically...
		
		$Array = (array)$Array;
		
		return $this->parseArray( $Array );
	
	}

}