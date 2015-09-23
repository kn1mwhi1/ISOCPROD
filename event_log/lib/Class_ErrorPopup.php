<?php 
class ErrorPopup 
{
	private $messagePopUp;

	// Constructor
	function ErrorPopup()
	{
		$this->instantiateVariables();
	}
	// Instantiate Variables used in this class
	private function instantiateVariables()
	{		
		 $this->messagePopUp = array();
	}
	
	public function addTomessagePopUp( $CustomType, $title , $text, $type )
	{
		$this->messagePopUp[0] = $CustomType;		
		$this->messagePopUp[1] = $title;	
		$this->messagePopUp[2] = $text;	
		$this->messagePopUp[3] = $type;	
	}
	
	private function okNotify()
	{
			echo '
			<script type="text/javascript"> 
				swal({   title: "'.$this->messagePopUp[1].'",   text: "'.$this->messagePopUp[2].'",   type: "'.$this->messagePopUp[3].'",   confirmButtonText: "Ok" }); 
			</script>';
			exit;
	}
		
	
	public function notifyMessage()
	{
		// exit if there are no messages to notify.
		if (!isset($this->messagePopUp[0]) )
		{
			exit;
		}
		
		
		// Make type all upper-case
		$aType = strtoupper( $this->messagePopUp[0] );
		
		switch ($aType) 
		{
			case "OK":
					$this->okNotify();
					return true;
				break;
			case "temp1":
					return $this->validateEmail( $nameOfObject );
				break;
			case "temp2":
					return $this->validateMultipleEmails( $nameOfObject );
			case "temp3":
					return $this->validateIntegers( $nameOfObject );//******************
			case "temp4":
					return $this->validateUSAPhoneNumber( $nameOfObject );
			case "temp5":
					return $this->validateAllCharaters( $nameOfObject );//******************
				break;
			default:
		}	
	}
}
?>