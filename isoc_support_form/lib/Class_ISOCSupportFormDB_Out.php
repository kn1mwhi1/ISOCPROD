<?php 
require_once 'Class_BaseDataBase.php';

class ISOCSupportFormDB_Out extends BaseDataBase{

	//  Main Options Drop Down
	private $query_MAIN_OPTIONS = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='MAIN' ORDER BY PRIORITY ASC";
	
	// Request Type Drop Down Queries
	private $query_JOB_REQUEST_TYPE_OPTIONS = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='REQUEST_TYPE' AND SECONDARY_SELECTION='Job' ORDER BY PRIORITY ASC";
	private $query_OTHER_REQUEST_TYPE_OPTIONS = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='REQUEST_TYPE' AND SECONDARY_SELECTION='Other' ORDER BY PRIORITY ASC";
	private $query_STREAM_REQUEST_TYPE_OPTIONS = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='REQUEST_TYPE' AND SECONDARY_SELECTION='Stream' ORDER BY PRIORITY ASC";
	private $query_FILE_REQUEST_TYPE_OPTIONS = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='REQUEST_TYPE' AND SECONDARY_SELECTION='File' ORDER BY PRIORITY ASC";
	
	// Environment Drop Down Queries
	private $query_JOB_ENVIRONMENT = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ENVIRONMENT' AND SECONDARY_SELECTION='Job' ORDER BY PRIORITY ASC";
	private $query_STREAM_ENVIRONMENT = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ENVIRONMENT' AND SECONDARY_SELECTION='Stream' ORDER BY PRIORITY ASC";
	private $query_FILE_ENVIRONMENT = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ENVIRONMENT' AND SECONDARY_SELECTION='File' ORDER BY PRIORITY ASC";
	private $query_OTHER_ENVIRONMENT = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ENVIRONMENT' AND SECONDARY_SELECTION='Other' ORDER BY PRIORITY ASC";
	
	// Additional Questions Drop Down Queries
	private $query_SUBMIT_PREDEFINED = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ADDITIONAL' AND SECONDARY_SELECTION='Submit Predefined' ORDER BY PRIORITY ASC";
	private $query_RELEASE = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ADDITIONAL' AND SECONDARY_SELECTION='Release' ORDER BY PRIORITY ASC";
	private $query_RERUN = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ADDITIONAL' AND SECONDARY_SELECTION='Rerun' ORDER BY PRIORITY ASC";
	private $query_HOLD = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ADDITIONAL' AND SECONDARY_SELECTION='Hold' ORDER BY PRIORITY ASC";
	private $query_UNHOLD = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ADDITIONAL' AND SECONDARY_SELECTION='Unhold' ORDER BY PRIORITY ASC";
	private $query_BYPASS = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ADDITIONAL' AND SECONDARY_SELECTION='Bypass' ORDER BY PRIORITY ASC";
	private $query_IGNORE_ALERT = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ADDITIONAL' AND SECONDARY_SELECTION='Ignore Alert' ORDER BY PRIORITY ASC";
	private $query_RESUBMIT = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ADDITIONAL' AND SECONDARY_SELECTION='Resubmit' ORDER BY PRIORITY ASC";
	private $query_CANCEL = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ADDITIONAL' AND SECONDARY_SELECTION='Cancel' ORDER BY PRIORITY ASC";
	private $query_INFORMATION = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ADDITIONAL' AND SECONDARY_SELECTION='Information' ORDER BY PRIORITY ASC";
	private $query_FILE_TRANSFER_STATUS = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ADDITIONAL' AND SECONDARY_SELECTION='File Transfer Status' ORDER BY PRIORITY ASC";
	private $query_RESTORE_FILE = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ADDITIONAL' AND SECONDARY_SELECTION='Restore File' ORDER BY PRIORITY ASC";
	private $query_OPEN_TICKET = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ADDITIONAL' AND SECONDARY_SELECTION='Open Ticket' ORDER BY PRIORITY ASC";
	private $query_KILL = "SELECT DROPDOWN_OPTIONS FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='ADDITIONAL' AND SECONDARY_SELECTION='Kill' ORDER BY PRIORITY ASC";
	
