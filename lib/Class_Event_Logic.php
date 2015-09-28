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
	// not sure if this will be needed
	public function addNotifyMessage( $CustomType, $title , $text, $type, $confirmButtonText, $customJavaFunction)
	{
        $this->messagePopup->addTomessagePopUp( $CustomType, $title , $text, $type, $confirmButtonText , $customJavaFunction);
	}
	
	// place at the bottom of all php/html pages
	public function notifyMessage()
	{
        $this->messagePopup->notifyMessage();
	}
	//************************************************  EVENT Functions ********************************************************
	
	public function checkEventPost()
	{
		if(isset($_POST['ID']) && is_numeric($_POST['ID']))
		{
			// Retreive Ticket Information.
			echo json_encode($this->getTicketInfo( $_POST['ID'] ));
		}
		else
		{
			if(isset($_POST['submit']))
			{
			
				switch ($_POST['submit']) 
				{
					case "Current Events":
								if ($_POST['view'] == 'Normal View')
								{
									$this->createTableActiveExpiredCustomFields();
								}
								
								if ($_POST['view'] == 'Detailed View')
								{
									$this->createTableActiveExpiredCustomFieldsDetailed();
								}
						break;
					case "All Events":
								if ($_POST['view'] == 'Normal View')
								{
									$this->createTableAll();
								}
								
								if ($_POST['view'] == 'Detailed View')
								{
									$this->createTableAllDetailed();
								}
						break;
					case "Completed Events":
								if ($_POST['view'] == 'Normal View')
								{
									$this->createTableCompleted();
								}
								
								if ($_POST['view'] == 'Detailed View')
								{
									$this->createTableCompletedDetailed();
								}
						break;
					case "Expired Events":
								if ($_POST['view'] == 'Normal View')
								{
									$this->createTableExpired();
								}
								
								if ($_POST['view'] == 'Detailed View')
								{
									$this->createTableExpiredDetailed();
								}
						break;
					case "Pending Events":
								if ($_POST['view'] == 'Normal View')
								{
									$this->createTablePending();
								}
								
								if ($_POST['view'] == 'Detailed View')
								{
									$this->createTablePendingDetailed();
								}
						break;
					case "CANCEL":  // Cancel the ticket
								$this->updateCancel($_POST['ticket']);
						break;
					default:
						$this->createTableActiveExpiredCustomFields();
				}
			}
		}	
	}
	
	private function updateCancel( $aTicketNumber )
	{
		$updateArray = array("STATUS"=>"CANCELED");
		$whereArray = array("EVENT_ID"=>$aTicketNumber);
		
		$this->ToDB->updateRecordOneTable( $updateArray , $whereArray, 'equals', 'TB_ISOC_EVENT' , 'si');
	}
	
	private function createTableAllDetailed()
	{
		
		$sql = 'SELECT * FROM TB_ISOC_EVENT';
		
		$this->createTable($sql);
	}
	
	
	private function createTableAll()
	{
		
		$sql = 'SELECT `EVENT_ID`, `START_DATETIME`, `END_DATETIME`, `ACTION_REQUIRED`, `INITIATOR`, `REFERENCE`, `STATUS` FROM TB_ISOC_EVENT';
		
		$this->createTable($sql);
	}
	
	private function createTablePendingDetailed()
	{
		
		$sql = 'SELECT * FROM TB_ISOC_EVENT WHERE `STATUS` = "PENDING" ORDER BY `START_DATETIME`';
		
		$this->createTable($sql);
	}
	
	
	private function createTablePending()
	{
		
		$sql = 'SELECT `EVENT_ID`, `START_DATETIME`, `END_DATETIME`, `ACTION_REQUIRED`, `INITIATOR`, `REFERENCE`, `STATUS` FROM TB_ISOC_EVENT WHERE `STATUS` = "PENDING"';
		
		$this->createTable($sql);
	}
	
	private function createTableCompletedDetailed()
	{
		
		$sql = 'SELECT * FROM TB_ISOC_EVENT WHERE `STATUS` = "COMPLETED"';
		
		$this->createTable($sql);
	}
	
	
	private function createTableCompleted()
	{
		
		$sql = 'SELECT `EVENT_ID`, `START_DATETIME`, `END_DATETIME`, `ACTION_REQUIRED`, `INITIATOR`, `REFERENCE`, `STATUS` FROM TB_ISOC_EVENT WHERE `STATUS` = "COMPLETED"';
		
		$this->createTable($sql);
	}
	
	private function createTableExpiredDetailed()
	{
		
		$sql = 'SELECT * FROM TB_ISOC_EVENT WHERE `STATUS` = "EXPIRED"';
		
		$this->createTable($sql);
	}
	
	
	private function createTableExpired()
	{
		
		$sql = 'SELECT `EVENT_ID`, `START_DATETIME`, `END_DATETIME`, `ACTION_REQUIRED`, `INITIATOR`, `REFERENCE`, `STATUS` FROM TB_ISOC_EVENT WHERE `STATUS` = "EXPIRED"';
		
		$this->createTable($sql);
	}
	
	
	private function createTableActiveExpiredCustomFields()
	{
		$twelveplus = $this->get12Hours();

		$sql = 'SELECT `EVENT_ID`, `START_DATETIME`, `END_DATETIME`, `ACTION_REQUIRED`, `INITIATOR`, `REFERENCE`, `STATUS` FROM TB_ISOC_EVENT WHERE (`START_DATETIME` < "'.$twelveplus.'"
				AND (`STATUS` = "ACTIVE" OR `STATUS` = "PENDING")) OR `STATUS` = "EXPIRED" ORDER BY `START_DATETIME` ASC';
		
		$this->createTable($sql);
	}
	
	private function createTableActiveExpiredCustomFieldsDetailed()
	{
		$twelveplus = $this->get12Hours();

		$sql = 'SELECT * FROM TB_ISOC_EVENT WHERE (`START_DATETIME` < "'.$twelveplus.'"
				AND (`STATUS` = "ACTIVE" OR `STATUS` = "PENDING")) OR `STATUS` = "EXPIRED" ORDER BY `START_DATETIME` ASC';
		
		$this->createTable($sql);
	}
	
	public function createTableALLFields()
	{
		$sql = "SELECT * FROM TB_ISOC_EVENT";
		$this->createTable($sql);
	}
	
	public function getTicketInfo( $ticketNumber )
	{
		$sql = 'SELECT * FROM TB_ISOC_EVENT WHERE EVENT_ID = "'.$ticketNumber.'"';
		
		$temp = array();
		$temp = $this->FromDB->multiFieldChangeToArrayAssociative( $sql );	
		return $temp;
	}
	
	
	private function changeDateFormat ( $valueArray )
	{
		// copy array values to new array
		$tempKeys = array();
		$tempKeys =  $valueArray;
		
		// clear the key array
		unset($valueArray);
		
		for ($x=0;$x<count($tempKeys);$x++)
		{
			if(preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/',$tempKeys[$x]))
			{
			   $tempKeys[$x] = date('m/d/Y H:i:s', strtotime($tempKeys[$x] ));
			}			
		}
		
		return $tempKeys;
	}
	
	
	
				//*********************************************** generic functions **************************************************************//
	// Retrieve all rows from event DB Table
	private function getFromDB( $sql )
	{
		$temp = array();
		$temp = $this->FromDB->multiRowAndFieldChangeToArrayAssociative( $sql );	
		return $temp;
	}
	
	
	// create and format table output.
	private function createTable ( $sqlStatement )
	{
		$getArray = array();
		$keyNames = array();
		$values = array();
		
		// Seperate Arrays in order to get keys and values easier
		$getArray = $this->getFromDB( $sqlStatement );
		$keyNames = $getArray['KEYS'];
		$values = $getArray['VALUES'];
		
		// clean key Names remove any underscores and personal formatting
		$keyNames = $this->cleanKeys( $keyNames );
		
		// Format Dates
		$values = $this->changeDateFormat( $values );
		
		$tableStartDeclaration = '
							<table id="table"
							   data-toggle="table"
							   data-toolbar="#toolbar"
							   data-show-toggle="true"
							   data-show-columns="true"
							   data-height="460"
							   data-search="true"
							   >';
							   
		$tableEndDeclaration = '</table>';
		
		// display dynamicaly created table using html tags
		echo $this->createCssScripts().$tableStartDeclaration.$this->createTableHead( $keyNames ).$this->createTbodyTrowTdata($values, count($keyNames) ).$tableEndDeclaration;
		//echo $this->get12Hours();
		//echo $this->getCurrentTime();
	}
	
	private function createCssScripts()
	{
		$cssAndScripts = '	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
						    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
							<link type="text/css" rel="stylesheet" href="css/bootstrap-table.css">
							<link rel="stylesheet" type="text/css" href="css/eventlog.css" />
						    <script type="text/javascript" src="script/jquery.js"></script>
							<script type="text/javascript" src="script/bootstrap-table.js"></script>';
							
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
		
		// Searches for the first element that contains the value EXPIRED
		$key = array_search('EXPIRED', $anArray);
		// uses modules to return the element number for each row
		$offset = ($key % $numberOfFields);


	
		for($x=0;$x < count($anArray);$x++)
		{
			// Adds the beginning of each row for the Table
			if ($countFields == 0)
			{
				// capture the Ticket ID
				$id = $anArray[$x];
				
				// Logic to mark entire row has the class danger if expire exists.
				if ($anArray[$x+$offset] == 'EXPIRED')
				{
					$allData = $allData.'<tr class="expired" >';
				}
				else
				{
					$allData = $allData.'<tr>';
				}
			}
			
			// Adds the Table Data.
			$allData = $allData.'<td class="clickMe" id="'.$id.'" data-value="'.$anArray[$x].'">'.$anArray[$x].'</td>';
			
			// Adds the end of the row tag
			// accumulator
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
	
	// Replace Underscores and..
	// Replace EVENT_ID with ID.
	private function cleanKeys( $keyArray )
	{
		// copy array values to new array
		$tempKeys = array();
		$tempKeys =  $keyArray;
		
		// clear the key array
		unset($keyArray);
		
		for ($x=0;$x<count($tempKeys);$x++)
		{
			// replace any underscores with a space	
			$tempKeys[$x] = str_replace('_', ' ', $tempKeys[$x]);
			
			// replace EVENT ID with ID
			$tempKeys[$x] = str_replace('EVENT ID', 'ID', $tempKeys[$x]);
		}
		
		return $tempKeys;
	}
	
	private function getCurrentTime()
	{
		$date = date('Y-m-d H:i:s', time());
	;
		
		return $date;
	}
	
	private function get12Hours()
	{
	    $dateNow = date('Y-m-d H:i:s', time());
		$date = new DateTime($dateNow);
		$date->modify("+12 hours");
		$date = $date->format("Y-m-d H:i:s");
		$date = date('Y-m-d H:i:s', strtotime($date ));
		// convert datetime to date object
		
		
		return $date;
	}
	
}
?>