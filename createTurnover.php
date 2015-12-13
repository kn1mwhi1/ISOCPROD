<?php require 'lib/fromDataBaseGetTechnicians.php'; // Page is required to populate Technicians drop-down menu ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<!-- Tag to inform IE to be smart -->
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>



<head>
	<title>ISOC CREATE TURNOVER</title>
	
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" /> 
		<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" /> 
		<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.css" />
		<link rel="stylesheet" type="text/css" href="css/SupportRequestForm.css" /> 
		<link rel="stylesheet" type="text/css" href="css/sweetalert.css" />	
		<link rel="stylesheet" type="text/css" href="css/eventlog.css" />
	    <link rel="stylesheet" type="text/css" href="css/turnoverStylesheet.css">
	
	    <link rel="icon" type="image/png" href="img/8bmicon.png">
		

<?php
require_once 'lib/Class_LoginLogic.php'; 
require_once 'lib/Class_Event_Logic.php';
$login = new LoginLogic();
$tierTwo = new Event_Logic();

// Check login first
$login->checkSession();
?>
</head>

<body>
	
<?php
// Check login first
$login->checkSession();
?>

<?php
$login->getNavBar();
?>

		
		<div id="Header">
			<h1>ISOC Turnover</h1>
		
<!-- Navigation Bar -->	
			<div class="navigation">
				<ul>
					<li class="create"><a class="active" href="createTurnover.php">Create</a></li>
					<li class="search"><a href="searchTurnover.php">Search</a></li>
					<li class="edit"><a href="editTurnover.php">Edit</a></li>
					<li class="View"><a href="viewTurnover.php">View</a></li>
				</ul>
			</div>
		</div>

<!-- Begin Form to capture user input. When submitted a JavaScript function validates the data and is sent to the DB -->		
	<form class="" name="trnOver" method="POST" id="turnoverForm" action="lib/toDataBaseCreate.php" onsubmit="return validateForm()">

<!-- Date/Shift Container -->
		<div class="pull-left"id="Shift">
			<select class="form-control" id="selShift" name="shift" tabindex="1">
				<option value="Select Shift" selected>Select Shift</option>
				<option value="1st">1st Shift</option>
				<option value="2nd">2nd Shift</option>
				<option value="3rd">3rd Shift</option>
			</select>			
		</div>
		
		<div class="" id="addTechnicians">
		
<!-- + button used to call JavaScript function to add selected Technicians to Turnover -->
		<input class="btn btn-primary pull-right" onclick="techRow(this.form);" type="button" id="selectedTech" name="technicians" value="+" tabindex="3"/>
		
<!-- Use PHP to loop through all Technicians by Shift, concatenate First/Last Names and then echo out the results into each of the select statement option value and display property -->
		
				<select class="form-control pull-right" id="selTech" name="add_Technician" tabindex="2"> 
					<option value="Select Technician">Select Technician</option>
					<optgroup label="1st Shift">
			<?php 	for ($c=0; $c < count($firstShiftTechs); $c++) {
						$firstShift = $firstShiftTechs[$c]['isoc_tech_first_name'].' '.$firstShiftTechs[$c]['isoc_tech_last_name']; ?>
					<option value="<?php echo $firstShift;?>"><?php echo $firstShift;?></option>
			<?php }  ?>
					<optgroup label="2nd Shift">
			<?php 	for ($c=0; $c < count($secondShiftTechs); $c++) {
						$secondShift = $secondShiftTechs[$c]['isoc_tech_first_name'].' '.$secondShiftTechs[$c]['isoc_tech_last_name']; ?>
					<option value="<?php echo $secondShift;?>"><?php echo $secondShift;?></option>
			<?php }  ?>
					<optgroup label="3rd Shift">
			<?php 	for ($c=0; $c < count($thirdShiftTechs); $c++) {
						$thirdShift = $thirdShiftTechs[$c]['isoc_tech_first_name'].' '.$thirdShiftTechs[$c]['isoc_tech_last_name']; ?>
					<option value="<?php echo $thirdShift;?>"><?php echo $thirdShift;?></option>
			<?php }  ?>
					<optgroup label="Cross Shift">
			<?php 	for ($c=0; $c < count($crossShiftTechs); $c++) {
						$crossShift = $crossShiftTechs[$c]['isoc_tech_first_name'].' '.$crossShiftTechs[$c]['isoc_tech_last_name']; ?>
					<option value="<?php echo $crossShift;?>"><?php echo $crossShift;?></option>
			<?php }  ?>
				</select>
					
		</div>
	
		<!-- Blank div for displaying validation errors -->			
		
		<div class="" id="createShiftValidationError"></div>
	
	
		<div class ="" id="Date">
			<?php 
			// Displaying current time and date using PHP
				require 'lib/turnoverVariables.php'; 
				echo "Open Date: $date $time"; 
			?>
		</div>

		
