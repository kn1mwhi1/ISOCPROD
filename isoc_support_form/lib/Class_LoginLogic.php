<?php 
require_once 'Class_LoginDB_In.php';
require_once 'Class_LoginDB_Out.php';
require_once 'Class_ISOC_EMAIL.php';

class LoginLogic
{
	private $FromDB;
	private $ToDB;
	private $email;
	private $errorContainer;

	// Constructor
	function LoginLogic()
	{
		$this->instantiateVariables();
	}
	// Instantiate Variables used in this class
	private function instantiateVariables()
	{
		 // Database communication variables
		 $this->FromDB = new LoginDB_In();
		 $this->ToDB = new LoginDB_Out();
		 $this->email = new ISOC_EMAIL();		
		 $this->errorContainer = array();
	}
	
	
	public function sanitize_input($astring)
	{
		 $astring = trim($astring);
		 $astring = stripslashes($astring);
		 $astring = htmlspecialchars($astring);
		 return $astring;
	}
	
	
	// Adds "error" in the class field of html object , used for validation
	public function input_error( $nameOfObject )
	{
		foreach ( $this->errorContainer as &$value)
		{
			if ($value == $nameOfObject)
			{
				echo 'error';
				return; // end execution of loop
			}
		}
	}
	
	public function check_POST ( $nameOfObject )
	{
		if ( empty($_POST[ $nameOfObject ]) || $this->validate_input($nameOfObject ) ) 
		{
			$this->errorContainer[] = $nameOfObject;
			return false;  // do not send info to database 
		}
		else
		{
			return true; //submit data to database
		}
		
	}
	
	public function checkUserSubmittedData()
	{
	
		if ($_SERVER["REQUEST_METHOD"] == "POST") 
		{
	  
			if ( $this->check_POST('namebox') && $this->check_POST('numberbox') && $this->check_POST('emailbox') && $this->check_POST('textboxSubject') &&
				$this->check_POST('textboxCC') && $this->check_POST('options') && $this->validateInfo('contactMethod') &&  $this->validateInfo('eventIdName')
				&&  $this->validateInfo('environment_opts') &&  $this->validateInfo('request_type_opts') &&  $this->validateInfo('select_dynamic_request_type')
				&&  $this->validateInfo('detailsTextArea') &&  $this->validateInfo('Urgency') &&  $this->validateInfo('datetime1') &&  $this->validateInfo('datetime2'))
			{
				$this->convertVariablesToArray();
				
				

				
				
				// submit requester to DB
				try
				{
					// Create popup 
					
					// Display Ticket number
					
					echo '<link rel="stylesheet" type="text/css" href="css/cssPopup.css" />';
					
					echo '
						<div id="submitted" class="overlay">
							<div class="popup center">
											
								<h2>'.$this->namebox.' your request has been successfully submitted.</h2>'
								
						 ;
					echo '	<div class="content center">
							<br />Your request ticket number is: <b>'.$this->submitEntireRequesterToDB().'</b>
							<br />A summary email has been sent to your contact email.
							<div class="space10"></div>
							<br />Thank you for using the ISOC Request Form!
					
							<form action="supportrequestform.php">
								<input type="submit" class="btn btn-primary center bottom" value="Ok">
							</form>
							
						 </div>

											
							</div>
							</div>




							<script type="text/javascript">

							// Show popup
							loadUrl("#submitted");
							
							// stop scrolling
							$("body").addClass("stop-scrolling")

							function loadUrl(newLocation)
							{
							window.location = newLocation;
							return false;
							}
							</script>

';  // End of Echo statement

				// send requester email
					$this->requesterEmailSend();
					
				// send email to ISOC
					$this->isocEmailSend();
					
				// Record user submission date
					$this->isocUpateSubmissionDateTime();
			
				}
				catch (Exception $e) 
				{
					echo $e;
				}
				
			}
		}
	}
	
	
	public function validateInfo( $nameOfObject )
	{
		if ( $this->validate_input($nameOfObject ) ) 
		{
			return false;  // do not send info to database 
		}
		else
		{
			return true; //submit data to database
		}
	}
	
	
	public function validate_input( $nameOfObject ) 
	{
			//***********  NAME *****************************
			// Perform Data Sanitization on First and Last Name of Requeset Form.
				// validation is for letters and white space only
			if ($nameOfObject == 'namebox' ) // ||  )
			{	
				if (preg_match("/^[a-zA-Z ]*$/",$_POST[$nameOfObject]) )
				{
					// Calls sanitize function and then saves results in the nambox variable located in this class.
					$this->namebox = $this->sanitize_input($_POST[$nameOfObject]);
					return false; // pass validation
				}
				else
				{
					return true; // failed validation
				}
			}
	

			//************* Contact Number ***********************
			// Perform Data Sanitization on the Contact Numberbox
			if ($nameOfObject == 'numberbox')
			{	// Calls sanitize function and then saves results in the numberbox variable located in this class.
					// Checks the length of the string and also ensures the data is only numbers
				if (( strlen($_POST[$nameOfObject]) == 10 || strlen($_POST[$nameOfObject]) == 9) && preg_match('/^\d+$/',$_POST[$nameOfObject]) )
				{
					$this->numberbox = $this->sanitize_input($_POST[$nameOfObject]);
					return false; // pass validation
				}
				else
				{
					return true; // failed validation
				}
				
			}
			
			//********* Subject ********************
			// Perform Data Sanitization on subject box
			if ($nameOfObject == 'textboxSubject')
			{	// Calls sanitize function and then saves results in the name box variable located in this class.
				$this->textboxSubject = $this->sanitize_input($_POST[$nameOfObject]);
				return false; // pass validation
			}
			
			
			
			
			//*************** Contact Email ******************
			// Perform Data Sanitization on Email from User.
			if ($nameOfObject == 'emailbox')
			{	// Calls sanitize function and then saves results in the name box variable located in this class.
				
				if (!filter_var($_POST[$nameOfObject], FILTER_VALIDATE_EMAIL) === false) 
				{
				  	$this->emailbox = $this->sanitize_input($_POST[$nameOfObject]);
					return false;  // pass validation
				} else {
					return true;  // fail validation
				}
			}
			
			
			
			
			//****** Copy Email ************************
			// Perform Data Sanitization on CC Email from User.
	
			if ($nameOfObject == 'textboxCC')
			{	// Calls sanitize function and then saves results in the name box variable located in this class.
					
				// get email addresses from post variable
				$emails = $_POST[$nameOfObject];
				
				// separate each value with a comma to an array.
				$explode = explode(',',$emails); // Explodes the emails by the comma
				
			
				// Loop through each email and validate it
				foreach($explode as $email) 
				{
					if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) 
					{
						// successful yeah.. do nothing.
					} else 
					{
							$this->testVariable = "Coming back as true";
							return true;  // failed validation
					}
				}

				// take array and place in one string
				$tmp = implode(", ",$explode);
				
				// Sanitize
				$this->textboxCC = $this->sanitize_input($tmp);
				return false;  // pass validation
			}
			
		
			
