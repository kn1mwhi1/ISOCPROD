<?php

	/***********************************************************************************
	* This code will retrieve Technicians from the TB_ISOC_TECHS table in the Database *
	* separate them into shifts (1st, 2nd, 3rd and Cross Shift) to be used in the      *
	* forms to populate the Technicians select menu in Create and Edit Turnover.       *
	************************************************************************************/

	// Setting variables
		require 'turnoverVariables.php';

	// Connecting to the Database
		if ($conn->connect_error) {
			die("Failed to connect to MySQL: " . $conn->connect_error);
		}

	// Query to get Technicians that work on first shift	
		$sql = "SELECT isoc_tech_first_name, isoc_tech_last_name FROM TB_ISOC_TECHS WHERE isoc_tech_shift='1'";

	// Set up variable to store result of the query
		$result = $conn->query($sql);

	// Create empty array to store results
		$firstShiftTechs = array();

	// Execute the query	
		if (mysqli_multi_query($conn,$sql)) {
			if ($result=mysqli_store_result($conn)) {
				while ($row=mysqli_fetch_assoc($result)) {
			// Set the query results to the empty array variable creating an associative array inside an indexed array
					$firstShiftTechs[] = $row;
				}
			}
			
	// Free memory from all rows submitted (row set)			
		mysqli_free_result($conn);
		
	// Run additional queries if applicable
		 if (mysqli_more_results($conn)) {
			mysqli_next_result($conn);
			}
		}
				
	// Query to get Technicians that work on second shift
		$sql = "SELECT isoc_tech_first_name, isoc_tech_last_name FROM TB_ISOC_TECHS WHERE isoc_tech_shift='2'";
		
	// Create empty array to store results
		$secondShiftTechs = array();

	// Execute the query	
		if (mysqli_multi_query($conn,$sql)) {
			if ($result=mysqli_store_result($conn)) {
				while ($row=mysqli_fetch_assoc($result)) {
			// Set the query results to the empty array variable creating an associative array inside an indexed array
					$secondShiftTechs[] = $row;
				}
			}

	// Free memory from all rows submitted (row set)		
		mysqli_free_result($conn);
		
	// Run additional queries if applicable
		 if (mysqli_more_results($conn)) {
			mysqli_next_result($conn);
			} 
		}

	// Query to get Technicians that work on third shift	
		$sql = "SELECT isoc_tech_first_name, isoc_tech_last_name FROM TB_ISOC_TECHS WHERE isoc_tech_shift='3'";
		
	// Create empty array to store results
		$thirdShiftTechs = array();

	// Execute the query	
		if (mysqli_multi_query($conn,$sql)) {
			if ($result=mysqli_store_result($conn)) {
				while ($row=mysqli_fetch_assoc($result)) {
			// Set the query results to the empty array variable creating an associative array inside an indexed array
					$thirdShiftTechs[] = $row;
				}
			}

	// Free memory from all rows submitted (row set)			
		mysqli_free_result($conn);
		
	// Run additional queries if applicable
		 if (mysqli_more_results($conn)) {
			mysqli_next_result($conn);
			} 
		}
			
	// Query to get the Cross Shift Technicians
		$sql = "SELECT isoc_tech_first_name, isoc_tech_last_name FROM TB_ISOC_TECHS WHERE isoc_tech_shift='CS'";
		
	// Create empty array to store results
		$crossShiftTechs = array();

	// Execute the query	
		if (mysqli_multi_query($conn,$sql)) {
			if ($result=mysqli_store_result($conn)) {
				while ($row=mysqli_fetch_assoc($result)) {
			// Set the query results to the empty array variable creating an associative array inside an indexed array
					$crossShiftTechs[] = $row;
				}
			}
				
	// Free memory from all rows submitted (row set)
		mysqli_free_result($conn);
		
	// Run additional queries if applicable
		 if (mysqli_more_results($conn)) {
			mysqli_next_result($conn);
			} 
		}
		
	// Close the database connection			
		mysqli_close($conn);
?>