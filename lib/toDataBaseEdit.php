<?php

require 'turnoverVariables.php';


$conn = mysqli_connect($servername, $username, $password, $dbname);
		
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " .mysqli_connect_error();
		}
	
	// function to process variables through mysqli_real_escape_string
		function array_map_callback($a) {
			global $conn;
			return mysqli_real_escape_string($conn, $a);
		}
	
	// Running newTurnover variable through mysqli_real_escape_string
		if (isset($_POST['newTurnover']) && !empty($_POST['newTurnover'])) {
			$new_turnover = array_map('array_map_callback', $newTurnover);
		}
	
	// Running updateTurnover variable through mysqli_real_escape_string
		if (isset($_POST['updateTurnover']) && !empty($_POST['updateTurnover'])) {
			$updated_turnover = array_map('array_map_callback', $updateTurnover);
		}
		
		
	//Begin editing turnover in database
		
	// Updating the shift
		$query = "UPDATE TB_TURNOVER SET SHIFT = '$shift' WHERE TURNOVER_ID = '$turnover_id';";
		
	// Updating the Status and Turnover Items of the existing Turnover	
		if (isset($_POST['updateTurnover']) && !empty($_POST['updateTurnover'])) {
			for ($i = 0; $i < count($updateTurnover); $i++) {
				$query .= "UPDATE TB_TURNOVER_ITEM SET TURNOVER_ITEM = '$updated_turnover[$i]' WHERE ITEM_ID = '$turnover_item[$i]';";
			}
		}
	// Creating new Turnover Items and Statuses	
		if (isset($_POST['newTurnover']) && !empty($_POST['newTurnover'])) {
			for ($i = 0; $i < count($new_turnover); $i++) {
				$query .= "INSERT INTO TB_TURNOVER_ITEM (TURNOVER_ITEM, TURNOVER_ID) VALUES ('$new_turnover[$i]', '$turnover_id');";
			}
		}
		
	// Creating new Technicians
		if (isset($_POST['technicians']) && !empty($_POST['technicians'])) {
			foreach ($selection as $t_selection) {
				$query .= "INSERT INTO TB_TURNOVER_ISOCTECHS (TECH_NAME, TURNOVER_ID) VALUES ('$t_selection', '$turnover_id');";
			}
		}
		
	// execute multi query 
	
		if (mysqli_multi_query($conn, $query)) {
			do {
	// store first result set
				if ($result = mysqli_store_result($conn)) {
					while ($row = mysqli_fetch_row($result)) {
						printf("%s\n", $row[0]);
					}
					mysqli_free_result($result);  // free memory from all rows submitted (row set)
				}
	// print divider
				if (mysqli_more_results($conn)) {
					printf("-----------------\n");
				}
			} while (mysqli_more_results($conn) && mysqli_next_result($conn));
		}

		mysqli_close($conn);
		
		
		$host = $_SERVER['HTTP_HOST'];
	//	$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$uri = '/confirmation.php';
		header("Location: http://$host$uri");
		
?>