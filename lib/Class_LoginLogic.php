<?php 
require_once 'Class_LoginDB_In.php';
require_once 'Class_LoginDB_Out.php';
require_once 'Class_ValidationUserInput.php';
require_once 'Class_ISOC_EMAIL.php';
require_once 'Class_ErrorPopup.php';

class LoginLogic extends ValidationUserInput
{
	private $FromDB;
	private $ToDB;
	private $email;
	private $validation;
	private $messagePopup;
	//private $targetLink;

	// Constructor
	function LoginLogic()
	{
		$this->instantiateVariables();
	}
	// Instantiate Variables used in this class
	private function instantiateVariables()
	{
		 // Database communication variables
		 $this->FromDB = new LoginDB_Out();
		 $this->ToDB = new LoginDB_In();
		 $this->email = new ISOC_EMAIL();		
		 $this->validation = new ValidationUserInput();
		 $this->messagePopup = new ErrorPopup();
		// $this->setTagertLink( '' );
	}


	public function getError( $nameOfObject )
	{
		$this->validation->input_error( $nameOfObject );
	}
	
	
	
	// custom methods determined by fields on form
	private function callValidationMethodsLoginForm()
	{
		$temp = array();
		
		$temp[] = $this->validation->validateInformation( 'username' , 'ALL');
		$temp[] = $this->validation->validateInformation( 'password' , 'ALL');
		
		foreach ($temp as $value)
		{
			if ($value === false)
			{
				//echo "The Value is:  ".$value;
				return false;
			}
		}
		// all items have passed validation
		return true;
	}
	

	
	private function checkLoginPassword()
	{
		$temp = array();
		
		$username = $_POST['username'];
		$password = hash('sha256', $_POST['password']);
		
		$sql = "SELECT * FROM TB_ISOC_TECHS WHERE ISOC_TECH_EMPLOYEE_ID = '".$username."' OR ISOC_TECH_EMAIL = '".$username."' AND ISOC_TECH_PASSWORD = '".$password."'";
		//$sql = "UPDATE TB_ISOC_TECHS SET `ISOC_TECH_PASSWORD` = '".$password."' WHERE ISOC_TECH_EMPLOYEE_ID = '".$username."'" ;
		$temp = $this->FromDB->multiFieldChangeToArrayAssociative( $sql );		
		//echo $temp['ISOC_TECH_PASSWORD'];
		
	
		if ($temp['ISOC_TECH_PASSWORD'] === $password )
		{
			// Start a new session
			$this->startSession($temp);
			
			// update last login time in database
			$this->updateLastLogin();
			
			
			if (isset($_SESSION['actual_link']) )
			{
				$url = $_SESSION['actual_link'];
			}
			else
			{
				$url = 'dashboard.php';
			}
			
			
			echo "You have successfully logged in.";
			
		session_write_close();
			
			// Javascript Redirct
			echo"
		<script>
				window.location = '".$url."';
		</script>";

			exit();
			
		}
		else
		{
			echo "incorrect login";
		}
	}
	
