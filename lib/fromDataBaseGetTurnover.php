<?php 
 
	/****************************************************************************************
	* This code will retrieve all Turnover Items from the TB_TURNOVER table in the database *
	* and puts it into an associative array inside an indexed array.  This was originally   *
	* done when we used Status and Turnover item and so the two could be linked together by *
	* the index and the Turnover data would be in the associative array. We are no longer   *
	* using status but changing this would be more work than necessary as it is still works *
	*****************************************************************************************/

	// Setting Turnover Variables
		require 'turnoverVariables.php';
		
	// Login Logic
		require_once 'lib/Class_LoginLogic.php'; 
		$login = new LoginLogic();
		
	/*********************************************************************
	* Begin to pull Turnover data based on user input of Shift and Date. * 
	**********************************************************************/

		// Check if a shift is selected and if so set variable with values for Shift and Date (used in searchTurnover.php)
			if (isset ($_POST['shift-box']) && !empty ($_POST['shift-box'])) {
					$searchShift = $_POST['shift-box'];
					$searchDate = $_POST['advancedDate']; 

				// Formatting date if advanced search is used 
					if (isset ($_POST['advancedDate']) && !empty ($_POST['advancedDate'])) {
						$oldDate = explode("-", $_POST['advancedDate']);
						$searchDate = $oldDate[1].'/'.$oldDate[2].'/'.$oldDate[0];
					}
			
			// Checking for connection errors to DB	
				if ($conn->connect_error) {
					die("Failed to connect to MySQL: " . $conn->connect_error);
				}
					
				// Query to get Turnover ID from database using Date and Shift selected by the user	
					$sql = "SELECT turnover_id FROM TB_TURNOVER WHERE date='$searchDate' AND shift='$searchShift'";
				
				// Store the result of the query
					$result = $conn->query($sql);
				
				// If Turnover exists for the given Date and Shift, set variable for the Turnover Id in an associative array	
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							$turnover_id = $row["turnover_id"];
						}
					}
					
				// Checking if the turnover_id variable is set before continuing	
					if (!empty($turnover_id)) {
					
					// Query to get Technician names for specified Turnover using the turnover_id variable
						$sql = "SELECT tech_name FROM TB_TURNOVER_ISOCTECHS WHERE turnover_id='$turnover_id'";
						
					// Create an empty array to store query results
						$techs = array();
					
					// Execute the query and creating an associative array with the results
						if (mysqli_multi_query($conn,$sql)) {
							if ($result=mysqli_store_result($conn)) {
								while ($row=mysqli_fetch_assoc($result)) {
							// Set the query results to the empty array variable creating an associative array inside an indexed array
									$techs[] = $row;
								}
							}
					// Free memory from all rows submitted (row set)			
						mysqli_free_result($conn);
					
					// Run additional queries if applicable
						 if (mysqli_more_results($conn)) {
							mysqli_next_result($conn);
							} 
						}

					// Query to get Turnover Items for specified Turnover using the turnover_id variable
						$sql = "SELECT turnover_item FROM TB_TURNOVER_ITEM WHERE TURNOVER_ID='$turnover_id'";
					
					// Create an empty array to store query results
						$t_items = array();

					// Execute the query and creating an associative array with the results
						if (mysqli_multi_query($conn,$sql)) {
							if ($result=mysqli_store_result($conn)) {
								while ($row=mysqli_fetch_assoc($result)) {
							// Set the query results to the empty array variable creating an associative array inside an indexed array
									$t_items[] = $row;
								}
							}
					
					// Free memory from all rows submitted (row set)			
						mysqli_free_result($conn);
						 if (mysqli_more_results($conn)) {
						 
					// Run additional queries if applicable
							mysqli_next_result($conn);
							} 
						}
					}
			
			// Close the database connection
				mysqli_close($conn);
				
			}
			
	/***********************************************************
	* Begin to pull Turnover data for the last Turnover opened *
	************************************************************/

			else {
			
				// Query to get the turnover_id for the last Turnover created
					$sql = "SELECT MAX(turnover_id) FROM TB_TURNOVER";
				
				// Store the result of the query
					$result = $conn->query($sql);
				
				// Check to make sure the query returned at least 1 row
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_row()) {
						
					// Create variable for the most recently opened turnover
							$currentTurnover_id = $row[0];
						}
					}
					
				// Display message indicating no results were found. If this error is seen we have serious problems.
					else {
						echo "No results found. Try refreshing the page to see if the issue can be resolved.  If not there may be problems with the database";
					}

				// Query to get the Shift of the most recently opened Turnover	
					$sql = "SELECT shift FROM TB_TURNOVER WHERE turnover_id='$currentTurnover_id'";
					
				// Store the result of the query
					$result = $conn->query($sql);
				
				// Check to make sure the query returned at least 1 row
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_row()) {
						
					// Create variable for the Shift of the most recently opened Turnover
							$currentShift = $row[0];
						}
					} 
				
				// Display message indicating no results were found. If this error is seen we have serious problems.
					else {
						echo "No results found. Try refreshing the page to see if the issue can be resolved.  If not there may be problems with the database";
					}
				
				// Query to get the Date of the most recently opened Turnover
					$sql = "SELECT `date` FROM TB_TURNOVER WHERE turnover_id='$currentTurnover_id'";
				
				// Store the result of the query
					$result = $conn->query($sql);
				
				// Check to make sure the query returned at least 1 row
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_row()) {
						
					// Create variable for the Date of the most recently opened Turnover
							$currentDate = $row[0];
						}
					} 
					
				// Display message indicating no results were found. If this error is seen we have serious problems.	
					else {
						echo "No results found. Try refreshing the page to see if the issue can be resolved.  If not there may be problems with the database";
					}
						
				// Query to get the Technicians from the most recently opened Turnover
					$sql = "SELECT tech_name, isoctechs_id FROM TB_TURNOVER_ISOCTECHS WHERE turnover_id='$currentTurnover_id'";
					
				// Create an empty indexed array to store the associative array containing query results
					$techs = array();
				
				// Execute the query and creating an associative array with the results
					if (mysqli_multi_query($conn,$sql)) {
						if ($result=mysqli_store_result($conn)) {
							while ($row=mysqli_fetch_assoc($result)) {
						// Create variable to contain the associative array containing query results inside the previously empty indexed array
								$techs[] = $row;
							}
						}
				// Free memory from all rows submitted (row set)			
					mysqli_free_result($conn);
					
				// Run additional queries if applicable
					 if (mysqli_more_results($conn)) {
						mysqli_next_result($conn);
						} 
					}
					
				// Query to get the Turnover Items from the most recently opened Turnover
					$sql = "SELECT turnover_item, item_id FROM TB_TURNOVER_ITEM WHERE TURNOVER_ID='$currentTurnover_id'";
					
				// Create an empty indexed array to store the associative array containing query results
					$t_items = array();

				// Execute the query and creating an associative array with the results
					if (mysqli_multi_query($conn,$sql)) {
						if ($result=mysqli_store_result($conn)) {
							while ($row=mysqli_fetch_assoc($result)) {
							
						// Create variable to contain the associative array containing query results inside the previously empty indexed array
								$t_items[] = $row;
							}
						}
				
				// Free memory from all rows submitted (row set)		
					mysqli_free_result($conn);
					
				// Run additional queries if applicable
					 if (mysqli_more_results($conn)) {
						mysqli_next_result($conn);
						}
					}
				
				// Close connection to DB
					mysqli_close($conn);
				}
			
			// Check if the turnover_id variable is empty and if so display an error
				if (empty($turnover_id)) {
				
				// Kill the page if both a Shift and Date weren't selected in Advanced Search. If this error displays the user may have JavaScript disabled.
					if (!empty($searchShift) && empty($searchDate)) {
						die('Oops, Something went wrong.  A Shift and Date are required for Advanced Search. Try refreshing the page or go back to Search Turnover and select a Shift and Date.');
					}

				// Redirect browser to an error page if both the turnover_id and currentTurnover_id variables are empty. If this error is displayed the queries failed and may indicate an DB issue.
					if (empty($turnover_id) && empty($currentTurnover_id)) {
						$turnover_id = "";
						header("Location: viewTurnoverError.php");
						exit;
					}
				}
?>