	// Email Drop Down Query
	//private $query_EMAIL = "SELECT DROPDOWN_OPTIONS, SECONDARY_SELECTION FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='TEAMEMAIL' ORDER BY PRIORITY ASC";
	private $query_EMAIL = "SELECT * FROM TB_SUPPORT_FORM_DROPDOWN WHERE DROPDOWN_NAME='TEAMEMAIL' ORDER BY PRIORITY ASC";
	
	
	

	
	
	
	// Constructor
	function ISOCSupportFormDB_Out()
	{
		// Call to Base constructor (its apparently necessary in php... sigh)
		parent::BaseDataBase();	 
	}
	
	// Run Query , place in a php array and then return the array
	public function changeToArray( $aQuery, $field)
	{	
		$tempArray = array();
		
		if ( $result = parent::getDbConnection()->query($aQuery) ) 
		{
			while ($row = $result->fetch_assoc() ) 
			{
				$tempArray[] = $row[$field];
			}
			
			return $tempArray;
		} 
		else 
		{
			echo "No results from database, check your sql statement.";
		}
	}
	
	public function multiFieldChangeToArray ($aQuery)
	{
			$tempKeys = array();
			$tempValue = array();
			
		// run SQL query using database connection
		if ( $result = parent::getDbConnection()->query($aQuery) ) 
		{			
			// Returns true or false, true if there is a row
			// Creates a numeric array for each value that was fetched from database
			while ($row = $result->fetch_array(MYSQLI_NUM) ) 
			{
				// Iterate through array and place in temporary array.
				foreach ($row as &$field)
				{
					$tempValue[] = $field;
				}
			}
			
			/* free result set <-- memory*/
			$result->free();

			// return the array
			return  $tempValue;
		} 
		else 
		{
			echo "No results from database, check your sql statement.";
		}
	}
	
	
	public function multiFieldChangeToArrayAssociative ($aQuery)
	{
			$tempKeys = array();
			$tempValue = array();
			$fetchFields = array();
			

		// run SQL query using database connection
		if ( $result = parent::getDbConnection()->query($aQuery) ) 
		{
			$fetchFields = $result->fetch_fields();
			foreach ($fetchFields as $val)
			{
				$tempKeys[] = $val->name;
			}
			// flip the values to keys
			$tempKeys = array_flip($tempKeys);
			// strip values
			$tempKeys = array_keys($tempKeys);
			
			
			// Returns true or false, true if there is a row
			// Creates a numeric array for each value that was fetched from database
			while ($row = $result->fetch_array(MYSQLI_NUM) ) 
			{
				
				
				// Iterate through array and place in temporary array.
				foreach ($row as &$field)
				{
					$tempValue[] = $field;
				}
			}
		
			
			// strip keys
			$tempValue = array_values( $tempValue );
			//echo count($tempValue);
			
			// Double the keys
			$tempKeys = array_combine( $tempKeys, $tempKeys);
			
			// combine
			$tempValue = array_combine( $tempKeys, $tempValue);
			
			/* free result set <-- memory*/
			$result->free();

			// return the array
			return  $tempValue;
		} 
		else 
		{
			echo "No results from database, check your sql statement.";
		}
	}
	
	
	public function printResults( $anArray )
	{
		print_r($anArray);
	}
	

	// TEST --------  Dynamic Function
	public function getDataFromDB( $queryStatment, $dbFieldName )
	{
		return $this->changeToArray( ($queryStatment) , $dbFieldName );
	}



	// Main Options Drop Down Function
	public function getMainOptions()
	{
		return $this->changeToArray( ($this->query_MAIN_OPTIONS) , 'DROPDOWN_OPTIONS' );
	}


	// Request Type Drop Down Functions
	public function getJobRequestOptions()
	{
		return $this->changeToArray( ($this->query_JOB_REQUEST_TYPE_OPTIONS) , 'DROPDOWN_OPTIONS' );
	}
	public function getOtherRequestOptions()
	{
		return $this->changeToArray( ($this->query_OTHER_REQUEST_TYPE_OPTIONS) , 'DROPDOWN_OPTIONS' );
	}
	public function getStreamRequestOptions()
	{
		return $this->changeToArray( ($this->query_STREAM_REQUEST_TYPE_OPTIONS) , 'DROPDOWN_OPTIONS' );
	}
	public function getFileRequestOptions()
	{
		return $this->changeToArray( ($this->query_FILE_REQUEST_TYPE_OPTIONS) , 'DROPDOWN_OPTIONS' );
	}
	