	private function callValidationMethodsRegisterForm()
	{
		$temp = array();
		
		$temp[] = $this->validation->validateInformation( 'email' , 'ALL');
		$temp[] = $this->validation->validateInformation( 'id' , 'ALL');
		$temp[] = $this->validation->validateInformation( 'firstname' , 'LETTER');
		$temp[] = $this->validation->validateInformation( 'lastname' , 'LETTER');
		$temp[] = $this->validation->validateInformation( 'passwd' , 'ALL');
		$temp[] = $this->validation->validateInformation( 'secretWord' , 'ALL');
		
		
		foreach ($temp as $value)
		{
			if ($value === false)
			{
				//echo "The Value is:  ".$value;
				return false;
			}
		}
		// all items have passed validation
		return true;
	}
	// Register new login.
	private function checkLoginPasswordRegister()
	{
		$email = $_POST['email'];
		$id = $_POST['id'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$passwd = $_POST['passwd'];
		$secretWord = $_POST['secretWord'];
		$dateTimeNow = date('Y-m-d H:i:s');
		$anArray = array("ISOC_TECH_EMPLOYEE_ID"=>"$id", "ISOC_TECH_PASSWORD"=>hash('sha256', $_POST['passwd']), "ISOC_TECH_FIRST_NAME"=>"$firstname", "ISOC_TECH_LAST_NAME"=>"$lastname",
						 "ISOC_TECH_EMAIL"=>"$email", "ISOC_TECH_SECRET_WORD"=>"$secretWord", "ISOC_TECH_LAST_LOGIN"=>"$dateTimeNow");
		
		
		$sql = "SELECT * FROM TB_ISOC_TECHS WHERE ISOC_TECH_EMPLOYEE_ID = '".$id."' OR ISOC_TECH_EMAIL = '".$email."' AND ISOC_TECH_PASSWORD = '".hash('sha256', $_POST['passwd'])."'";
		$temp = $this->FromDB->multiFieldChangeToArrayAssociative( $sql );		
		
	//   && !isset($_SESSION['ISOC_TECH_EMPLOYEE_ID'])
		if ($temp['ISOC_TECH_EMAIL'] != $email ||  $temp['ISOC_TECH_EMPLOYEE_ID'] != $id )
		{
			// Insert New User
			$this->ToDB->insertRecordOneTable( $anArray ,'TB_ISOC_TECHS', 'issssss' );
			$lastTransactionID = $this->ToDB->getLastTransactionID();
			$sql = "SELECT * FROM TB_ISOC_TECHS WHERE ISOC_TECH_EMPLOYEE_ID = '".$id."' OR ISOC_TECH_EMAIL = '".$email."' AND ISOC_TECH_PASSWORD = '".hash('sha256', $_POST['passwd'])."'";
			$temp = $this->FromDB->multiFieldChangeToArrayAssociative( $sql );		
			
			
				if ($temp['ISOC_TECH_EMAIL'] == $email ||  $temp['ISOC_TECH_EMPLOYEE_ID'] == $id )
				{
					// show pop-up registration complete.
					$this->messagePopup->addTomessagePopUp( 'OK', 'Registration Complete!', $firstname.', you have successfully registered! A confirmation email has been sent to you.' , 'success' );
					

				}
				else
				{
					$this->messagePopup->addTomessagePopUp( 'OK', 'Failed to register!', 'Issue with Database' , 'error' );	
				}
		}
		else
		{
			//echo "Failed to register! Id already exists";
			$this->messagePopup->addTomessagePopUp( 'OK', 'Failed to register!', 'Id or Email already exists, please try again!' , 'error' );	

		}
	}
	
	private function createRequesterEmailBody()
	{	
		$message = 'Below is a summary of your account information.<br />
					<br />
					<b><u>ID: '.$_SESSION['ISOC_TECH_EMPLOYEE_ID'].'</u></b><br />
					<b>Email:</b>      '.$_SESSION['ISOC_TECH_EMAIL'].'<br /> 
					<b>Secret Word:</b>  '.$_SESSION['ISOC_TECH_SECRET_WORD'].'<br />
					<b>First Name:</b>       '.$_SESSION['ISOC_TECH_FIRST_NAME'].'<br />
					<b>Last Name:</b> '.$_SESSION['ISOC_TECH_LAST_NAME'].'<br />
					<b>Password:</b>      '.$_SESSION['ISOC_TECH_PASSWORD'].'<br />
					<br />
					<br />
					<br />
					<br />
					Thanks for using the ISOC login form,<br />
					IS Operations
					
					
					
					';
					
		return $message;
	}
	
	private function requesterEmailSend()
	{
		// create email message
		$message = '
			
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ISOC Request Conformation Email</title>

		</head>

		<body bgcolor="#f2eded">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f2eded">
		  <tr>
			<td><table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
				<tr>
				  <td valign="middle">
				  
				  <div style="text-align: center;font-family: Helvetica; font-variant: small-caps; color: #FFFFFF;  background: #66C285;">ISOC Registration Confirmation Email</div>
					
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
						<td width="80%" align="left" valign="top"><font style="font-family: Georgia, "Times New Roman", Times, serif; color:#010101; font-size:24px"><strong><em>Hi '.$_SESSION['ISOC_TECH_FIRST_NAME'].',</em></strong></font><br /><br />
						  <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">
						  
						  '.$this->createRequesterEmailBody().'
							<br />
							<br />
							<a href="http://10.176.105.18/isoc_support_form/login.php">ISOC Dashboard</a>
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
			$toEmail = $_SESSION['ISOC_TECH_EMAIL'];
			
			$this->email->setTo( $toEmail );
			
			$this->email->setFrom( 'ISOperationsCenter@uscellular.com');
			
			// set the subject field of email
			$this->email->setSubject( 'New Registration Confirmation' );
			
			// prepare headers which informs the mail client that this will be html and the from and to
			$this->email->setHeadersNoCC();
			
			// send email
			$this->email->sendEmail();
	}
	
	
		private function forgotPasswordEmailSend()
	{
		// create email message
		$message = '
			
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ISOC Request Conformation Email</title>

		</head>

		<body bgcolor="#f2eded">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f2eded">
		  <tr>
			<td><table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
				<tr>
				  <td valign="middle">
				  
				  <div style="text-align: center;font-family: Helvetica; font-variant: small-caps; color: #FFFFFF;  background: #66C285;">ISOC Forgot Password Reminder </div>
					
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
						<td width="80%" align="left" valign="top"><font style="font-family: Georgia, "Times New Roman", Times, serif; color:#010101; font-size:24px"><strong><em>Hi '.$_SESSION['ISOC_TECH_FIRST_NAME'].',</em></strong></font><br /><br />
						  <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">
						  
						  '.$this->createRequesterEmailBody().'
							<br />
							<br />
							<a href="http://10.176.105.18/isoc_support_form/login.php">ISOC Dashboard</a>
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
			$toEmail = $_SESSION['ISOC_TECH_EMAIL'];
			
			$this->email->setTo( $toEmail );
			
			$this->email->setFrom( 'ISOperationsCenter@uscellular.com');
			
			// set the subject field of email
			$this->email->setSubject( 'Forgot Password Reminder - ISOC Login Form' );
			
			// prepare headers which informs the mail client that this will be html and the from and to
			$this->email->setHeadersNoCC();
			
			// send email
			$this->email->sendEmail();
	}
	
	// In seconds default 12 hours
	private function setSessionTime( $timeSeconds = 43200)
	{
		
		if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeSeconds)) 
		{
			
			session_unset();     // unset $_SESSION variable for the run-time 
			session_destroy();   // destroy session data in storage
			echo "Session destroyed";
		}
	
