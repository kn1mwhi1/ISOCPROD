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
	
	public function addTomessagePopUp( $CustomType, $title , $text, $type, $confirmButtonText = '', $customJavaFunction = '')
	{
		$this->messagePopUp[0] = $CustomType;	// CONFIRM	
		$this->messagePopUp[1] = $title;	
		$this->messagePopUp[2] = $text;	
		$this->messagePopUp[3] = $type;	// "warning"
		$this->messagePopUp[4] = $confirmButtonText;
		$this->messagePopUp[5] = $customJavaFunction; //  function(){   swal("Deleted!", "Your imaginary file has been deleted.", "success"); }
	}
	
	public function addToDoublemessagePopup( $CustomType, $title , $text, $type, $confirmButtonText = '', $cancelButtonText, $customJavaFunctionConfirm, $customJavaFunctionCanceled )
	{
		$this->messagePopUp[0] = $CustomType;	// CONFIRM	
		$this->messagePopUp[1] = $title;	
		$this->messagePopUp[2] = $text;	
		$this->messagePopUp[3] = $type;	// "warning"
		$this->messagePopUp[4] = $confirmButtonText;
		$this->messagePopUp[5] = $cancelButtonText; // cancelButtonText
		$this->messagePopUp[6] = $customJavaFunctionConfirm; // cancelButtonText
		$this->messagePopUp[7] = $customJavaFunctionCanceled; // cancelButtonText
	}
	
	private function okNotify()
	{
			echo '
			<script type="text/javascript"> 
				swal({   title: "'.$this->messagePopUp[1].'",   text: "'.$this->messagePopUp[2].'",   type: "'.$this->messagePopUp[3].'",   confirmButtonText: "Ok" }); 
			</script>';
		
	}
	
	private function confirmNotify()
	{
		echo '
		<script type="text/javascript"> 
		swal({   title: "'.$this->messagePopUp[1].'",   text: "'.$this->messagePopUp[2].'",   type: "'.$this->messagePopUp[3].'",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "'.$this->messagePopUp[4].'",   closeOnConfirm: false }, '.$this->messagePopUp[5].');
		</script>';
	
	}
	
	private function doubleConfirmNotify()
	{
		echo '
		<script type="text/javascript"> 
		
		swal({   title: "'.$this->messagePopUp[1].'",   text: "'.$this->messagePopUp[2].'",   type: "'.$this->messagePopUp[3].'",   showCancelButton: true,
		confirmButtonColor: "#DD6B55",   confirmButtonText: "'.$this->messagePopUp[4].'",   cancelButtonText: "'.$this->messagePopUp[5].'",   
		closeOnConfirm: false,   closeOnCancel: false }, function(isConfirm){   if (isConfirm) {     '.$this->messagePopUp[6].'   } 
		else {     '.$this->messagePopUp[7].'   } });
		</script>';
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
			case "CONFIRM":
					return $this->validateEmail( $nameOfObject );
				break;
			case "DOUBLECONFIRM":
					return $this->doubleConfirmNotify();
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