	// Environment Drop Down Options
	public function getJobEnvironmentOptions()
	{
		return $this->changeToArray( ($this->query_JOB_ENVIRONMENT) , 'DROPDOWN_OPTIONS' );
	}
	public function getStreamEnvironmentOptions()
	{
		return $this->changeToArray( ($this->query_STREAM_ENVIRONMENT) , 'DROPDOWN_OPTIONS' );
	}
	public function getFileEnvironmentOptions()
	{
		return $this->changeToArray( ($this->query_FILE_ENVIRONMENT) , 'DROPDOWN_OPTIONS' );
	}
	public function getOtherEnvironmentOptions()
	{
		return $this->changeToArray( ($this->query_OTHER_ENVIRONMENT) , 'DROPDOWN_OPTIONS' );
	}
	
	// Additional Drop Down Options
	public function getSubmitPredefined()
	{
		return $this->changeToArray( ($this->query_SUBMIT_PREDEFINED ) , 'DROPDOWN_OPTIONS' );
	}
	public function getRelease()
	{
		return $this->changeToArray( ($this->query_RELEASE ) , 'DROPDOWN_OPTIONS' );
	}	
	public function getRerun()
	{
		return $this->changeToArray( ($this->query_RERUN ) , 'DROPDOWN_OPTIONS' );
	}
	public function getHold()
	{
		return $this->changeToArray( ($this->query_HOLD  ) , 'DROPDOWN_OPTIONS' );
	}	
	public function getUnhold()
	{
		return $this->changeToArray( ($this->query_UNHOLD   ) , 'DROPDOWN_OPTIONS' );
	}	
	public function getIgnoreAlert()
	{
		return $this->changeToArray( ($this->query_IGNORE_ALERT ) , 'DROPDOWN_OPTIONS' );
	}
	public function getResubmit()
	{
		return $this->changeToArray( ($this->query_RESUBMIT  ) , 'DROPDOWN_OPTIONS' );
	}	
	public function getCancel()
	{
		return $this->changeToArray( ($this->query_CANCEL   ) , 'DROPDOWN_OPTIONS' );
	}	
	public function getInformation()
	{
		return $this->changeToArray( ($this->query_INFORMATION ) , 'DROPDOWN_OPTIONS' );
	}	
	public function getFileTransferStatus()
	{
		return $this->changeToArray( ($this->query_FILE_TRANSFER_STATUS  ) , 'DROPDOWN_OPTIONS' );
	}	
	public function getRestoreFile()
	{
		return $this->changeToArray( ($this->query_RESTORE_FILE   ) , 'DROPDOWN_OPTIONS' );
	}		
	public function getOpenTicket()
	{
		return $this->changeToArray( ($this->query_OPEN_TICKET  ) , 'DROPDOWN_OPTIONS' );
	}	
	public function getKill()
	{
		return $this->changeToArray( ($this->query_KILL   ) , 'DROPDOWN_OPTIONS' );
	}
	

	public function getEmail()
	{
		return $this->multiFieldChangeToArray($this->query_EMAIL);
	}
	
	public function checkUserIDExist( $aEmailAddress )
	{
		// create variables
		$requestID='';
		$tmpArray = Array();
		
		
		// Query database to see if an email address exists
		$qurey_RequesterEmailAddressExists = "SELECT REQUESTER_ID FROM TB_SUPPORT_FORM_REQUESTER WHERE REQUESTER_EMAIL_ADDRESS LIKE '%$aEmailAddress%'";
		
		// place result in tmpArray
		$tmpArray = $this->multiFieldChangeToArray( $qurey_RequesterEmailAddressExists) ;
		
		// convert array into a string
		$requestID = implode( '', $tmpArray);
		
		// return the RequestID
		return $requestID;
	}
	
	public function getOneRowWhereEquals( $aTable, $aFieldName, $aPrimaryKey )
	{
		
		// Query database to see if an email address exists
		$sql = "SELECT * FROM $aTable WHERE $aFieldName = $aPrimaryKey LIMIT 1";
		
		// return an associative array with row
		return $this->multiFieldChangeToArrayAssociative( $sql) ;
	}
	
	
	
}

?>