		$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
	}
	
	
	private function startSession( $anArray )
	{
	   if (!isset($_SESSION['ISOC_TECH_EMPLOYEE_ID']))
	   {
			session_start();
	   }
		
		  /*   <-- !! not sure why the comment code does'nt work.
		 if(!isset($_SESSION)) 
		 {
			session_start();
		 }
		 */
		

		
		// Set the session time to 12 hours
		$this->setSessionTime();
		
		// Check if user has logged in yet.
		if (empty($_SESSION['ISOC_TECH_EMPLOYEE_ID']) ) 
		{

			$_SESSION = array_merge($anArray, $_SESSION); // Initializing Session			
		}
		else // if session is not empty like user already logged in as another user.
		{
		   $_SESSION = array_merge($_SESSION, $anArray); // Initializing Session
		}
	}

	// Track last login into database
	private function updateLastLogin()
	{
		$date = date("Y-m-d H:i:s");
		$aSession = $_SESSION['ISOC_TECH_EMPLOYEE_ID'] ;
		$updateArray = array("ISOC_TECH_LAST_LOGIN"=>"$date");
		$whereArray = array("ISOC_TECH_EMPLOYEE_ID"=>"$aSession");
		
		// Update the last login time
		$this->ToDB->updateRecordOneTable( $updateArray , $whereArray, 'equals', 'TB_ISOC_TECHS' , 'ss');
	}
	
	// Edit Account Information Post Function
	public function checkPost()
	{
		if(isset($_POST['submit']))
		{
			
			switch ($_POST['submit']) 
			{
				case "Load Page":   
							echo json_encode( $this->loadAccountInformation() );
					break;
				case "Update Account Info": 
								
							$_POST['DATE_TIME'] = $this->convertJavaTimeToPHPTime($_POST['DATE_TIME'] );
							$this->updateCall($_POST['TICKET_NUMBER'], $_POST['DATE_TIME'], $_POST['METHOD'], $_POST['PERSON_CONTACTED'], $_POST['NOTES'], $_POST['TICKET']);
							
					break;
				case "VALIDATION":  // Validation
							// convert post variables to be compatible with validation class
							$_POST[$_POST['OBJECT_NAME']] = $_POST['VALUE'];
							$this->validateHtmlInput( $_POST['OBJECT_NAME'],$_POST['TYPE'] );
					break;
				default:
					//$this->createTableActiveExpiredCustomFields();
			}
		}
	}
	
	
	private function loadAccountInformation()
	{
		$userLoginID = $_SESSION['ISOC_TECH_EMPLOYEE_ID'];
		//$sql = 'SELECT * FROM TB_ISOC_TECHS WHERE ISOC_TECH_EMPLOYEE_ID = "'.$userLoginID.'"';
		$sql = 'SELECT * FROM TB_ISOC_TECHS WHERE ISOC_TECH_EMPLOYEE_ID = "53741"';
		$temp = array();
		$temp = $this->FromDB->multiFieldChangeToArrayAssociative( $sql );	
		return $temp;
	}
	
	
	
	
	
	
	
