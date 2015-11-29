<?php 

	/****************************************************
	* Variables used in multiple Turnover related pages *
	*****************************************************/

	// Create variable for the current date with mm/dd/yyyy format
		$date = date("m/d/Y");
		
	// Create variable for yesterday's date (24 hours in the past) with mm/dd/yyyy format
		$yesterday = date("m/d/Y", time() - 60 * 60 * 24);
		
	// Create variable for the current Time using a 24 hour clock followed by Time Zone of the server
		$time = date("H:i T");

	// Validate a Shift was added to POST, used in toDataBaseCreate.php and toDataBaseEdit.php
		if (isset ($_POST['shift']) && !empty($_POST['shift'])){
		
	// Create variable for Shift from POST data, this is an array
			$shift = $_POST['shift'];
		}

	// Validate a Technician was added to POST, used in toDataBaseCreate.php and toDataBaseEdit.php
		if (isset ($_POST['technicians']) && !empty($_POST['technicians'])){
		
	// Create variable for Technicians from POST data and removes any duplicates, this is an array
			$selection = array_unique($_POST['technicians']);
		}

	// Validate Turnover Items were added to POST, used in toDataBaseCreate.php and toDataBaseEdit.php
		if (isset ($_POST['turnover']) && !empty($_POST['turnover'])){
	
	// Create variable for Turnover Items from POST data, this is an array
			$turnover = $_POST['turnover'];
		}
		
	// Create variable for default Turnover Item value when none are added, used in toDataBaseCreate.php only
		else {
			$turnover = "No Turnover Items";
		}

	// Validate Technicians exist in POST data, used in toDataBaseDelete to identify the row in the DB to be removed
		if (isset ($_POST['oldTech']) && !empty($_POST['oldTech'])){
		
	// Create variable for Existing Technicians, this is an array
			$oldTech = $_POST['oldTech'];
		}

	// Validate Turnover Items exist in POST data, used in toDataBaseDelete to identify the row in the DB to be removed
		if (isset ($_POST['oldTurnover']) && !empty($_POST['oldTurnover'])){
		
	// Create variable for Existing Turnover Items, this is an array
			$oldTurnover = $_POST['oldTurnover'];
		}

	// Validate the Turnover ID exists in POST data, used in toDataBaseEdit.php to identify the row in the DB to be edited
		if (isset ($_POST['turnover_id']) && !empty($_POST['turnover_id'])){
		
	// Create variable for Turnover ID, this is an array
			$turnover_id = $_POST['turnover_id'];
		}

	// Validate a Turnover Item was added to POST, used in toDataBaseEdit.php and editTurnover.js
		if (isset ($_POST['newTurnover']) && !empty($_POST['newTurnover'])){
	
	// Create variable for New Turnover Items added in Edit Turnover page
			$newTurnover = $_POST['newTurnover'];
		}

	// Validate updated Turnover Items exist in POST, used in toDataBaseEdit.php and editTurnover.php
		if (isset ($_POST['updateTurnover']) && !empty($_POST['updateTurnover'])){
		
	// Create variable for Turnover Items updated in the Edit Turnover page
			$updateTurnover = $_POST['updateTurnover'];
		}

	// Create variables for DB connection
		$servername = "localhost";
		$username = "isocdev";
		$password = "opsisfun11";
		$dbname = "ISOCDB";
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		
		
/*********************************************************************************************************************
* Not sure this variable is being used anymore $_POST['turnover_item']. Need to test without it in Test environment. *
**********************************************************************************************************************
	// Validate Turnover ID exists
	Check if the Turnover Item is set and if so set variable with the value (used in editTurnover.php to display existing Turnover Items)
		if (isset ($_POST['turnover_item']) && !empty($_POST['turnover_item'])){
		
	// Create variable for Turnover ID
			$turnover_item = $_POST['turnover_item'];
		}
*/
?>