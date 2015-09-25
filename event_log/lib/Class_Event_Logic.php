<?php 
require_once 'Class_DB_In.php';
require_once 'Class_DB_Out.php';
require_once 'Class_ValidationUserInput.php';
require_once 'Class_ISOC_EMAIL.php';
require_once 'Class_ErrorPopup.php';

class Event_Logic extends ValidationUserInput
{
	private $FromDB;
	private $ToDB;
	private $email;
	private $validation;
	private $messagePopup;
	
	// Constructor
	function Event_Logic()
	{
		$this->instantiateVariables();
	}
	// Instantiate Variables used in this class
	private function instantiateVariables()
	{
		 // Database communication variables
		 $this->FromDB = new DB_Out();
		 $this->ToDB = new DB_In();
		 $this->email = new ISOC_EMAIL();		
		 $this->validation = new ValidationUserInput();
		 $this->messagePopup = new ErrorPopup();
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
	
	
	// place at the bottom of all php/html pages
	public function notifyMessage()
	{
        $this->messagePopup->notifyMessage();
	}
	//************************************************  EVENT Functions ********************************************************
	// Retrieve all rows from event DB Table
	private function getAllEventsFromDB()
	{
		$temp = array();
		$sql = "SELECT * FROM TB_ISOC_EVENT";
		$temp = $this->FromDB->multiRowAndFieldChangeToArrayAssociative( $sql );	
		
		return $temp;
	}
	
	// create and format table output.
	public function createTable ()
	{
		$getArray = array();
		$keyNames = array();
		$values = array();
		
		// Seperate Arrays in order to get keys and values easier
		$getArray = &$this->getAllEventsFromDB();
		$keyNames = &$getArray['KEYS'];
		$values = &$getArray['VALUES'];
		
		$tableStartDeclaration = '
							<table id="table"
							   data-toggle="table"
							   data-height="460"
							   data-search="true"
							   >';
							   
		$tableEndDeclaration = '</table>';
							   
		echo $this->createCssScripts().$tableStartDeclaration.$this->createTableHead( $keyNames ).$this->createTbodyTrowTdata($values, count($keyNames) ).$tableEndDeclaration;
		
		//echo $this->get12Hours();
		//echo $this->getCurrentTime();
	}
	
	private function createCssScripts()
	{
		$cssAndScripts = '	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
							<link rel="stylesheet" href="css/bootstrap.min.css">
							<link rel="stylesheet" href="css/bootstrap-table.css">
							<script src="script/jquery.js"></script>
							<script src="script/bootstrap.min.js"></script>
							<script src="script/bootstrap-table.js"></script>';
							
		return $cssAndScripts;
		
	}
	
	// create The <thead> and <tr> that represent the columns of a table
	private function createTableHead( &$anArray )
	{
		// start the thead and tr
		$thFields ='<thead><tr>';
		
		// Create the th data rows
		for ($x=0;$x < count($anArray); $x++)
		{
			$thFields = $thFields.'<th data-field="'.$anArray[$x].'" data-sortable="true">'.$anArray[$x].'</th>';
		}
		
		// end the thead and tr
		$thFields = $thFields.'</tr></thead>';
		
		// return the TableHead declaration
		return $thFields;
	}
	
	private function createTbodyTrowTdata( &$anArray , $numberOfFields)
	{
		$id = '';
		$tbodyStart = '<tbody>';
		$tbodyEnd = '</tbody>';
		$allData = $tbodyStart;
		$countFields =0;
		
		
		for($x=0;$x < count($anArray);$x++)
		{
			if ($countFields == 0)
			{
				$allData = $allData.'<tr>';
				$id = $anArray[$x];
			}
			
			// create table data
			$allData = $allData.'<td id="'.$id.'" data-value="'.$anArray[$x].'">'.$anArray[$x].'</td>';
			
			// accumalator
			$countFields = $countFields + 1;
			if ($countFields == $numberOfFields)
			{
				$countFields = 0;
				$allData = $allData.'</tr>';
			}
		}
		
		// Add the end tbody statement
		$allData = $allData.$tbodyEnd;
		
		return $allData;
	}
	
	private function removeUnderscores()
	{
		
		
	}
	
	private function getCurrentTime()
	{
		$dateNow = date('m/d/Y h:i:s a', time());
		$date = new DateTime($dateNow);
		
		return $date->format("Y-m-d H:i:s");
	}
	
	private function get12Hours()
	{
	    $dateNow = date('m/d/Y h:i:s a', time());
		$date = new DateTime($dateNow);
		$date->modify("+12 hours");
		
		return $date->format("Y-m-d H:i:s");
	}
	
}
?>