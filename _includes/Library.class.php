<?php

class Library {

	protected $libraries;
	
	public function load( $libraryFile, $constructArgs ) {
	
		$libraryFile = str_replace( '_', '/', $libraryFile );
		
		$Path = LIBRARY_PATH . $libraryFile . '.class.php';
		
		if( file_exists( $Path ) !== false ) {
			
			$class = str_replace( '/', '_', $libraryFile );
			
			$className = 'Library_' . $class;
			
			$Args  = '';
			$comma = '';
						
			foreach( $constructArgs as $K => $V ) {
			
				$Args .= $comma . '$constructArgs[ \'' . $K . '\' ]';
				$comma = ', ';
			
			}
			
			if( is_array( $this->libraries ) !== false ) {
				
				$Key = count( $this->libraries );
			
			} else {
			
				$Key = 0;
			
			}
			
			$eval = '$this->libraries[' . $Key . '] = new ' . $className . '( ' . $Args . ' );';
			
			eval( $eval );
			
			return $this->libraries[ $Key ];
						
		} else {
		
			throw new GNR_Exception( 'Could not find library package ' . $libraryFile . '.' );
		
		}
	
	}

}