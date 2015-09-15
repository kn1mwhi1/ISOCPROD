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
		 $this->validation = new ValidationUserInput();
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
		
		$sql = "SELECT * FROM TB_ISOC_TECHS WHERE ISOC_TECH_EMPLOYEE_ID = $username OR ISOC_TECH_EMAIL = $username AND ISOC_TECH_PASSWORD = $password";
		$temp = $this->FromDB->multiFieldChangeToArrayAssociative( $sql );
		
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
			}
			else
			{
				echo "Did not pass validation";
				
			}
		}
	}
	


	
	
	
	
	
	
	
}
?>