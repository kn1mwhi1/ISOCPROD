<?php 
require_once 'Class_ISOCSupportFormDB_Out.php';
require_once 'Class_ISOCSupportFormDB_In.php';
require_once 'Class_ISOC_EMAIL.php';
require_once 'lib/Class_ErrorPopup.php';

class LogicIsocSupportForm 
{
	private $FromDB;
	private $ToDB;
	private $email;
	public $errorContainer;
	public $cleanData;
	public $responseData;
	public $popup;
	
	// Values from Support Form
	
		//From text boxes
	private $namebox;
	private $numberbox;
	private $textboxSubject;
	private $emailbox;
	private $textboxCC;
	private $datetime1;
	private $datetime2;
	
		// From Drop Downs
	private $options;
	private $environment_opts;
	private $request_type_opts;
	private $select_dynamic_request_type;
	
		// From text Areas
	private $eventIdName;
	private $detailsTextArea;
	
		//From Radio Buttons
	private $contactMethod;
	private $Urgency;
	
		// From database
	private $requestTicketNumber;
	private $requestContactID;

	
	// Constructor
	function LogicIsocSupportForm()
	{
		$this->instantiateVariables();
	}

		
	private function instantiateVariables()
	{
		 // Database communication variables
		 $this->FromDB = new ISOCSupportFormDB_Out();
		 $this->ToDB = new ISOCSupportFormDB_In();
		 $this->email = new ISOC_EMAIL();
		 $this->errorContainer = array();
		 $this->cleanData = array();
		 $this->responseData = array();
		 $this->requestTicketNumber = "";
		 $this->requestContactID = "";
		 $this->popup = new ErrorPopup();
		 
		 // Text box variables
		 $this->namebox = "";
		 $this->numberbox = "";
		 $this->textboxSubject = "";
		 $this->emailbox = "";
		 $this->textboxCC = "";
		 $this->datetime1 = "";
		 $this->datetime2 = "";
	
		 // Drop down variables
		 $this->options= "";
		 $this->environment_opts = "";
		 $this->request_type_opts = "";
		 $this->select_dynamic_request_type = "";
		
		 // From text Areas
		 $this->eventIdName = "";
		 $this->detailsTextArea = "";
		
		 //From Radio Buttons
		 $this->contactMethod = "";
		 $this->Urgency = "";		
	}

	
	public function testPrintVariables()
	{
		echo "User email: $this->emailbox\n";
		echo "CC emails: $this->textboxCC";
	}
	
	
	public function getFromDB()
	{
		return $this->FromDB;
	}
		
		
	
