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
		 parent::ValidationUserInput();
	}
	

	
	
//Used to check information after user has "posted" the data from a from
	public function checkLoginInfo()
	{
	    // Checks to see if user has posted before checking any validation
		if ($_SERVER["REQUEST_METHOD"] == "POST") 
		{
			
			
			if ( parent::validateInformation( 'username' , 'text'))
			{
				
				echo "Passed Validation do something cool";
			
				
			}
		}
	}
	
	

	
	
	
	
	
	
	
}
?>