<?php 
require_once 'Class_BaseDataBase.php';

class LoginDB_Out extends BaseDataBase{

	// Constructor
	function LoginDB_Out()
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
			
			// Double the keys to make the same number of elements in each array on next combine.
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

	
	public function getOneRowWhereEquals( $aTableName, $aFieldName, $searchKey )
	{
		
		// Query database to see if an email address exists
		$sql = "SELECT * FROM $aTableName WHERE $aFieldName = $searchKey LIMIT 1";
		
		// return an associative array with row
		return $this->multiFieldChangeToArrayAssociative( $sql) ;
	}
	
	
	
}

?>