<?php  require 'turnoverVariables.php';

// Connecting to the Database
	if ($conn->connect_error) {
		die("Failed to connect to MySQL: " . $conn->connect_error);
	}

	

// Get first shift technicians	
	$sql = "SELECT isoc_tech_first_name, isoc_tech_last_name FROM TB_ISOC_TECHS WHERE isoc_tech_shift='1'";
	
	$result = $conn->query($sql);
	$firstShiftTechs = array();
	
	if (mysqli_multi_query($conn,$sql)) {
		if ($result=mysqli_store_result($conn)) {
			while ($row=mysqli_fetch_assoc($result)) {
				$firstShiftTechs[] = $row;
			}
		}
			
	mysqli_free_result($conn);
	 if (mysqli_more_results($conn)) {
		mysqli_next_result($conn);
		} 
	}
			
// Get first second shift technicians	
	$sql = "SELECT isoc_tech_first_name, isoc_tech_last_name FROM TB_ISOC_TECHS WHERE isoc_tech_shift='2'";
	$secondShiftTechs = array();
	
	if (mysqli_multi_query($conn,$sql)) {
		if ($result=mysqli_store_result($conn)) {
			while ($row=mysqli_fetch_assoc($result)) {
				$secondShiftTechs[] = $row;
			}
		}
			
	mysqli_free_result($conn);
	 if (mysqli_more_results($conn)) {
		mysqli_next_result($conn);
		} 
	}

// Get third shift technicians	
	$sql = "SELECT isoc_tech_first_name, isoc_tech_last_name FROM TB_ISOC_TECHS WHERE isoc_tech_shift='3'";
	$thirdShiftTechs = array();
	
	if (mysqli_multi_query($conn,$sql)) {
		if ($result=mysqli_store_result($conn)) {
			while ($row=mysqli_fetch_assoc($result)) {
				$thirdShiftTechs[] = $row;
			}
		}
			
	mysqli_free_result($conn);
	 if (mysqli_more_results($conn)) {
		mysqli_next_result($conn);
		} 
	}
		
			
// Get cross shift technicians	
	$sql = "SELECT isoc_tech_first_name, isoc_tech_last_name FROM TB_ISOC_TECHS WHERE isoc_tech_shift='CS'";
	$crossShiftTechs = array();
	
	if (mysqli_multi_query($conn,$sql)) {
		if ($result=mysqli_store_result($conn)) {
			while ($row=mysqli_fetch_assoc($result)) {
				$crossShiftTechs[] = $row;
			}
		}
			
	mysqli_free_result($conn);
	 if (mysqli_more_results($conn)) {
		mysqli_next_result($conn);
		} 
	}
	
// Close the database connection			
	mysqli_close($conn);
	
?>