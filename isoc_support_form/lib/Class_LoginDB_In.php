<?php 
require_once 'Class_BaseDataBase.php';

class LoginDB_In extends BaseDataBase{

	// Constructor
	function LoginDB_In()
	{
		// Call to Base constructor (its apparently necessary in php... sigh)
		parent::BaseDataBase();	 
	}
	

	
	private function saveToDB( $aQuery )
	{
		//mysqli_query($link, $query);
		parent::getDbConnection()->query($aQuery);
	}
	
	
	// return last transaction id (insert or update);
	public function getLastTransactionID()
	{
		return $id = parent::getDbConnection()->insert_id ;
	}
	
	
	// Create a legal SQL string that you can use in an SQL statement. 
	// Helps against sql injection.
	public function sanitizeStringForSQL ( $string )
	{
		$cleanString = parent::getDbConnection()->real_escape_string($string);
		return $cleanString;
	}
	
	
	public function insertRecordOneTable( $anArray , $aTable = 'TB_SUPPORT_FORM_DATA', $fieldTypes = '' )
	{
		//echo "The table:  $aTable <br />";
		// http://stackoverflow.com/questions/16120822/mysqli-bind-param-expected-to-be-a-reference-value-given
		// Create an array of references
		$refArray = array();
        foreach($anArray as $key => $value)
		{
            $refArray[$key] = &$anArray[$key];
		}
		
		
		
		// strip the keys
		$values = array_values( $refArray );
		$fields = array_keys($anArray);
		$questionMarks = array();
		$detectBlank = $fieldTypes;  // used to auto-populate field types with strings
		
		// create an array for the number 
		for ($x=0; $x < count($fields); $x++)
		{
			// fill arrays with questions marks for prepared statement.
			$questionMarks[$x] = '?';
			
			// if user does not supply the field types assume all strings
			if ($detectBlank == '')
			{
			$fieldTypes =  $fieldTypes.'s';
			}
		}
		
		// create final SQL statement based upon the parameters
		$sql = "INSERT INTO `$aTable` (".implode( " ," , $fields ).") VALUES (".implode( "," , $questionMarks )." )";
		
		// place data types in the first element of the array and shift the other values
		
		// merge the datatype for the db fields and the values into one array. (references of )
		$result = array_merge( array(&$fieldTypes), $values); 
		
		
			// Process insert transaction to the Database
		try
		{
			// Prepare the SQL statement for execution
			$res = parent::getDbConnection()->prepare( $sql ) ;
			
			// Create the binding of variables from arrays to the prepared sql statement
			$ref = new ReflectionClass("mysqli_stmt"); 
			$method = $ref->getMethod("bind_param"); 
			$method->invokeArgs($res,$result); 
			
			// Execute the SQL prepared statement
			$res->execute(); 
			
			// Need to throw an exception if entry was invalid
			
		}
		catch (Exception $e)
		{
			echo "<br /> <b>There was an issue when trying to process your request</b><br /> Eror: $e <br />";
		}
	}
	
	// $updateArray is 
	
	
	public function updateRecordOneTable( $updateArray , $whereArray, $equalsOrLike, $aTableName , $fieldTypes = '', $andOr = 'AND' ,$limit = 1)
	{
		// Change the values in the $whereArray if the user wants to perform a LIKE and ensure 
		// the $equalsOrLike is change to upper-case, this will affect the and as well (AND).
		$whereArray = $this->changeDataForLikeUpdate( $equalsOrLike, $whereArray );
		
		// create the parametrized sql statement based upon parameters
		$sql = $this->createUpdatePreparedSQLStatement( $updateArray, $whereArray, $aTableName, $equalsOrLike, $limit);
		echo $sql;
		
		
		$updateRefArray = array();
		$updateWhereArray = array();
		$result = array();
		$values = array();
		

		
        foreach($updateArray as $key => $value)
		{
      
			// add value references to a new array
  		    $updateRefArray[$key] = &$updateArray[$key];
			  
		}
				
				
		//$statementWhere = '';
		
        foreach($whereArray as $key => $value)
		{			
			// add value references to a new array
			$updateWhereArray[$key] = &$whereArray[$key];
		}
		
		
		
		
		// Strip the values of each array set and where array and then merge the two arrays into one main array.
		$values = array_merge( array_values( $updateRefArray) , array_values( $updateWhereArray) ) ;
		
	    // merge the datatype for the db fields and the values into one array. (references of )
		$result = array_merge( array(&$fieldTypes), $values); 
		
		
		
		// Prepare, bind and execute the SQL based upon parameters
		$this->prepareBindExecuteSQL( $sql, $result);	
	}
	
	
	private function prepareBindExecuteSQL( &$sql, &$result)
	{
		try
		{
			// Prepare the SQL statement for execution
			$res = parent::getDbConnection()->prepare( $sql ) ;
			
			// Create the binding of variables from arrays to the prepared sql statement
			$ref = new ReflectionClass("mysqli_stmt"); 
			$method = $ref->getMethod("bind_param"); 
			$method->invokeArgs($res,$result); 
			
			// Execute the SQL prepared statement
			$res->execute(); 
			
			// Need to throw an exception if entry was invalid
			
		}
		catch (Exception $e)
		{
			echo "<br /> <b>There was an issue when trying to process your request</b><br /> Eror: $e <br />";
		}
	}
	
