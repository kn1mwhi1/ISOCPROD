<!DOCTYPE html>
<html>
<head>
	<title> ISOC SEARCH TURNOVER</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/turnoverStylesheet.css">
	<link rel="icon" type="image/png" href="img/tardis.ico">	


<?php require 'lib/fromDataBaseGetTurnover.php'; ?>	
</head>

<!-- WRAPPING BODY IN DIV TO HELP PUSH FOOTER TO BOTTOM OF PAGE -->
<div class="wrapper">
	<body>	
	
<?php
require_once 'lib/Class_LoginLogic.php'; 
$login = new LoginLogic();
// Check login first
$login->checkSession();

?>

<?php
$login->getNavBar();
?>
		<div id="Header">
			<h1>ISOC Search Turnover</h1>
			
<!-- Navigation Bar -->	
			<div class="navigation">
				<ul>
					<li class="create"><a href="createTurnover.php">Create</a></li>
					<li class="search"><a class="active" href="searchTurnover.php">Search</a></li>
					<li class="edit"><a href="editTurnover.php">Edit</a></li>
					<li class="View"><a href="viewTurnover.php">View</a></li>
				</ul>
			</div>
		</div>
			
		

<!-- This is displaying the last Turnover ID, Shift and Date in a table format and supplying a view button to see the entire Turnover. -->

			<form name="currentTurnover" action="viewTurnover.php">
				<div id="searchTable">
					<table border="1" style="width:20%">
						<tr>
							<th>TURNOVER_ID</th>
							<th>Shift</th>
							<th>Date</th>
						</tr>
							<td><?php echo $currentTurnover_id; ?></td>
							<td><?php echo $currentShift; ?></td>
							<td><?php echo $currentDate; ?></td>
					</table>
					<input type="submit" value="View" tabindex="1">
					<input type="button" onclick="location.href='editTurnover.php';" value="Edit">
				</div>			
			</form>

		<div id="advancedSearch" >
			 <form id="advanSearch" name="advancesearchTurnover" method="POST" action="viewTurnover.php" onsubmit="return validateForm()">
				 <fieldset>
					<legend>Advanced Search</legend>
						<div id="shift2">
							<input type="checkbox" name="shift-box" value="1st" class="shift" tabindex="9">1st Shift &nbsp &nbsp &nbsp &nbsp
							<input type="checkbox" name="shift-box" value="2nd" class="shift" tabindex="10">2nd Shift &nbsp &nbsp &nbsp &nbsp
							<input type="checkbox" name="shift-box" value="3rd" class="shift" tabindex="11">3rd Shift &nbsp &nbsp &nbsp &nbsp
						</div>
					
						<div id="selectDate">
							Select a Date: <input type="date" id="advancedDate" value="" name="advancedDate" tabindex="12">
						</div>
						
<!-- Blank div for displaying validation errors -->
						<div id="searchValidationError"></div>
					</fieldset>
				<input type="submit" value="Advanced Search" tabindex="13">
			 </form>
		 </div>
		  
		<script type="text/javascript" src="script/jquery-2.1.1.min.js"></script>
		<script src="script/turnover.js"></script>
		<script src="script/searchTurnover.js"></script>
	</body>
	
<!-- HIDDEN DIV TO PUSH FOOTER TO BOTTOM OF PAGE -->
		<div class="push">
			<footer>
				<p> Created by ISOC &copy;2015</p>
				<div class="img"><a href="img/ISOClogo.JPG"><img src="img/ISOClogo.JPG" alt=""></a></div>
			 </footer>
		</div>
</div>
</html>