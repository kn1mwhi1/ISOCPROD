<?php

/************************************************************
* This code processes request to edit the DB with data sent *
* from EDIT Turnover page                                   *
*************************************************************/

	require 'turnoverVariables.php'; // Setting variables

		// Setting DB connection string variable
			$conn = mysqli_connect($servername, $username, $password, $dbname);
			
		// Checking for connection errors to DB
			if (mysqli_connect_errno()) {
				echo "Failed to connect to MySQL: " .mysqli_connect_error();
			}
		
		// Custom function to run variables through the mysqli_real_escape_string function
			function array_map_callback($a) {
			
			// Setting connection variable to be used with mysqli_real_escape_string function
				global $conn;
				
			// Return result (escaped string) of input ($a) after running through mysqli_real_escape_string
				return mysqli_real_escape_string($conn, $a);
			}
			
		// Validate new turnover items exist in newTurnover POST variable
			if (isset($_POST['newTurnover']) && !empty($_POST['newTurnover'])) {
			
			// Using array_map function to process new turnover items through the custom array_map_callback function
				$new_turnover = array_map('array_map_callback', $newTurnover);
			}
		
		// Validate updated turnover items exist in updateTurnover POST variable
			if (isset($_POST['updateTurnover']) && !empty($_POST['updateTurnover'])) {
			
			// Using array_map function to process updated turnover items through the custom array_map_callback function 
				$updated_turnover = array_map('array_map_callback', $updateTurnover);
			}
					
/*************************************
* Begin editing turnover in database *
**************************************/
			
		// Query to update the shift. Is run every time even if shift did not change.
			$query = "UPDATE TB_TURNOVER SET SHIFT = '$shift' WHERE TURNOVER_ID = '$turnover_id';";
			
		// Validate existing Turnover Items are set in the updateTurnover variable
			if (isset($_POST['updateTurnover']) && !empty($_POST['updateTurnover'])) {
			
		// loops through all existing Turnover Items and overwrites them in the DB with current values from Edit Form
				for ($i = 0; $i < count($updateTurnover); $i++) {
					$query .= "UPDATE TB_TURNOVER_ITEM SET TURNOVER_ITEM = '$updated_turnover[$i]' WHERE ITEM_ID = '$turnover_item[$i]';";
				}
			}
			
		// Validate new Turnover Items exist	
			if (isset($_POST['newTurnover']) && !empty($_POST['newTurnover'])) {
			
		// loops through new turnover items and saves them to the DB
				for ($i = 0; $i < count($new_turnover); $i++) {
					$query .= "INSERT INTO TB_TURNOVER_ITEM (TURNOVER_ITEM, TURNOVER_ID) VALUES ('$new_turnover[$i]', '$turnover_id');";
				}
			}
			
		// Validate the technicians variable contains Technicians from the Edit Form
			if (isset($_POST['technicians']) && !empty($_POST['technicians'])) {
			
		// loops through all Technicians and overwrites them in the DB with current values from Edit Form
				foreach ($selection as $t_selection) {
					$query .= "INSERT INTO TB_TURNOVER_ISOCTECHS (TECH_NAME, TURNOVER_ID) VALUES ('$t_selection', '$turnover_id');";
				}
			}
			
		// Execute the queries 
			if (mysqli_multi_query($conn, $query)) {
				do {
				
				// store first result set
					if ($result = mysqli_store_result($conn)) {
						while ($row = mysqli_fetch_row($result)) {
							printf("%s\n", $row[0]);
						}
						
				// Free memory from all rows submitted (row set)
						mysqli_free_result($result);  
					}
					
				// Formats results of the queries
					if (mysqli_more_results($conn)) {
						printf("-----------------\n");
					}
				} 
			
			// Continue running queries until all are complete
				while (mysqli_more_results($conn) && mysqli_next_result($conn));
			}
		
		// Close connection to the DB
			mysqli_close($conn);
			
		// Redirects browser to confirmation page after queries are run	
			$host = $_SERVER['HTTP_HOST'];
			$uri = '/confirmation.php';
			header("Location: http://$host$uri");	
?>