//Used to check information after user has "posted" the data from a from
// Used by the login form only.
	public function checkPOSTLoginInfo()
	{
	   // Checks to see if user has posted before checking any validation
		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) ) 
		{
			if ($this->callValidationMethodsLoginForm() )
			{
				// check if login was successful
				$this->checkLoginPassword();
			}
			else
			{
				$this->messagePopup->addTomessagePopUp( 'OK', 'Validation Failed!', 'Please try again!' , 'error' );
				
			}
		}
		
		$this->forgetPasswordClick();		 
	}
	
	private function forgetPasswordClick()
	{
		// Send email to user when they press forgot link
		if (isset($_GET['forget']) && isset($_SESSION['ISOC_TECH_EMPLOYEE_ID'])) 
		{		
			$this->forgotPasswordEmailSend();			
			$this->messagePopup->addTomessagePopUp( 'OK', 'E-mail Sent!', 'An email has been sent containing your password.' , 'success' );
		}
		
		// Tell user to login before forgot email can be sent.
		if (isset($_GET['forget']) && !isset($_SESSION['ISOC_TECH_EMPLOYEE_ID'])) 
		{
			print_r($_GET);
		}
		
		if (isset($_GET['logout']) && isset($_SESSION['ISOC_TECH_EMPLOYEE_ID'])) 
		{
			$this->logout();
		}
		
			if (isset($_GET['logout']) && !isset($_SESSION['ISOC_TECH_EMPLOYEE_ID'])) 
		{
			$this->messagePopup->addTomessagePopUp( 'OK', 'Not logged in!', 'You must be logged in order to be logged out.' , 'info' );
		}
		
	}
	
	public function checkPOSTRegisterInfo()
	{
         // must be on all pages
		 if(!isset($_SESSION)) 
		 {
			session_start();
		 }
		
		// Checks to see if user has posted before checking any validation
		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) )
		{
			if ( $this->callValidationMethodsRegisterForm() )
			{
				// check if login was successful
				$this->checkLoginPasswordRegister();
			}
			else
			{
				$this->messagePopup->addTomessagePopUp( 'OK', 'Validation Failed!', 'Please try again!' , 'error' );	
			}
		}
	}

	// Should be called on all websites that require login, besides login.php and register.php
	public function checkSession()
	{		
         // must be on all pages
		 if(!isset($_SESSION)) 
		 {
			session_start();
		 }
		 
		if ( empty($_SESSION['ISOC_TECH_EMPLOYEE_ID']) )
		{
			
			$_SESSION['actual_link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			session_write_close();
			
			$current = "$_SERVER[REQUEST_URI]";

			
			// If on register.php or login.php don't redirect, otherwise redirect
			if (!preg_match( '~.*login.php~i' , $current ) )
			{				
					/*if (!preg_match( '~.*register.php~i' , $current ) )
						{	
							header("location: login.php");
							//echo "trying to redirect";				
							exit();
						}
						*/
						
						header("location: login.php");
						//echo "trying to redirect";				
						exit();
						
						
			}
		}
		else
		{
			//echo " you are logged in";
			//$this->messagePopup->addTomessagePopUp( 'OK', 'Logged In', $_SESSION['ISOC_TECH_FIRST_NAME'].', you are logged in!' , 'info' );
		}
	}	
	
	
	
		// Should be only on login.php and register.php
	public function checkSessionLogin()
	{		
         // must be on all pages
		 if(!isset($_SESSION)) 
		 {
			session_start();
		 }
		 
		if ( empty($_SESSION['ISOC_TECH_EMPLOYEE_ID']) )
		{
			
			//$_SESSION['actual_link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			session_write_close();
			
			$current = "$_SERVER[REQUEST_URI]";

			
			// If on register.php or login.php don't redirect, otherwise redirect
			if (!preg_match( '~.*login.php~i' , $current ) )
			{				
					if (!preg_match( '~.*register.php~i' , $current ) )
						{	
							if (!preg_match('~.*changepassword.php~i' , $current ))
							{
									if (!preg_match('~.*forgot.php~i' , $current ))
									{
										header("location: login.php");
										//echo "trying to redirect";				
										exit();
									}
							}
						}
			}
		}
		
		/*
		else
		{
			//echo " you are logged in";
			$this->messagePopup->addTomessagePopUp( 'OK', 'Logged In', $_SESSION['ISOC_TECH_FIRST_NAME'].', you are logged in!' , 'info' );
		}
		
		*/
	}	
	
	// place at the bottom of all php/html pages
	public function notifyMessage()
	{
        $this->messagePopup->notifyMessage();
	}
	private function logout()
	{
		  // must be on all pages
		 if(!isset($_SESSION)) 
		 {
			session_start();
		 }
		 
		 unset($_SESSION);

		 
		session_destroy();
		//$this->messagePopup->addTomessagePopUp( 'OK', 'Logged Out', 'You are logged Out!' , 'info' );
		
	// redirect to just login page
		header("location: login.php");

	}
	
	public function getNavBar()
	{
		include 'lib/navbar.php';
	}
	
	public function loggedInAs()
	{
		if (isset($_SESSION['ISOC_TECH_FIRST_NAME']))
		{
			echo '<li><a href="login.php" tabindex="-1">Login Page</a></li>
				  <li class="active"><a href="account.php" tabindex="-1"><u>Logged in as: '.$_SESSION['ISOC_TECH_FIRST_NAME'].' '.$_SESSION['ISOC_TECH_LAST_NAME'].' (account)</u></a></li>
				  <li class=""><a href="login.php?logout=true" tabindex="-1">Logout</a></li>';
		}
	}
	
	
}
?>