<!-- Blank div for displaying validation errors -->			
		<div class="" id="createTechnicianValidationError"></div>
	
<!-- Moves down the EventLog when Select Technicians are added -->
	<div class="clearBoth"></div>

<!-- Ninja icon, used to hide or show div container for Event/Shift Log using JavaScript and CSS -->	
	<div id="hideEventShiftLog"> <img src="/img/ninja.png" id="hideEventLog"> <p class="ninjaHideShow"> Ninja Hide! </p> <p class="ninjaHideShow" id="ninjaHide"> Ninja Show! </p></div>

<!--  **************************  EVENT and SHIFT LOG ****************************************   -->
	<div class="eventShiftLog container-fluid greyBorder">
	
		<h1 class="pull-left" id="eventLogTitle">Event Log</h1>
		<h1 class="pull-right" id="shiftLogTitle">Shift Log</h1>
	
		<div class="clearLeft pull-left container-fluid pull-left eventTableSize" >			
				<div class=" fontSizeVariant" id="dynamicTable"  ></div>
		</div>
		
		
		<div class="clearRight pull-right container-fluid eventTableSize " >	
			
			<div class="fontSizeVariant" id="shiftLog"  >
		</div>
		
		</div>
	</div>
<!--  **************************  END of EVENT and SHIFT LOG ****************************************   -->
		

		<div id="itemContainer">
		
		<!-- Blank div to hold character remaining counter for Turnover Items -->
			<div class="" id="charNum"></div>
			
			<div class="" id="addTurnover">
		
		<!-- Turnover Item box -->
				<textarea class="form-control pull-left" placeholder="Please Enter Turnover Item" id="textbox" name="add_turnover" maxlength="500" data-autosize-input='{ "space": 40 }' tabindex="5"></textarea>
			
		<!-- Add Item button used to call JavaScript function to add Turnover Items to Turnover -->
				<input class="btn btn-primary" id="addItem" onclick="addRow(this.form);" type="button" name="turnover" value="Add Item" tabindex="6"/>
			</div>
					
		</div>
		
<!-- Blank div for displaying validation errors -->					
		<div id="createItemValidationError"></div>
		
		<div class="clearBoth" id="Submit">
			<p><input class="btn btn-primary " type="submit" name="ok" value="Submit" tabindex="7" ></p>
		</div>
	</form>

<!-- JavaScript added to end of the page to aid in faster load times -->
	<script type="text/javascript" src="script/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="script/bootstrap.min.js"></script>
	<script type="text/javascript" src="script/moment-with-locales.js"></script>
	<script type="text/javascript" src="script/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="script/getdatetime.js"></script>
	<script src="script/turnover.js"></script>
	<script src="script/createTurnover.js"></script>
	
	</body>
	
<!-- HIDDEN DIV TO PUSH FOOTER TO BOTTOM OF PAGE -->
		<div class="push">
			<footer>
				<p> Created by ISOC &copy;2015</p>
				<div class="img"><a href="img/ISOClogo.JPG"><img src="img/ISOClogo.JPG" alt=""></a></div>
			 </footer>
		</div>

</html>