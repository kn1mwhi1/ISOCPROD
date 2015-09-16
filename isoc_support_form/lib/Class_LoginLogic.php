<?php 
require_once 'Class_LoginDB_In.php';
require_once 'Class_LoginDB_Out.php';
require_once 'Class_ValidationUserInput.php';
require_once 'Class_ISOC_EMAIL.php';

class LoginLogic extends ValidationUserInput
{
	private $FromDB;
	private $ToDB;
	private $email;
	private $validation;
	private $targetLink;

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
		 $this->setTagertLink( '' );
	}
	
	private function setTagertLink( $aLink )
	{
		$this->targetLink = $aLink;
	}
	
	private function getTagetLink()
	{
		return $this->targetLink;
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
				echo "The Value is:  ".$value;
				return false;
			}
		}
		// all items have passed validation
		return true;
	}
	
	private function callValidationMethodsRegisterForm()
	{
		$temp = array();
		
		$temp[] = $this->validation->validateInformation( '' , 'ALL');
		$temp[] = $this->validation->validateInformation( '' , 'ALL');
		
		foreach ($temp as $value)
		{
			if ($value === false)
			{
				echo "The Value is:  ".$value;
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
		$password = $_POST['password'];
		
		$sql = "SELECT * FROM TB_ISOC_TECHS WHERE ISOC_TECH_EMPLOYEE_ID = '".$username."' OR ISOC_TECH_EMAIL = '".$username."' AND ISOC_TECH_PASSWORD = '".$password."'";
		$temp = $this->FromDB->multiFieldChangeToArrayAssociative( $sql );		
		
	
		if ($temp['ISOC_TECH_PASSWORD'] === $password )
		{
			// Start a new session
			$this->startSession($temp);
			
			// update last login time in database
			$this->updateLastLogin();
			
			
			
			$url = $_SESSION['actual_link'];
			
		session_write_close();
			echo"
		<script>
				window.location = '".$url."';
		</script>
";

			exit();
			
		}
		else
		{
			echo "incorrect login";
		}
	}
	private function setSessionTime( $timeSeconds = 43200)
	{
		$timeSeconds = 43200;
		
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
		session_start();
		
		// Set the session time to 12 hours
		//$this->setSessionTime();
		
		// Check if user has logged in yet.
		if (empty($_SESSION['ISOC_TECH_EMPLOYEE_ID']) ) 
		{
			//print_r($_SESSION);
			echo "Starting Session";

			
			$_SESSION = array_merge($anArray, $_SESSION); // Initializing Session
			
		}
		else  // User is already logged in.
		{
			//$tempArray = $_SESSION;
			//$_SESSION = array_merge( $anArray, $_SESSION); // Initializing Session
			echo "Already logged in <br />";
		}
	}
	
	public function checkSession ()
	{		
         // must be on all pages
		 session_start();	
		 
		if ( empty($_SESSION['ISOC_TECH_EMPLOYEE_ID']) )
		{
			
			$_SESSION['actual_link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			echo "Is empty";
			session_write_close();
			header("location: login.php");
			
			exit();
		}
		
	}
	
	
	private function updateLastLogin()
	{
		$date = date("Y-m-d H:i:s");
		$aSession = $_SESSION['ISOC_TECH_EMPLOYEE_ID'] ;
		$updateArray = array("ISOC_TECH_LAST_LOGIN"=>"$date");
		$whereArray = array("ISOC_TECH_EMPLOYEE_ID"=>"$aSession");
		
		// Update the last login time
		$this->ToDB->updateRecordOneTable( $updateArray , $whereArray, 'equals', 'TB_ISOC_TECHS' , 'ss');
	}
	
	
//Used to check information after user has "posted" the data from a from
	public function checkPOSTLoginInfo()
	{
	    // Checks to see if user has posted before checking any validation
		if ($_SERVER["REQUEST_METHOD"] == "POST") 
		{
			if ( $this->callValidationMethodsLoginForm() )
			{
				// check if login was successful
				$this->checkLoginPassword();
			}
			else
			{
				echo "Did not pass validation";
				
			}
		}
	}
	


	
	
	
	
	
	
	
}
?>