	// convert variables used to communicate with database to an array
	public function convertVariablesToArray()
	{
		
	
			// Textboxes
			 $this->cleanData['namebox'] = $this->namebox;
			 $this->cleanData['numberbox'] = $this->numberbox;
			 $this->cleanData['textboxSubject'] = $this->textboxSubject;
			 $this->cleanData['emailbox'] = $this->emailbox;
			 $this->cleanData['textboxCC'] = $this->textboxCC;
			 $this->cleanData['datetime1'] = $this->datetime1;
			 $this->cleanData['datetime2'] = $this->datetime2;
		
				// From Drop Downs
			 $this->cleanData['options'] = $this->options;
			 $this->cleanData['environment_opts'] = $this->environment_opts;
			 $this->cleanData['request_type_opts'] = $this->request_type_opts;
			 $this->cleanData['select_dynamic_request_type'] = $this->select_dynamic_request_type;
			
				// From text Areas
			 $this->cleanData['eventIdName'] = $this->eventIdName;
			 $this->cleanData['detailsTextArea'] = $this->detailsTextArea;
			
				//From Radio Buttons
			 $this->cleanData['contactMethod'] = $this->contactMethod;
			 $this->cleanData['Urgency'] = $this->Urgency;
			 
	}
	
	
		private function createISOCEmailBody()
	{
		if ($this->Urgency == 'Immediately')
		{
			$tempUrgency = $this->Urgency;
		}
		else
		{
			$tempUrgency = $this->Urgency.'<br /><b>Start:</b> '.date("l jS \of F Y h:i:s A", strtotime($this->datetime1)).'<br /><b>End:</b> '.date("l jS \of F Y h:i:s A", strtotime($this->datetime2) ).'<br />';
		}
		
		
		
		
		$message = '
					<b><u>Ticket Number: </u>'.$this->requestTicketNumber.'</b><br />
					<br />
					<b>Contact Name:</b> '.$this->namebox.'<br />
					<b>Preferred Contact:</b> '.$this->contactMethod.'<br />
					<b>Email:</b> '.$this->emailbox.'<br />
					<b>Phone Number:</b> '.$this->numberbox.'<br />
					<b>Subject:</b> '.$this->textboxSubject.'<br />
					<br />
					<br />
					<b>Perform:</b>      '.$tempUrgency.'<br /> 
					<b>Environment:</b>  '.$this->environment_opts.'<br />
					<b> Option:</b>       '.$this->options.' -> '.$this->eventIdName.'<br />
					<b>Request Type:</b> '.$this->request_type_opts.'<br />
					<b>Details:</b>      '.$this->select_dynamic_request_type.'<br />
					<br />'.$this->detailsTextArea.'<br />
					<br />
					<br />
					<br />
					<br />
					Please click the link to open the request:<br />
					
					
					
					';
					
		return $message;
	}
	
	
	private function createRequesterEmailBody()
	{
		if ($this->Urgency == 'Immediately')
		{
			$tempUrgency = $this->Urgency;
		}
		else
		{
			$tempUrgency = $this->Urgency.'<br /><b>Start:</b> '.date("l jS \of F Y h:i:s A", strtotime($this->datetime1)).'<br /><b>End:</b> '.date("l jS \of F Y h:i:s A", strtotime($this->datetime2) ).'<br />';
		}
		
		
		
		
		$message = 'Below is a summary of your request.<br />
					You should receive a response email within 10-15 minutes.  If you have additional questions please reply to this email.<br />
					<br />
					<b><u>Ticket Number: '.$this->requestTicketNumber.'</u></b><br />
					<br />
					<b>Perform:</b>      '.$tempUrgency.'<br /> 
					<b>Environment:</b>  '.$this->environment_opts.'<br />
					<b> Option:</b>       '.$this->options.' -> '.$this->eventIdName.'<br />
					<b>Request Type:</b> '.$this->request_type_opts.'<br />
					<b>Details:</b>      '.$this->select_dynamic_request_type.'<br />
					<br />'.$this->detailsTextArea.'<br />
					<br />
					<br />
					<br />
					<br />
					Thanks for using the ISOC request form,<br />
					IS Operations
					
					
					
					';
					
		return $message;
	}
	
	
	private function sanitizeInfo()
	{
		return $this->ToDB->sanitizeStringForSQL( $string );
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
	
	public function convertTime12to24( $atime )
	{
		// 12-hour time to 24-hour time 
		$time_in_24_hour_format = date("H:i", strtotime("$atime"));
	}
	
	public function convertTime24to12( $atime )
	{
		// 24-hour time to 12-hour time 
		$time_in_12_hour_format = date("g:i a", strtotime("$atime"));	
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
		if ( !isset($_POST[ $nameOfObject ]) || empty($_POST[ $nameOfObject ]) || $this->validate_input($nameOfObject ) ) 
		{
			// if emtpy then return true only for the CC textbox
				if ( $nameOfObject == "textboxCC" && (!isset($_POST['$textboxCC']) || $_POST['$textboxCC'] == '') )
				{
					return true;
				}
				
			
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
					$customJavaFunctionConfirm = 'swal("Ticket Successfully Submitted!", "Your request ticket number is: '.$this->submitEntireRequesterToDB().'\n\nA summary email has been sent to your contact email.", "success");';
					$customJavaFunctionCanceled = 'swal("Cancelled", "Ticket submission cancelled.", "error");';
					
					
					
					$this->popup->addTomessagePopUp( 'OK' , 'Ticket Successfully Submitted!' , 'Your request ticket number is: '.$this->submitEntireRequesterToDB().'  \n\nA summary email has been sent to your contact email.', 'success' );
					/*
					$this->popup->addToDoublemessagePopup( 'DOUBLECONFIRM', 'Submit a new request' , 'Press OK to submit a new request.',
					'warning', 'Submit New Request!', 'Cancel', $customJavaFunctionConfirm, $customJavaFunctionCanceled );
					*/
					
					
					
 // End of Echo statement

				// send requester email *******************************************************************************
					
					$this->requesterEmailSend( $this->createRequesterEmailBody() );
					
				// send email to ISOC
					$this->isocEmailSend();
					
				// Record user submission date
					$this->isocUpateSubmissionDateTime();
			
				}
				catch (Exception $e) 
				{
					echo $e;
				}
				
						
						if(!isset($_SESSION)) 
						 {
							session_start();
						 }
						 
						 $_SESSION['ALERT'] = '<script>swal("Ticket Successfully Submitted!", "Your request ticket number is: '.$this->submitEntireRequesterToDB().'\n\nA summary email has been sent to your contact email.", "success");</script>';
						 

				
					   // redirect to blank page to stop the user from refreshing and submitting.
						header('location: /lib/redirect.php');
						
						//$this->popup->notifyMessage();
					
			}
		}
		

{
    
    
}
		
		
		
	}

	
	
	
	private function isocUpateSubmissionDateTime()
	{
			$dateTimeNow = date('Y-m-d H:i:s');
			$tempArray = array("REQUEST_TICKET_NUMBER"=>"$this->requestTicketNumber", "REQUEST_SUBMISSION_DATETIME"=>"$dateTimeNow", "REQUEST_STATUS"=>"ACTIVE");
			$this->ToDB->insertRecordOneTable( $tempArray , 'TB_SUPPORT_FORM_METADATA', 'iss' );
	}
	

	
	private function isocEmailSend()
	{
	
	
	
	// create email message
		$message = '
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>New ISOC Support Request</title>

</head>

<body bgcolor="#f2eded">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f2eded">
  <tr>
    <td><table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
        <tr>
          <td valign="middle">
		  
		  <div style="text-align: center;font-family: Helvetica; font-variant: small-caps; color: #FFFFFF;  background: #66C285;">New ISOC Request</div>
			
			</td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="10%">&nbsp;</td>
                <td width="80%" align="left" valign="top"><font style="font-family: Georgia, "Times New Roman", Times, serif; color:#010101; font-size:24px"><strong><em>IS Operations,</em></strong></font><br /><br />
                  <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">
				  
				  '.$this->createISOCEmailBody().'
					<a href="http://'.$_SERVER['HTTP_HOST'].'/requestformresponse.php?'.$this->requestTicketNumber.'">Open Ticket</a>
				</font>
				
				</td>
                <td width="10%">&nbsp;</td>
              </tr>
			  
			  
			  
              <tr>
                <td>&nbsp;</td>
                <td align="right" valign="top"></td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          
        </tr>
        
      </table></td>
  </tr>
</table>
</body>
</html>


';
			
			// set the message
			$this->email->setMessage( $message );
			
			// set the To field of email
			$this->email->setTo( 'ISOperationsCenter@uscellular.com' );
			
			$this->email->setFrom( $this->emailbox );
			
			// set the cc email field
			$this->email->setCCEmail( $this->textboxCC );
			
			// set the subject field of email
			$this->email->setSubject( 'New ISOC Support Request Ticket: '.$this->requestTicketNumber.' -'.$this->eventIdName.'-('.$this->select_dynamic_request_type.')-Perform: '.$this->Urgency );
			
			// prepare headers which informs the mail client that this will be html and the from and to
			$this->email->setHeaders();
			
			
			// Detect if the user requested a CC or not, then send the appropriate email.
			if ($this->textboxCC == '')
			{
				
				$subject = 'New ISOC Support Request Ticket: '.$this->requestTicketNumber.' -'.$this->eventIdName.'-('.$this->select_dynamic_request_type.')-Perform: '.$this->Urgency;
				$this->email->sendEmailNoCC( 'ISOperationsCenter@uscellular.com', $this->emailbox, $subject, $message);
			}
			else
			{
							// set the message
				$this->email->setMessage( $message );
				
				// set the To field of email
				$this->email->setTo( 'ISOperationsCenter@uscellular.com' );
				
				$this->email->setFrom( $this->emailbox );
				
				// set the cc email field
				$this->email->setCCEmail( $this->textboxCC );
				
				// set the subject field of email
				$this->email->setSubject( 'New ISOC Support Request Ticket: '.$this->requestTicketNumber.' -'.$this->eventIdName.'-('.$this->select_dynamic_request_type.')-Perform: '.$this->Urgency );
				
				// prepare headers which informs the mail client that this will be html and the from and to
				$this->email->setHeaders();
				
							// send email
				$this->email->sendEmail();
			}
	}
	
	
	
	
	
	private function requesterEmailSend( $message, $subject ='ISOC Request Form Confirmation Email')
	{
	
		
	
		// create email message
		$message = '
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ISOC Request Confirmation Email</title>

</head>

<body bgcolor="#f2eded">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f2eded">
  <tr>
    <td><table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
        <tr>
          <td valign="middle">
		  
		  <div style="text-align: center;font-family: Helvetica; font-variant: small-caps; color: #FFFFFF;  background: #66C285;">'.$subject.'</div>
			
			</td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="10%">&nbsp;</td>
                <td width="80%" align="left" valign="top"><font style="font-family: Georgia, "Times New Roman", Times, serif; color:#010101; font-size:24px"><strong><em>Hi '.$this->namebox.',</em></strong></font><br /><br />
                  <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">
				  
				  '.$message.'
					<br />
					<br />
					<a href="http://'.$_SERVER['HTTP_HOST'].'/supportrequestform.php">ISOC Request Form</a>
				</font>
				
				</td>
                <td width="10%">&nbsp;</td>
              </tr>
			  
			  
			  
              <tr>
                <td>&nbsp;</td>
                <td align="right" valign="top"></td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          
        </tr>
        
      </table></td>
  </tr>
</table>
</body>
</html>


';
			
			
			
			
			if ($this->textboxCC == '')
			{
				$this->email->sendEmailNoCC( $this->emailbox, 'ISOperationsCenter@uscellular.com' , 'ISOC Request# '.$this->requestTicketNumber.' has been received.', $message);
			}
			else
			{
				// set the message
				$this->email->setMessage( $message );
				
				// set the To field of email
				$this->email->setTo( $this->emailbox.'; '.$this->textboxCC );
				
				$this->email->setFrom( 'ISOperationsCenter@uscellular.com');
				
				
				// set the cc email field
				$this->email->setCCEmail( $this->textboxCC );
				
				// set the subject field of email
				$this->email->setSubject( 'ISOC Request# '.$this->requestTicketNumber.' has been received.' );
				
				// prepare headers which informs the mail client that this will be html and the from and to
				$this->email->setHeaders();
				
				// send email
				$this->email->sendEmail();
			}
	}
	

	private function convertRequesterVariablesToArray()
	{
		$tempRequester = array("REQUESTER_NAME"=>"$this->namebox", "REQUESTER_CONTACT_NUMBER"=>"$this->numberbox", "REQUESTER_EMAIL_ADDRESS"=>"$this->emailbox",
								"REQUESTER_CC_ADDRESS"=>"$this->textboxCC", "REQUESTER_EMAIL_SUBJECT"=>"$this->textboxSubject", "REQUESTER_CONTACT_METHOD"=>"$this->contactMethod");
							
		return $tempRequester;
	}
	
	
	private function convertRequestDetailsVariablesToArray()
	{
	
		$tmpVariable = $this->submitRequesterToDB();
		$tempRequestDetails = array("REQUESTER_ID"=> "$tmpVariable" , "MAIN_OPTIONS_VALUE"=>"$this->options", "PROCESS_DETAILS_DATA"=>"$this->eventIdName",
								"ENVIRONMENT_OPTIONS_VALUE"=>"$this->environment_opts", "REQUEST_TYPE_OPTIONS_VALUE"=>"$this->request_type_opts", "ADDITIONAL_OPTIONS_VALUE"=>"$this->select_dynamic_request_type",
								"REQUEST_DETAILS_DATA"=>"$this->detailsTextArea", "REQUEST_URGENCY"=>"$this->Urgency", "REQUEST_START_DATETIME"=>"$this->datetime1", "REQUEST_END_DATETIME"=>"$this->datetime2");
		return $tempRequestDetails;
	}
	
	
	private function submitRequesterToDB()
	{
		
		$requesterRow = array();
		// check requester with what is in database if false submit, if true get id
		$requesterRow = $this->FromDB->checkUserIDExist( $this->emailbox );
		//print_r($requesterRow);
		
		if (!isset($requesterRow['REQUESTER_ID']))
		{
			$this->ToDB->insertRecordOneTable( $this->convertRequesterVariablesToArray(), 'TB_SUPPORT_FORM_REQUESTER' , 'ssssss' ) ;
			return $this->requestContactID = $this->ToDB->getLastTransactionID();
		}
		
		if (isset($requesterRow['REQUESTER_ID']))
		{
			$updateArray = $this->convertRequesterVariablesToArray();
			$whereArray = array("REQUESTER_ID"=>$requesterRow['REQUESTER_ID']);
			$this->ToDB->updateRecordOneTable( $updateArray , $whereArray, 'equals', 'TB_SUPPORT_FORM_REQUESTER' ,'sssssss');
			
			$tempString = $requesterRow['REQUESTER_ID'];
			return $tempString;
		}
		
		
		
		
	}
	
	private function submitEntireRequesterToDB()
	{
		
			$this->ToDB->insertRecordOneTable( $this->convertRequestDetailsVariablesToArray(), 'TB_SUPPORT_FORM_DATA' , 'isssssssss' ) ;
			 
			return $this->requestTicketNumber = $this->ToDB->getLastTransactionID();
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
	
	//**********************************  Retrieve Ticket Functions  *******************************************************************
	
	// Populates the HTML tags based upon tag names.  Must have code in the value.
	//******* Displays values in Textboxes *********************
	public function getTicketInfo( $someValue )
	{
		
		if (isset($this->responseData['REQUEST_TICKET_NUMBER']) )
		{
			switch ($someValue) 
			{
				case 'ISOCTicketID':
					return $this->responseData['REQUEST_TICKET_NUMBER'];
					break;
				case 'RequesterName':
					return $this->responseData['REQUESTER_NAME'];
					break;
				case 'ReplyTo':
					return $this->responseData['REQUESTER_EMAIL_ADDRESS'];
					break;
				case 'CopyTo':
					return $this->responseData['REQUESTER_CC_ADDRESS'];
					break;
				case 'textboxSubject':
					return $this->responseData['REQUESTER_EMAIL_SUBJECT'];
					break;
				case 'ISOCTechnician':
					return $this->responseData['ISOC_TECH_ID_ASSIGNED'];
					break;
				case 'ISOCTechName':
					return $this->responseData['ISOC_TECH_FULL_NAME'];
					break;
				case 'initialSubmitTime':
					return $this->responseData['REQUEST_SUBMISSION_DATETIME'];
					break;
				case 'responseTime':
					return $this->responseData['REQUEST_ACCEPT_DATETIME'];
					break;
				case 'completeTime':
					return $this->responseData['REQUEST_COMPLETION_DATETIME'];
					break;
				case 'request_overview':
					return $this->responseData['REQUEST_OVERVIEW'];
					break;
				case 'status_indicator':
					return $this->statusIndicator();
					break;
				case 'assume_button':
					return $this->hideButtonCancelComplete();
					break;
				case 'timer_hide':
					return $this->hideButtonCancel();
					break;
				default:
					return ;
			}
		}
		
		if ($someValue == 'status_indicator')
		{
			$this->statusIndicator();
		}
		
		// When there is no record hide the Assume Ownership
		if ($someValue == 'assume_button')
		{
			$this->hideButtonCancelComplete();
		}
		
		
		
			return;
	}
	
	
	private function hideButtonCancelComplete()
	{
		if (isset($this->responseData['REQUEST_STATUS']) && ($this->responseData['REQUEST_STATUS'] == 'COMPLETE' || $this->responseData['REQUEST_STATUS'] == 'CANCELED') )
		{
			echo 'hide';	
		}
		
		if (!isset($this->responseData['REQUEST_STATUS']))
		{
			echo 'hide';	
		}
		
		if ($_SESSION['ISOC_TECH_EMPLOYEE_ID'] == $this->responseData['ISOC_TECH_EMPLOYEE_ID'])
		{
			echo 'hide';	
		}
		
		
		
	}
	
private function hideButtonCancel()
	{
		if (isset($this->responseData['REQUEST_STATUS']) && $this->responseData['REQUEST_STATUS'] == 'CANCELED' )
		{
			echo 'hide';	
		}
	}
	
	// Prints out the html tags needed to see the status indicator
	private function statusIndicator()
	{
		
		if(isset($this->responseData['REQUEST_STATUS']) && $this->responseData['REQUEST_STATUS'] != '')
		{
			if($this->responseData['REQUEST_STATUS'] == 'ACTIVE')
			{
				echo '<div class="led-box"><div class="led-yellow"><p class="status">Active</p></div></div>';
			}
			
			if($this->responseData['REQUEST_STATUS'] == 'COMPLETE')
			{
				echo '<div class="led-box"><div class="led-green"><p class="status">Completed</p></div></div>';
			}
			
			if($this->responseData['REQUEST_STATUS'] == 'CANCELED')
			{
				echo'  <div class="led-box"><div class="led-red"><p class="status">Canceled</p></div></div>';
			}
			
			
		}
		else
		{
		
			echo '<div class="led-box"><div class="led-blue"><p class="status">Not Loaded</p></div></div>';
		}
		
	}
	
	
	
	public function retrieveTicket()
	{
		 // must be on all pages
		 if(!isset($_SESSION)) 
		 {
			session_start();
		 }
		
		
		// get the request URI  anything with ?$DATA
		$requestTicketNumber = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
		$_SESSION['REQUEST_TICKET_NUMBER'] = '';

			// Ticket number in URL AND User must be logged in.
		if ( is_numeric ($requestTicketNumber) && isset($_SESSION['ISOC_TECH_EMPLOYEE_ID']) )
		{
			$_SESSION['REQUEST_TICKET_NUMBER'] = $requestTicketNumber;
			
			// load fields into main array with all ticket info
			$this->loadTicketInfoArray( $requestTicketNumber);
		
			// Set the respnce date time and ISOC Tech if its not been set.
			$this->isocUpdateRequestAcceptAndTech( $requestTicketNumber);
			
		}
	}
	
	
	

	private function inProgressEmailBody()
	{		
		$message = 'Your Ticket is now being worked by '.$this->responseData['ISOC_TECH_FULL_NAME'].'.'.'<br />
					<p>Once your request has been completed you will receive another email.</p><br />
					If you have additional questions please reply to this email.
					<br />
					<br />
					<br />
					<br />
					Thanks for using the ISOC request form,<br />
					IS Operations
									
					';
					
		return $message;
	}
	
	private function requestEmailWrapper( $body, $subject ='ISOC Request Form Confirmation Email')
	{
		// create email message
		$message = '
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ISOC Request Confirmation Email</title>

</head>

<body bgcolor="#f2eded">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f2eded">
  <tr>
    <td><table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
        <tr>
          <td valign="middle">
		  
		  <div style="text-align: center;font-family: Helvetica; font-variant: small-caps; color: #FFFFFF;  background: #66C285;">'.$subject.'</div>
			
			</td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="10%">&nbsp;</td>
                <td width="80%" align="left" valign="top"><font style="font-family: Georgia, "Times New Roman", Times, serif; color:#010101; font-size:24px"><strong><em>Hi '.$this->responseData['REQUESTER_NAME'].',</em></strong></font><br /><br />
                  <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">
				  
				  '.$body.'
					<br />
					<br />
					<a href="http://'.$_SERVER['HTTP_HOST'].'/supportrequestform.php">ISOC Request Form</a>
				</font>
				
				</td>
                <td width="10%">&nbsp;</td>
              </tr>
			  
			  
			  
              <tr>
                <td>&nbsp;</td>
                <td align="right" valign="top"></td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          
        </tr>
        
      </table></td>
  </tr>
</table>
</body>
</html>


';
			
	return $message;
	}	
	
	// ********************************  END in progress email ***************************************************
	
	
	// Function loads all values to array in order to be retrived by the getTicketInfo() function.
	private function loadTicketInfoArray ( $aTicketNumber )
	{
		
		$tempTicketInfo = array();
		$tempTicketMeta = array();
		$tempRequester = array();
		$tempTechID = array();
		
		
		$tempTicketInfo = $this->FromDB->getOneRowWhereEquals( 'TB_SUPPORT_FORM_DATA', 'REQUEST_TICKET_NUMBER', $aTicketNumber );
		//print_r($tempTicketInfo);
		
				if ( isset($tempTicketInfo['REQUEST_TICKET_NUMBER']) && $tempTicketInfo['REQUEST_TICKET_NUMBER'] != '')
				{
					$tempTicketMeta = $this->FromDB->getOneRowWhereEquals( 'TB_SUPPORT_FORM_METADATA' , 'REQUEST_TICKET_NUMBER', $aTicketNumber );
					$tempRequester = $this->FromDB->getOneRowWhereEquals( 'TB_SUPPORT_FORM_REQUESTER', 'REQUESTER_ID' , $tempTicketInfo['REQUESTER_ID'] );
					
					// Checks if a Tech has been assiged, if not assigns the Tech pulling up the ticket (from log in)
					if (!isset($tempTicketMeta['ISOC_TECH_ID_ASSIGNED']) || $tempTicketMeta['ISOC_TECH_ID_ASSIGNED'] == '' )
					{
						$tempTicketMeta['ISOC_TECH_ID_ASSIGNED'] = $_SESSION['ISOC_TECH_EMPLOYEE_ID'];
					}
					
					$tempTechID = $this->FromDB->getOneRowWhereEquals( 'TB_ISOC_TECHS', 'ISOC_TECH_EMPLOYEE_ID' , $tempTicketMeta['ISOC_TECH_ID_ASSIGNED'] );
					
				
					

					// RECORD DATE AND TIMES
					$_SESSION['REQUEST_SUBMISSION_DATETIME']= $tempTicketMeta['REQUEST_SUBMISSION_DATETIME'];
					$_SESSION['REQUEST_ACCEPT_DATETIME']= $tempTicketMeta['REQUEST_ACCEPT_DATETIME'];
					$_SESSION['REQUEST_COMPLETION_DATETIME']= $tempTicketMeta['REQUEST_COMPLETION_DATETIME'];
					
					// Convert Time Format
					$tempTicketMeta['REQUEST_SUBMISSION_DATETIME'] = date( 'H:i:s m/d/Y', strtotime($tempTicketMeta['REQUEST_SUBMISSION_DATETIME']) );
					$tempTicketMeta['REQUEST_ACCEPT_DATETIME'] = date( 'H:i:s m/d/Y', strtotime($tempTicketMeta['REQUEST_ACCEPT_DATETIME']) );
					
						if ($tempTicketMeta['REQUEST_COMPLETION_DATETIME'] != '')
						{
							$tempTicketMeta['REQUEST_COMPLETION_DATETIME'] = date( 'H:i:s m/d/Y', strtotime($tempTicketMeta['REQUEST_COMPLETION_DATETIME']) );
						}
					
					
					$this->responseData = array_merge($tempTicketInfo, $tempTicketMeta, $tempRequester);
					$tempCurrentTech = array("ISOC_TECH_FULL_NAME"=>$tempTechID['ISOC_TECH_FIRST_NAME'].' '.$tempTechID['ISOC_TECH_LAST_NAME'], "REQUEST_OVERVIEW"=>$this->createRequestOverview() );
					$this->responseData = array_merge($this->responseData, $tempCurrentTech);
					$this->responseData['ISOC_TECH_EMAIL']=$_SESSION['ISOC_TECH_EMAIL'];
					
				}
				else
				{
					$_SESSION['REQUEST_SUBMISSION_DATETIME']= '';
					$_SESSION['REQUEST_ACCEPT_DATETIME']= '';
					$_SESSION['REQUEST_COMPLETION_DATETIME']= '';
				}
		
	}
	
	// Dectects if the Submission time has been set.. if not then set it with the ISOC Tech.
	private function isocUpdateRequestAcceptAndTech( $aTicketNumber )
	{
		if (isset($this->responseData['REQUEST_TICKET_NUMBER']) )
		{
			$dateTimeNow = date('Y-m-d H:i:s');
			$temp = array();
			
			// get the row that equals the ticket number in the metadata table
			$temp = $this->FromDB->getOneRowWhereEquals('TB_SUPPORT_FORM_METADATA', 'REQUEST_TICKET_NUMBER', $aTicketNumber );
			
			
			// Update initial accept time and send an email to the requester if it has not been done.
			if (!isset( $temp['REQUEST_ACCEPT_DATETIME'] ) )
			{
				$updateTemp = array("REQUEST_ACCEPT_DATETIME" => $dateTimeNow, "ISOC_TECH_ID_ASSIGNED" => $_SESSION['ISOC_TECH_EMPLOYEE_ID'] );
				$whereArray = array("REQUEST_TICKET_NUMBER"=> $aTicketNumber);
				
				$this->ToDB->updateRecordOneTable( $updateTemp , $whereArray, 'equals' , 'TB_SUPPORT_FORM_METADATA' , $fieldTypes = 'ssi');
				
				
				// Send Email to user that a specific Tech is now working their request.
				$subject = 'Ticket Number: '.$this->responseData['REQUEST_TICKET_NUMBER'].' is now in progress.';
				$message = $this->requestEmailWrapper( $this->inProgressEmailBody() , $subject);
				
				
				//$this->email->sendEmailNoCC( $this->responseData['REQUESTER_EMAIL_ADDRESS'], 'isoperationscenter@uscellular.com, '.$this->responseData['ISOC_TECH_EMAIL'], $subject, $message);			
				$this->email->sendEmailWithCC( $this->responseData['REQUESTER_EMAIL_ADDRESS'], 'isoperationscenter@uscellular.com', $this->responseData['ISOC_TECH_EMAIL'], $subject, $message);
			
			}
		}	
	}
	
	public function checkPost()
	{
		// Checks to see if user has posted before checking any validation
		if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit'] == 'Assume Ownership' ) 
		{
			$this->updateISOCTech();
		}
		
		// Checks to see if user has posted before checking any validation
		if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit'] == 'Send Response' ) 
		{
			$this->updateCompletionTime();
			
			// if the request is complete do not send an email.. if its not complete then send an email.
			if ( $_POST['completeTime'] == "" )
			{
				// send email that response is complete
				$subject = 'Ticket: '.$this->responseData['REQUEST_TICKET_NUMBER'].' has been completed.';
				$message = $this->requestCompleteEmailSend( $this->createCompleteEmailBody() , $subject );
				
				// Detect if the user requested a CC or not, then send the appropriate email.
				if ($this->responseData['REQUESTER_CC_ADDRESS'] == '')
				{
					$this->email->sendEmailNoCC( $this->responseData['REQUESTER_EMAIL_ADDRESS'], 'ISOperationsCenter@uscellular.com' ,  $subject, $message);
				}
				else
				{
					$this->email->sendEmailWithCC( $this->responseData['REQUESTER_EMAIL_ADDRESS'], 'isoperationscenter@uscellular.com', $this->responseData['REQUESTER_CC_ADDRESS'], $subject, $message);
				}
			}
		}
		
		//print_r($_POST);
		
		// Checks to see if user has posted before checking any validation
		if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit'] == 'Cancel Request') 
		{
			$this->updateCancel();
			
			// if the request is complete do not send an email.. if its not complete then send an email.
			if ( $_POST['completeTime'] == "" )
			{
				// send email that response is complete
				$subject = 'Ticket: '.$this->responseData['REQUEST_TICKET_NUMBER'].' has been canceled.';
				$message = $this->requestCancelEmailSend( $this->createCancelEmailBody() , $subject );
				
							// Detect if the user requested a CC or not, then send the appropriate email.
				if ($this->responseData['REQUESTER_CC_ADDRESS'] == '')
				{
					$this->email->sendEmailNoCC( $this->responseData['REQUESTER_EMAIL_ADDRESS'], 'ISOperationsCenter@uscellular.com' ,  $subject, $message);
				}
				else
				{
					$this->email->sendEmailWithCC( $this->responseData['REQUESTER_EMAIL_ADDRESS'], 'isoperationscenter@uscellular.com', $this->responseData['REQUESTER_CC_ADDRESS'], $subject, $message);
				}
			
			}
		}
		
		
		//print_r($this->responseData);
	}
	
	// ********************************************  complete email template *******************************************************************************

	private function createCancelEmailBody()
	{
		// if the Post variable does not exist create an empty one.
		if (!isset($_POST['details']))
		{
			$_POST['details'] = '';
		}
		
		// if the request overview is empty then fill in a default.
		if ( $_POST['details'] == '')
		{
			$_POST['details'] = 'Your request has been canceled.  If this is by error please inquire by replying to this email.';
		}
		
		//print_r($_POST);
		
		$message = '
					<b>ISOC Tech Response:</b> '.$_POST['details'].'<br />
					<br />
					<br />
					<b><u>Ticket Number: '.$this->responseData['REQUEST_TICKET_NUMBER'].'</u></b><br />
					<br />
					Thanks for using the ISOC request form,<br />
					IS Operations
					
					
					
					';
					
		return $message;
	}
	
	
	
	private function requestCancelEmailSend( $body, $subject ='ISOC Request Form Confirmation Email')
	{
		// create email message
		$message = '
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ISOC Request Confirmation Email</title>

</head>

<body bgcolor="#f2eded">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f2eded">
  <tr>
    <td><table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
        <tr>
          <td valign="middle">
		  
		  <div style="text-align: center;font-family: Helvetica; font-variant: small-caps; color: #FFFFFF;  background: #66C285;">'.$subject.'</div>
			
			</td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="10%">&nbsp;</td>
                <td width="80%" align="left" valign="top"><font style="font-family: Georgia, "Times New Roman", Times, serif; color:#010101; font-size:24px"><strong><em>Hi '.$this->responseData['REQUESTER_NAME'].',</em></strong></font><br /><br />
                  <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">
				  
				  '.$body.'
					<br />
					<br />
					<a href="http://10.176.105.18/isoc_support_form/supportrequestform.php">ISOC Request Form</a>
				</font>
				
				</td>
                <td width="10%">&nbsp;</td>
              </tr>
			  
			  
			  
              <tr>
                <td>&nbsp;</td>
                <td align="right" valign="top"></td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          
        </tr>
        
      </table></td>
  </tr>
</table>
</body>
</html>


';
			
	return $message;
	}
	
	
	private function createCompleteEmailBody()
	{
		// if the Post variable does not exist create an empty one.
		if (!isset($_POST['details']))
		{
			$_POST['details'] = '';
		}
		
		// if the request overview is empty then fill in a default.
		if ( $_POST['details'] == '')
		{
			$_POST['details'] = 'Your request has been completed.';
		}
		
		//print_r($_POST);
		
		$message = '
					<b>ISOC Tech Response:</b> '.$_POST['details'].'<br />
					<br />
					If you have additional questions please reply to this email.
					<br />
					<br />
					<b>The below is a summary of the actions taken:</b>
					<br />
					<b><u>Ticket Number: '.$this->responseData['REQUEST_TICKET_NUMBER'].'</u></b><br />
					<br />
					<b>Perform:</b>      '.$this->responseData['REQUEST_URGENCY'].'<br /> 
					<b>Environment:</b>  '.$this->responseData['ENVIRONMENT_OPTIONS_VALUE'].'<br />
					<b> Option:</b>       '.$this->responseData['MAIN_OPTIONS_VALUE'].' -> '.$this->responseData['PROCESS_DETAILS_DATA'].'<br />
					<b>Request Type:</b> '.$this->responseData['REQUEST_TYPE_OPTIONS_VALUE'].'<br />
					<b>Details:</b>      '.$this->responseData['ADDITIONAL_OPTIONS_VALUE'].'<br />
					<br />'.$this->responseData['REQUEST_DETAILS_DATA'].'<br />
					<br />
					<br />
					<br />
					<br />
					Thanks for using the ISOC request form,<br />
					IS Operations
					
					
					
					';
					
		return $message;
	}
	
	
	
	private function requestCompleteEmailSend( $body, $subject ='ISOC Request Form Confirmation Email')
	{
		// create email message
		$message = '
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ISOC Request Confirmation Email</title>

</head>

<body bgcolor="#f2eded">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f2eded">
  <tr>
    <td><table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
        <tr>
          <td valign="middle">
		  
		  <div style="text-align: center;font-family: Helvetica; font-variant: small-caps; color: #FFFFFF;  background: #66C285;">'.$subject.'</div>
			
			</td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="10%">&nbsp;</td>
                <td width="80%" align="left" valign="top"><font style="font-family: Georgia, "Times New Roman", Times, serif; color:#010101; font-size:24px"><strong><em>Hi '.$this->responseData['REQUESTER_NAME'].',</em></strong></font><br /><br />
                  <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">
				  
				  '.$body.'
					<br />
					<br />
					<a href="http://'.$_SERVER['HTTP_HOST'].'/supportrequestform.php">ISOC Request Form</a>
				</font>
				
				</td>
                <td width="10%">&nbsp;</td>
              </tr>
			  
			  
			  
              <tr>
                <td>&nbsp;</td>
                <td align="right" valign="top"></td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          
        </tr>
        
      </table></td>
  </tr>
</table>
</body>
</html>


';
			
	return $message;
	}
	
	// ********************************************************   End Email *********************************************************************
	
	
	// Update Ticket Completion Time
	private function updateCancel()
	{
		
		if ($this->responseData['REQUEST_COMPLETION_DATETIME'] == '' && $this->responseData['REQUEST_STATUS'] != 'CANCELED')
		{
			$dateTimeNow = date('Y-m-d H:i:s');
			
			// save to database
				$updateTemp = array("REQUEST_STATUS"=>"CANCELED" );
				$whereArray = array("REQUEST_TICKET_NUMBER"=> $this->responseData['REQUEST_TICKET_NUMBER'] );
						
				$this->ToDB->updateRecordOneTable( $updateTemp , $whereArray, 'equals' , 'TB_SUPPORT_FORM_METADATA' , $fieldTypes = 'si');
				
				// Send completion email to Requester with comments.
				
				// Show pop-up of success
				$this->popup->addTomessagePopUp( 'OK' , 'Ticket Canceled' , 'You have successfully canceled ticket: '.$this->responseData['REQUEST_TICKET_NUMBER'], 'success' );
				
				// Refresh
				$this->retrieveTicket();
		}
		else
		{
			if ( $this->responseData['REQUEST_COMPLETION_DATETIME'] == '')
			{
				// Show pop-up of success
				$this->popup->addTomessagePopUp( 'OK' , '?' , 'The ticket is already canceled.', 'error' );
			}
			else
			{
				// Show pop-up of success
				$this->popup->addTomessagePopUp( 'OK' , '?' , 'You cannot cancel a ticket that has been completed.', 'error' );
			}
		}
	}
	
	
	
	
	// Update Ticket Completion Time
	private function updateCompletionTime()
	{
		
		if ($this->responseData['REQUEST_COMPLETION_DATETIME'] == '' )
		{
			$dateTimeNow = date('Y-m-d H:i:s');
			
			// save to database
				$updateTemp = array("REQUEST_COMPLETION_DATETIME" => $dateTimeNow, "REQUEST_STATUS"=>"COMPLETE" );
				$whereArray = array("REQUEST_TICKET_NUMBER"=> $this->responseData['REQUEST_TICKET_NUMBER'] );
						
				$this->ToDB->updateRecordOneTable( $updateTemp , $whereArray, 'equals' , 'TB_SUPPORT_FORM_METADATA' , $fieldTypes = 'ssi');
				
				// Send completion email to Requester with comments.
				
				// Show pop-up of success
				$this->popup->addTomessagePopUp( 'OK' , 'Ticket Complete' , 'You have successfully completed ticket '.$this->responseData['REQUEST_TICKET_NUMBER'], 'success' );
				
				// Refresh
				$this->retrieveTicket();
		}
		else
		{
			// Show pop-up of success
			$this->popup->addTomessagePopUp( 'OK' , 'Completion already set' , 'You can not adjust the completion time once its been saved', 'error' );
		}
	}
	
	
	private function updateISOCTech()
	{
		
		// get row of matching
		$techIDRowTemp = array();
		$techIDRowTemp = $this->FromDB->getOneRowWhereEquals( 'TB_ISOC_TECHS', 'ISOC_TECH_EMPLOYEE_ID', $_SESSION['ISOC_TECH_EMPLOYEE_ID'] );
		

		
		if ($this->responseData['REQUEST_COMPLETION_DATETIME'] == '' )
		{
			// save to database
			$updateTemp = array("ISOC_TECH_ID_ASSIGNED" => $_SESSION['ISOC_TECH_EMPLOYEE_ID'] );
			$whereArray = array("REQUEST_TICKET_NUMBER"=> $this->responseData['REQUEST_TICKET_NUMBER'] );
					
			$this->ToDB->updateRecordOneTable( $updateTemp , $whereArray, 'equals' , 'TB_SUPPORT_FORM_METADATA' , $fieldTypes = 'si');
			
			// Show pop-up of success
			$this->popup->addTomessagePopUp( 'OK' , 'Ownership Changed!' , 'You have successfully taken ownership of ticket '.$this->responseData['REQUEST_TICKET_NUMBER'], 'success' );
			
		}
		else
		{
			$this->popup->addTomessagePopUp( 'OK' , 'Failed Ownership Change' , 'The ownership did not change please ensure the ticket is not complete.', 'error' );
			
		}
		
		$this->retrieveTicket();
	}
	
	private function createRequestOverview()
	{
		
		
		$message = '
					<b>Perform:</b>      '.$this->responseData['REQUEST_URGENCY'].'<br /> 
					<b>Environment:</b>  '.$this->responseData['ENVIRONMENT_OPTIONS_VALUE'].'<br />
					<b> Option:</b>       '.$this->responseData['REQUEST_TYPE_OPTIONS_VALUE'].' -> '.$this->responseData['MAIN_OPTIONS_VALUE'].'<br />
					<b>Request Type:</b> '.$this->responseData['PROCESS_DETAILS_DATA'].'<br />
					<b>Details:</b>      '.$this->responseData['ADDITIONAL_OPTIONS_VALUE'].'<br />
					<br />'.$this->responseData['REQUEST_DETAILS_DATA'].'<br />
					';
					
		return $message;
		
		
		
	}
	
	
	
	//*************************************  JavaScript Variables *****************************************************************
	
	
	// Creates all JavaScript variables for form by converting PHP arrays to JavaScript Arrays.
	public function createJavaScriptVariables()
	{
		echo "var MAIN_OPTIONS = " . json_encode($this->FromDB->getMainOptions() ) . ";" ;
		echo "var JOB_REQUEST_TYPE_OPTIONS = " . json_encode($this->FromDB->getJobRequestOptions() ) . ";" ;
		echo "var OTHER_REQUEST_TYPE_OPTIONS = " . json_encode($this->FromDB->getOtherRequestOptions() ) . ";" ;
		echo "var STREAM_REQUEST_TYPE_OPTIONS = " . json_encode($this->FromDB->getStreamRequestOptions() ) . ";" ;
		echo "var FILE_REQUEST_TYPE_OPTIONS = " . json_encode($this->FromDB->getFileRequestOptions() ) . ";" ;

		echo "var JOB_ENVIRONMENT = " . json_encode($this->FromDB->getJobEnvironmentOptions() ) . ";" ;
		echo "var STREAM_ENVIRONMENT = " . json_encode($this->FromDB->getStreamEnvironmentOptions() ) . ";" ;
		echo "var FILE_ENVIRONMENT = " . json_encode($this->FromDB->getFileEnvironmentOptions() ) . ";" ;
		echo "var OTHER_ENVIRONMENT = " . json_encode($this->FromDB->getOtherEnvironmentOptions() ) . ";" ;

		
		echo "var SUBMIT_PREDEFINED_SELECTION  = " . json_encode($this->FromDB->getSubmitPredefined() ) . ";" ;
		echo "var RELEASE_SELECTION = " . json_encode($this->FromDB->getRelease() ) . ";" ;
		echo "var RERUN_SELECTION = " . json_encode($this->FromDB->getRerun() ) . ";" ;
		echo "var HOLD_SELECTION = " . json_encode($this->FromDB->getHold() ) . ";" ;
		echo "var UNHOLD_SELECTION = " . json_encode($this->FromDB->getUnhold() ) . ";" ;
		echo "var BYPASS_SELECTION = " . json_encode($this->FromDB->getRestoreFile() ) . ";" ;
		echo "var IGNORE_SELECTION = " . json_encode($this->FromDB->getIgnoreAlert() ) . ";" ;
		echo "var RESUBMIT_SELECTION = " . json_encode($this->FromDB->getResubmit() ) . ";" ;
		echo "var CANCEL_SELECTION = " . json_encode($this->FromDB->getCancel() ) . ";" ;
		echo "var INFORMATION_SELECTION = " . json_encode($this->FromDB->getInformation() ) . ";" ;
		echo "var FILE_TRANSFER_STATUS_SELECTION = " . json_encode($this->FromDB->getFileTransferStatus() ) . ";" ;
		echo "var RESTORE_SELECTION = " . json_encode($this->FromDB->getRestoreFile() ) . ";" ;
		echo "var OPEN_TICKET_SELECTION = " . json_encode($this->FromDB->getOpenTicket() ) . ";" ;
		echo "var KILL_SELECTION = " . json_encode($this->FromDB->getKill() ) . ";" ;
	}






















}
?>