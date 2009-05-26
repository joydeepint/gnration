<?php

class GNR_Exception extends Exception {

	public function __construct( $Error, $errorMsg = 0 ) {
			
		$this->strError = $Error;
		$this->strCode	= $errorMsg;
		
		parent::__construct( $Error, $errorMsg );
	
	}
	
	public function __toString() {
	
		$Error		= (string)$this->strError;
		$errorMsg	= (int)$this->strCode;
		$this->stack_trace = $this->getTraceAsString();
		
		unset( $this->strError );
		unset( $this->strCode );
		
		$html = '<table cellpadding="4" cellspacing="0" width="100%" style="font-family: Arial; font-size: 13px;">';
			$html .= '<thead style="background-color: rgb(255,28,62);">';
				$html .= '<tr>';
					$html .= '<td colspan="2" style="border: 1px solid #c5c5c5; color: rgb(159,0,24); font-size: 18px; font-weight: bold;"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAcCAIAAAAbRoOHAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAAPpJREFUSEu9lVEKwjAMhit4CWGvvnsCz+KdffZlCB7CyfxnNGvTNAllWMIYI/v40m7Jbh7OyVvT/bEfDl5WSmDZ8UxHUHB1M//IIqlxHCNqjtdmLAbNn+WqWV6bsQQootb0ylmorp9VV0cse9d0LyH1ul0iagqrlspZhprDgg5A0/UUUZMsVQp/YkTNYrEUWBG1gqVKgVKz1F1rsliKWa7aympJtVi1ms7KpXKWrfZlGVJ4Pw/jQBWWkBJehtrCcqXoHDlaapJFUpGo/9BlwFBH5zbgz65fhmgeK4txnBG/ofZd1Ahcx+I5UJxjvLo8k8dw8a3iaUfwPH8D2Jr0E77tOJwAAAAASUVORK5CYII=" align="left" /> <strong>Error' . ( ( $errorMsg > 0 ) ? ' (#' . $errorMsg . ')' : '' ) . ':</strong> ' . $Error . '</td>';
				$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody style="background-color: #fcfcfc;">';
			
				foreach( $this as $K => $V ) {
				
					if( $V != '' ) {
   
						if( is_array( $V ) !== false ) {
   
							$V = '<pre>' . print_r( $V, true ) . '</pre>';
   
						}
						
						$K = str_replace( '_', ' ', $K );
   
						$html .= '<tr>';
							$html .= '<td style="border: 1px solid #e4e4e4; font-weight: bold;">' . ucwords( $K ) . '</td>';
							$html .= '<td style="border: 1px solid #e4e4e4; background: #FFFFFF">' . $V . '</td>';
						$html .= '</tr>';
						
					}

				}

			$html .= '</tbody>';
		$html .= '</table>';
		
		echo $html;
		die;
	
	}

}