			//******  Preferred Contact Method ***********
			// Perform Data Sanitization on contactMethod from User.
			if ($nameOfObject == 'contactMethod')
			{	// Calls sanitize function and then saves results in the name box variable located in this class.
				$this->contactMethod = $this->sanitize_input($_POST[$nameOfObject]);
				return false;  // pass validation
			}
			
			//******* Please Select an Option Drop down ***************************************
			// Ensures user chooses an option in the main option drop down box before submitting.
			if ( $nameOfObject == 'options' )
			{	
				if ($_POST['options'] == 'Select an option')
				{
					return true; // Return true for the check_POST function in order to add object to array
				}
				else
				{	// Save in variable options in this class
					$this->options = $_POST['options'];
					return false;
				}
			
			}
			
			//***********************  ENVIRONMENT Drop down *********************************
			// save environment_opts from POST to local variable.
			if ($nameOfObject == 'environment_opts')
			{	// Calls sanitize function and then saves results in the name box variable located in this class.
				$this->environment_opts = $_POST[$nameOfObject];
				return false;  // pass validation
			}
			
			//******************* PLEASE Select Request Type Drop down *****************************
			// save request_type_opts from POST to local variable.
			if ($nameOfObject == 'request_type_opts')
			{	// Calls sanitize function and then saves results in the name box variable located in this class.
				$this->request_type_opts = $_POST[$nameOfObject];
				return false;  // pass validation
			}
			
			//***************** Additional Questions Drop Down *************************************************
			// save select_dynamic_request_type from POST to local variable.
			if ($nameOfObject == 'select_dynamic_request_type')
			{	// Calls sanitize function and then saves results in the name box variable located in this class.
				$this->select_dynamic_request_type = $_POST[$nameOfObject];
				return false;  // pass validation
			}
			
			//********* Please enter the Job/process/stream/daemon name text area **********************************
			// Perform Data Sanitization on eventIdName from User.
			if ($nameOfObject == 'eventIdName')
			{	// Calls sanitize function and then saves results in the name box variable located in this class.
				$this->eventIdName = $this->sanitize_input($_POST[$nameOfObject]);
				return false;  // pass validation
			}
			
			//********* Please enter the details of your request text area **********************************
			// Perform Data Sanitization on eventIdName from User.
			if ($nameOfObject == 'detailsTextArea')
			{	// Calls sanitize function and then saves results in the name box variable located in this class.
				$this->detailsTextArea = $this->sanitize_input($_POST[$nameOfObject]);
				return false;  // pass validation
			}
			
			//********* Please enter the details of your request text area **********************************
			// Perform Data Sanitization on eventIdName from User.
			if ($nameOfObject == 'Urgency')
			{	// Calls sanitize function and then saves results in the name box variable located in this class.
				$this->Urgency = $this->sanitize_input($_POST[$nameOfObject]);
				return false;  // pass validation
			}
			
			//********** Date Time Box from Calendar 1 ***********************
			// Perform Data Sanitization on datebox1 from User.
			if ($nameOfObject == 'datetime1')
			{	// Calls sanitize function and then saves results in the name box variable located in this class.
				if (!isset($_POST[$nameOfObject]) )
				{
					$_POST[$nameOfObject] = date("Y-m-d H:i:s");
				}
				else
				{
					$_POST[$nameOfObject] = date("Y-m-d H:i:s", strtotime($_POST[$nameOfObject]) );
				}
				
			    $this->datetime1 = $this->sanitize_input($_POST[$nameOfObject]);
				return false;  // pass validation
			}
			
			//********** Date Time Box from Calendar 2 ***********************
			// Perform Data Sanitization on datebox2 from User.
			if ($nameOfObject == 'datetime2')
			{	// Calls sanitize function and then saves results in the name box variable located in this class.
				if (!isset($_POST[$nameOfObject]) )
				{
					$_POST[$nameOfObject] = date("Y-m-d H:i:s");
				}
				else
				{
					$_POST[$nameOfObject] = date("Y-m-d H:i:s", strtotime($_POST[$nameOfObject]) );
				}
				
				$this->datetime2 = $this->sanitize_input($_POST[$nameOfObject]);
				return false;  // pass validation
			}
	}
	
	
	
	
}
?>