<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<!-- Tag to inform IE to be smart -->
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<head>
	<title> ISOC SEARCH TURNOVER</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/turnoverStylesheet.css">
	<link type="text/css" rel="stylesheet" href="css/bootstrap-table.css">
	<link rel="icon" type="image/png" href="img/tardis.ico">
	
	<script type="text/javascript" src="script/jquery.js"></script>
	<script type="text/javascript" src="script/bootstrap-table.js"></script>

<?php 
// get data from last Turnover to display on Search Turnover page
	require 'lib/fromDataBaseGetTurnover.php';
?>
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
					<li class="create"><a  href="createTurnover.php">Create</a></li>
					<li class="search"><a class="active" href="searchTurnover.php">Search</a></li>
					<li class="edit"><a href="editTurnover.php">Edit</a></li>
					<li class="View"><a href="viewTurnover.php">View</a></li>
				</ul>
			</div>
		</div>

<div id="allDiv" class="center container ">

<!-- View/Edit Last Turnover -->
			<form name="currentTurnover" action="viewTurnover.php">
								
				<div class="center " id="searchTable" style="width:300px">
				
			<!-- Table to display the last Turnover ID, Shift and Date -->
					<table id="table" data-toggle="table" >
						<thead>
							<tr>
								<th>TURNOVER_ID</th>
								<th>Shift</th>
								<th>Date</th>
							</tr>
						</thead>
							<tbody>
								<td><?php echo $currentTurnover_id; ?></td>
								<td><?php echo $currentShift; ?></td>
								<td><?php echo $currentDate; ?></td>
							</tbody>
					</table>
					
				<!-- Form action used to redirect browser to view page  -->
					<input class="btn btn-primary" type="submit" value="View" tabindex="1">
					
				<!-- JavaScript location used to redirect browser to Edit page -->
					<input class="btn btn-primary" type="button" onclick="location.href='editTurnover.php';" value="Edit">
				</div>			
			</form>

<!-- Turnover Advanced Search -->
		<div class="center " id="advancedSearch" >
			 <form id="advanSearch" name="advancesearchTurnover" method="POST" action="viewTurnover.php" onsubmit="return validateForm()">
				 <fieldset class="center" >
					<legend class="" >Advanced Search</legend>
						<div class="" id="shift2">
							<input type="checkbox" name="shift-box" value="1st" class="shift" tabindex="9">1st Shift &nbsp &nbsp &nbsp &nbsp
							<input type="checkbox" name="shift-box" value="2nd" class="shift" tabindex="10">2nd Shift &nbsp &nbsp &nbsp &nbsp
							<input type="checkbox" name="shift-box" value="3rd" class="shift" tabindex="11">3rd Shift &nbsp &nbsp &nbsp &nbsp
						</div>
					
						<div class="" id="selectDateDiv" >
							<span class="pull-left" id="selectDate" >Select a Date:</span>
							<input class="form-control pull-left" type="date" id="advancedDate" value="" name="advancedDate" tabindex="12">
						</div>
					</fieldset>
				<input class="btn btn-primary" type="submit" value="Advanced Search" tabindex="13">
			 </form>
		 </div>
</div>

<!-- Blank div for displaying validation errors -->
	<div class="center" id="searchValidationError"></div>	  


<!-- JavaScript added to end of the page to aid in faster load times -->	
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