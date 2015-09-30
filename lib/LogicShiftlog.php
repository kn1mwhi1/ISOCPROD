<?php
require once 'DBConnection.php';

class ISOCShiftLog extends DatabaseConnection {
	
	//data fields from each row
	private $ALL = "SELECT * FROM TB SHIFTLOG"
	
		
	
	
	public function multiFieldChangeToArray ($aQuery)
	{
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
					$tempArray[] = $field;
				}
			}
			/* free result set <-- memory*/
			$result->free();

			// return the array
			return $tempArray;
		} 
		else 
		{
			echo "No results from database, check your sql statement.";
		}
	}
	
	
}



?>