	private function createUpdatePreparedSQLStatement( $updateArray, $whereArray, &$aTableName, &$equalsOrLike, &$limit)
	{
		$statementSet = '';
		foreach($updateArray as $key => $value)
		{
           	// Create first part of statement
			if ($statementSet != '' )
			{
				$statementSet = ''.$statementSet .', '. $key . ' = ? ';
			}
			else
			{
				$statementSet = 'UPDATE '.$aTableName.' SET '.$key.'= ? ';
			}  
		}
				
				
		$statementWhere = '';
        foreach($whereArray as $key => $value)
		{
				if ( $equalsOrLike == 'LIKE')
				{
					// Create first part of statement
					if ($statementWhere != '' )
					{
						$statementWhere = ''.$statementWhere.$andOr.' '.$key.' LIKE ? ';
					}
					else
					{
						$statementWhere = 'WHERE '.$key.' LIKE ? ';
					}
				}
				else
				{
					// Create first part of statement
					if ($statementWhere != '' )
					{
						$statementWhere = ''.$statementWhere.$andOr.' '.$key.' = ? ';
					}
					else
					{
						$statementWhere = 'WHERE '.$key.' = ? ';
					}
				}
		}
		
		
		// set limit of update , default is 1
		if ( is_numeric($limit) )
		{
			// create final SQL statement based upon the parameters
			$sql = ''.$statementSet.$statementWhere.' LIMIT '.$limit;
		}
		else
		{
			$sql = ''.$statementSet.$statementWhere;
		}
		
		return $sql;
	}
	
	/*
	* @param: string $likeOrEquals by reference
	*				{ A string variable that represents AND or LIKE in a SQL query. }
	* @param: array $whereArray
	*				{ An array that holds the values for the where portion of the where array. }
	*	This function adds the % sign to the beginning and end value in the where array which is used for 
	*	the Like statement.
	*
	* @return: Return an array of where values with % signs before and after for each value in the array.
	* @reference:  Changes the original string $likeOrEquals to all upper-case
	*/
	private function changeDataForLikeUpdate( &$likeOrEquals , $whereArray )
	{
		// Make variable all upper-case
		$likeOrEquals = strtoupper( $likeOrEquals );
		
		if ($likeOrEquals == 'LIKE')
		{
			// add % signs on both sides of the value which are wild cards in SQL to each value in the array.
			foreach ($whereArray as $key => $value)
			{
				$whereArray[$key] = '%'.$value.'%';
				echo "$key => $value  $whereArray[$key]";
			}
		}
		
		return $whereArray;
	}
	
	
	
	
	//*******************************  retired functions **********************************************************************************
	

	// Update test table with two names (Parametrized SQL Insert)
	// Also provides the ability to sanitize information for good SQL statements.
	// http://php.net/manual/en/mysqli-stmt.bind-param.php
	public function insertName( $parameterOne, $parameterTwo )
	{
		$tempOne = $this->sanitizeStringForSQL( $parameterOne );
		$tempTwo = $this->sanitizeStringForSQL( $parameterTwo );
		
		// Prepared Statements
		$stmt = parent::getDbConnection()->prepare("INSERT INTO TB_TESTMATT (FIRST_NAME, LAST_NAME) VALUES( ?, ? )") ;
		$stmt->bind_param('ss', $tempOne, $tempTwo);
		
		// Save to Database
		$stmt->execute();
		
		// non- parametrized sql insert
		//$query = "INSERT INTO `TB_TESTMATT` (`FIRST_NAME`, `LAST_NAME`) VALUES('".$tempOne."', '".$tempTwo."')";
		//$this->saveToDB( $query );
	}

	// Update First Name , good example of prepared statement and usage of Like
	public function updateFirstName( $oldName, $newName )
	{
		$stmt = parent::getDbConnection()->prepare("UPDATE TB_TESTMATT SET FIRST_NAME = ? WHERE FIRST_NAME LIKE ? LIMIT 1") ;
		
		// added % to string for the wild card LIKE and sanitized the string
		$tempOne = $this->sanitizeStringForSQL( '%'.$oldName.'%' );
		$tempTwo = $this->sanitizeStringForSQL( $newName );
		
		$stmt->bind_param('ss', $tempTwo, $tempOne);
		
		// Save to Database
		$stmt->execute();
	}
	
	
}

?>