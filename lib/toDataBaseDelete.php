<?php
	require 'turnoverVariables.php';

	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " .mysqli_connect_error();

	}
	
// Begin code to delete Technicians and/or Turnover Items on demand through Edit Turnover Page

	if (isset ($_POST['oldTech']) && !empty($_POST['oldTech'])){

	$query = "DELETE FROM TB_TURNOVER_ISOCTECHS WHERE ISOCTECHS_ID='$oldTech';";
	
	mysqli_query($conn,$query);
	
	}
	
	if (isset ($_POST['oldTurnover']) && !empty($_POST['oldTurnover'])){
	
	$query = "DELETE FROM TB_TURNOVER_ITEM WHERE ITEM_ID = '$oldTurnover';";
	
	mysqli_query($conn,$query);
	
	}
	
// End code to delete Technicians and/or Turnover Items on demand through Edit Turnover Page
	
	mysqli_close($conn);
?>