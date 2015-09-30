<?php  require 'turnoverVariables.php';
	
// Checking if user input post variables exist
	if (isset ($_POST['shift-box']) && !empty ($_POST['shift-box'])) {
		// Setting user input variables
			$searchShift = $_POST['shift-box'];
			$searchDate = $_POST['advancedDate'];
	
		// formatting date if advanced search is used
			if (isset ($_POST['advancedDate']) && !empty ($_POST['advancedDate'])) {
				$oldDate = explode("-", $_POST['advancedDate']);
				$searchDate = $oldDate[1].'/'.$oldDate[2].'/'.$oldDate[0];
			}
			
		if ($conn->connect_error) {
			die("Failed to connect to MySQL: " . $conn->connect_error);
		}
			
		// Get Turnover ID from database using Date and Shift selected by the user	
			$sql = "SELECT turnover_id FROM TB_TURNOVER WHERE date='$searchDate' AND shift='$searchShift'";
			
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					$turnover_id = $row["turnover_id"];  // Create variable for the Turnover Id to use in other queries
				}
			}
			
			if (!empty($turnover_id)) {
			// Get Technician names using the turnover_id variable
				$sql = "SELECT tech_name FROM TB_TURNOVER_ISOCTECHS WHERE turnover_id='$turnover_id'";
				$techs = array();
				
				if (mysqli_multi_query($conn,$sql)) {
					if ($result=mysqli_store_result($conn)) {
						while ($row=mysqli_fetch_assoc($result)) {
							$techs[] = $row;
						}
					}
						
				mysqli_free_result($conn);
				 if (mysqli_more_results($conn)) {
					mysqli_next_result($conn);
					} 
				}

			//	Get Turnover Items using the turnover_id variable
				$sql = "SELECT turnover_item FROM TB_TURNOVER_ITEM WHERE TURNOVER_ID='$turnover_id'";
				$t_items = array();

				if (mysqli_multi_query($conn,$sql)) {
					if ($result=mysqli_store_result($conn)) {
						while ($row=mysqli_fetch_assoc($result)) {
							$t_items[] = $row;
						}
					}
					
				mysqli_free_result($conn);
				 if (mysqli_more_results($conn)) {
					mysqli_next_result($conn);
					} 
				}
			}
		mysqli_close($conn);
		
	} else {
	
			// Get the turnover_id for the last Turnover created
				$sql = "SELECT MAX(turnover_id) FROM TB_TURNOVER";
				
				$result = $conn->query($sql);
				
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_row()) {
						$currentTurnover_id = $row[0];  // Create variable for the most recently opened turnover
					}
				} else {
					echo "No results";
				}

			// Get the Shift using the currentTurnover_id variable	
				$sql = "SELECT shift FROM TB_TURNOVER WHERE turnover_id='$currentTurnover_id'";
				
				$result = $conn->query($sql);
				
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_row()) {
						$currentShift = $row[0];
					}
				} else {
					echo "No results";
				}
			
			// Get the Date using the currentTurnover_id variable
				$sql = "SELECT `date` FROM TB_TURNOVER WHERE turnover_id='$currentTurnover_id'";
				
				$result = $conn->query($sql);
				
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_row()) {
						$currentDate = $row[0];
					}
				} else {
					echo "No results";
				}
					
			// Get the Technicians using the currentTurnover_id variable
				$sql = "SELECT tech_name, isoctechs_id FROM TB_TURNOVER_ISOCTECHS WHERE turnover_id='$currentTurnover_id'";
				$techs = array();
				
				if (mysqli_multi_query($conn,$sql)) {
					if ($result=mysqli_store_result($conn)) {
						while ($row=mysqli_fetch_assoc($result)) {
							$techs[] = $row;
						}
					}
						
				mysqli_free_result($conn);
				 if (mysqli_more_results($conn)) {
					mysqli_next_result($conn);
					} 
				}
				
			// Get the Turnover Items using the currentTurnover_id variable
				$sql = "SELECT turnover_item, item_id FROM TB_TURNOVER_ITEM WHERE TURNOVER_ID='$currentTurnover_id'";
				$t_items = array();

				if (mysqli_multi_query($conn,$sql)) {
					if ($result=mysqli_store_result($conn)) {
						while ($row=mysqli_fetch_assoc($result)) {
							$t_items[] = $row;
						}
					}
					
				mysqli_free_result($conn);
				 if (mysqli_more_results($conn)) {
					mysqli_next_result($conn);
					} 
				}
				
				mysqli_close($conn);
			}

	if (empty($turnover_id)) {
		
			if (!empty($searchShift) && empty($searchDate)) {
				die('Oops, Something went wrong.  A Shift and Date are required for Advanced Search. Try refreshing the page or go back to Search Turnover and select a Shift and Date.');
			}

			if (!empty($searchDate) && empty($searchShift)) {
				die('Oops, Something went wrong.  A Shift and Date are required for Advanced Search. Try refreshing the page or go back to Search Turnover and select a Shift and Date.');
			}

			if (empty($turnover_id) && empty($currentTurnover_id)) {
				$turnover_id = "";
				echo '<head>
						<title>ISOC VIEW TURNOVER</title>
						<link rel="stylesheet" type="text/css" href="css/turnoverStylesheet.css">
						<link rel="icon" type="image/png" href="http://10.176.105.22/img/8bmicon.png">
					</head>
							
					<div id="Header">
						<h1>ISOC Turnover</h1>
								
					<!-- Navigation Bar -->	
						<div class="nav">
							<ul>
								<li class="create"><a href="http://10.176.105.22/createTurnover.php">Create</a></li>
								<li class="search"><a href="http://10.176.105.22/searchTurnover.php">Search</a></li>
								<li class="edit"><a href="http://10.176.105.22/editTurnover.php">Edit</a></li>
								<li class="View"><a class="active" href="http://10.176.105.22/viewTurnover.php">View</a></li>
							</ul>
						</div>
						
					</div>';
				die ('<div id=noTurnoverFound><h1>Where are we? I\'m not sure this is right.</h1><p><img src="http://10.176.105.22/img/stewartHat.jpg"></p><p><h2>No Turnover exists for the criteria selected. Go back to Search and try again.</h2></p></div>');
			}
		}

?>
