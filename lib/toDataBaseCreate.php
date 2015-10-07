<?php
	require 'turnoverVariables.php';
		
		
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " .mysqli_connect_error();
		}
		
		function array_map_callback($a) {
			global $conn;
			return mysqli_real_escape_string($conn, $a);
		}
		
		$t_turnover = array_map('array_map_callback', $turnover);
		
	// Checks to see if Turnover has already been open for the day and prevents duplicate from being opened.
		
		$sql = "SELECT * FROM `TB_TURNOVER` WHERE DATE='$date' AND SHIFT='$shift'";
		
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			$currentHost = $_SERVER['HTTP_HOST'];
			$currentUri = '/createTurnoverError.php';
			header("Location: http://$currentHost$currentUri");
		} else {
		
				//Begin inserting turnover into database

					$query = "BEGIN;";
					$query .= "INSERT INTO TB_TURNOVER (SHIFT, DATE, TIME) VALUES ('$shift', '$date', '$time');";
					$query .= "SET @last_id = LAST_INSERT_ID();";
					if (isset($_POST['turnover']) && !empty($_POST['turnover'])) {
						for ($i = 0; $i < count($t_turnover); $i++) {
							$query .= "INSERT INTO TB_TURNOVER_ITEM (TURNOVER_ITEM, TURNOVER_ID) VALUES ('$t_turnover[$i]', @last_id);";
							
						}
					} else {
						$t_turnover = "No Turnover Items";
						$query .= "INSERT INTO TB_TURNOVER_ITEM (TURNOVER_ITEM, TURNOVER_ID) VALUES ('$t_turnover', @last_id);";
						
						}
					foreach ($selection as $t_selection) {
					$query .= "INSERT INTO TB_TURNOVER_ISOCTECHS (TECH_NAME, TURNOVER_ID) VALUES ('$t_selection', @last_id);";
					}
					$query .= "COMMIT;";
					
					
					/* execute multi query */
					if (mysqli_multi_query($conn, $query)) {
						do {
							/* store first result set */
							if ($result = mysqli_store_result($conn)) {
								while ($row = mysqli_fetch_row($result)) {
									printf("%s\n", $row[0]);
								}
								mysqli_free_result($result);  // free memory from all rows submitted (row set)
							}
							/* print divider */
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
		}
		
?>