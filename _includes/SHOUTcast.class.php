<?php

class SHOUTcast {
	
	public $config	= Array();
	public $XML_URI	= 'http://#{host}:#{port}/admin.xml?user=#{user}&pass=#{pass}';
	public $HTTP;
	
	public function __construct() {
	
		$this->config = Core::getConfiguration( 'radio_details' );
		$this->parseXML();
		$this->HTTP = new HTTP_Request( $this->XML_URI );

	}
	
	public function parseXML() {
		
		$this->Templater = new Template( $this->XML_URI );
		
		$this->Templater->parseArray( $this->config );
	
		$this->XML_URI	= $this->Templater->Template;
	
	}
	
	public function loadXML() {
	
	}
	
	public function getListeners() {
	}
	
	public function getSong( $History = 0 ) {
	}
	
	public function getArtist(){
	}

}