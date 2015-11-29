<?php

	/************************************************************************************
	* This code process AJAX requests from Edit Turnover to delete Technicians from the *
	* TB_TURNOVER_ISOCTECHS table and delete Turnover Items from the TB_TURNOVER_ITEM   *
	* table.                                                                            *
	*************************************************************************************/
		
	// Setting variables
		require 'turnoverVariables.php'; 

	// Setting DB connection string variable
		$conn = mysqli_connect($servername, $username, $password, $dbname);

	// Checking for connection errors to DB
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " .mysqli_connect_error();
		}
		
	// Checking if Technicians exist in variable from Edit Turnover form
		if (isset ($_POST['oldTech']) && !empty($_POST['oldTech'])){

		// Query to delete the selected Technician
			$query = "DELETE FROM TB_TURNOVER_ISOCTECHS WHERE ISOCTECHS_ID='$oldTech';";
			
		// Execute the query
			mysqli_query($conn,$query);
		}
		
	// Checking if existing Turnover Items exist in variable from Edit Turnover Form
		if (isset ($_POST['oldTurnover']) && !empty($_POST['oldTurnover'])){
		
		// Query to delete the selected Turnover Item
			$query = "DELETE FROM TB_TURNOVER_ITEM WHERE ITEM_ID = '$oldTurnover';";
		
		// Execute the query
			mysqli_query($conn,$query);
		}
		
	// Close connection to the DB
		mysqli_close($conn);
?>