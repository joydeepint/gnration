<?php

class View extends Controller {
	
	public function __construct( $Controller ) {
		
		foreach( $Controller as $K => $V ) {
			
			$this->$K = $V;
		
		}
				
		$this->initPublic();

	}

	private function initPublic() {

		$this->siteName = Core::getConfiguration( 'site_name' );

	}

}