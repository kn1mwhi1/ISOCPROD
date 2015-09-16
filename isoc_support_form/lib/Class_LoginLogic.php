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
			// Starte a new session
			$this->startSession($temp);
			
			// update last login time in database
			$this->updateLastLogin();
			
			print_r($_SESSION);
			
			header("location: ".$_SESSION['actual_link'] );
			
		}
		else
		{
			echo "incorrect login";
		}
	}
	private function startSession( $anArray )
	{
		if ( $this->is_session_started() === FALSE ) 
		{
			print_r($_SESSION);
			echo "Trying to start session 2";
			session_start;
			$_SESSION = $anArray; // Initializing Session
			
			
		}
		else
		{
			$tempArray = $_SESSION;
			$_SESSION = array_merge( $tempArray, $anArray); // Initializing Session
			echo "We came here";
		}
	}
	
	public function checkSession ()
	{		

		if ( $this->is_session_started() === FALSE ) 
		{
			session_start();
		}
		
		// get current link
		$_SESSION['actual_link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
		
		if ($_SESSION['ISOC_TECH_EMPLOYEE_ID'] == '')
		{
			//header("location: login.php");
			print_r($_SESSION);
		}
		
	}
	
	// Univeral funciton to find if the session has started.
	private function is_session_started()
	{
		if ( php_sapi_name() !== 'cli' ) {
			if ( version_compare(phpversion(), '5.4.0', '>=') ) {
				return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
			} else {
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		return FALSE;
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
	public function checkLoginInfo()
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