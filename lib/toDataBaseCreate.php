<?php

	/*******************************************************************************************
	* This code processes POST data sent from the Create Turnover page. It creates new entries *
	* in all Turnover Tables ( TB_TURNOVER, TB_TURNOVER_ITEM and TB_TURNOVER_ISOCTECHS).       *
	********************************************************************************************/
	
	// Setting variables
		require 'turnoverVariables.php';
	
	// Setting DB connection string variable
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		
	// Checking for connection errors to DB
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " .mysqli_connect_error();
		}
		
	// Custom function to run variables through the mysqli_real_escape_string function
		function array_map_callback($a) {
			global $conn;
			return mysqli_real_escape_string($conn, $a);
		}
		
	// Running Turnover Items through the custom function for the mysqli_real_escape_string
		$t_turnover = array_map('array_map_callback', $turnover);
		
	// Checks to see if Turnover has already been open for the day and prevents duplicate from being opened.
		$sql = "SELECT * FROM `TB_TURNOVER` WHERE DATE='$date' AND SHIFT='$shift'";
	
	// Store the result of the query
		$result = $conn->query($sql);
	
	// If a Turnover is already opened for the selected shift, redirect the browser to an error page
		if ($result->num_rows > 0) {
			$currentHost = $_SERVER['HTTP_HOST'];
			$currentUri = '/createTurnoverError.php';
			header("Location: http://$currentHost$currentUri");
		} 
		
	// If no Turnover is opened for selected shift, begin inserting the new turnover into database	
		else {
		
	// Multiple queries linked together with BEGIN and COMMIT statements to ensure all are successful before saving to the DB
			$query = "BEGIN;";
			$query .= "INSERT INTO TB_TURNOVER (SHIFT, DATE, TIME) VALUES ('$shift', '$date', '$time');";
			
	// Sets the DB variable @last_id to the TURNOVER_ID value which is the PK for the TB_TURNOVER table and FK for all others
			$query .= "SET @last_id = LAST_INSERT_ID();";
			
	// Checking if turnover variable containing turnover items is set
			if (isset($_POST['turnover']) && !empty($_POST['turnover'])) {
			
		// loops through all Turnover Items added to Create Form and adds them to the DB
				for ($i = 0; $i < count($t_turnover); $i++) {
					$query .= "INSERT INTO TB_TURNOVER_ITEM (TURNOVER_ITEM, TURNOVER_ID) VALUES ('$t_turnover[$i]', @last_id);";
				}
			} 
	// If Turnover is opened with no Turnover Items entered a default value "No Turnover Items" is added		
			else {
				$t_turnover = "No Turnover Items";
				$query .= "INSERT INTO TB_TURNOVER_ITEM (TURNOVER_ITEM, TURNOVER_ID) VALUES ('$t_turnover', @last_id);";
			}
	
	// Running the selection variable containing Technicians added to the Turnover form through a foreach loop
			foreach ($selection as $t_selection) {
				$query .= "INSERT INTO TB_TURNOVER_ISOCTECHS (TECH_NAME, TURNOVER_ID) VALUES ('$t_selection', @last_id);";
			}
	
	// If all queries are successful commit or save all queries to the DB
			$query .= "COMMIT;";
				
	// Execute the queries
			if (mysqli_multi_query($conn, $query)) {
				do {
				
				// Store first result set
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
		}
?>