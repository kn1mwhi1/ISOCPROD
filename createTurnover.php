<?php require 'lib/fromDataBaseGetTechnicians.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>ISOC CREATE TURNOVER</title>
	<link rel="stylesheet" type="text/css" href="css/turnoverStylesheet.css">
	<link rel="icon" type="image/png" href="img/8bmicon.png">
</head>

<!-- WRAPPING BODY IN DIV TO HELP PUSH FOOTER TO BOTTOM OF PAGE -->
<div class="wrapper">
	<body>

		<div id="Header">
			<h1>ISOC Turnover</h1>
		
<!-- Navigation Bar -->	
			<div class="nav">
				<ul>
					<li class="create"><a class="active" href="createTurnover.php">Create</a></li>
					<li class="search"><a href="searchTurnover.php">Search</a></li>
					<li class="edit"><a href="editTurnover.php">Edit</a></li>
					<li class="View"><a href="viewTurnover.php">View</a></li>
				</ul>
			</div>
		</div>
								
	<form name="trnOver" method="POST" id="turnoverForm" action="toDataBaseCreate.php" onsubmit="return validateForm()">

<!-- Date/Shift Container -->
		<div id="Shift">
			<select id="selShift" name="shift" tabindex="1">
				<option value="Select Shift" selected>Select Shift</option>
				<option value="1st">1st Shift</option>
				<option value="2nd">2nd Shift</option>
				<option value="3rd">3rd Shift</option>
			</select>			
		</div>
		
<!-- Blank div for displaying validation errors -->			
		<div id="createShiftValidationError"></div>
		
		<div id="Date">
			<?php require 'lib/turnoverVariables.php'; echo "Open Date: $date $time"; ?>
		</div>

		
		<div id="addTechnicians">
				<select id="selTech" name="add_Technician" tabindex="2"> 
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
					
			<input onclick="techRow(this.form);" type="button" id="selectedTech" name="technicians" value="+" tabindex="3"/>
		</div>
		
<!-- Blank div for displaying validation errors -->			
		<div id="createTechnicianValidationError"></div>
		
		<div id="EventLog">
			<p>The Event Log will go here</p>
		</div>
		
		<div id="itemContainer">
		
			<div id="charNum"></div>
			
			<div id="addTurnover">
					 
				<textarea placeholder="Please Enter Turnover Item" id="textbox" name="add_turnover" maxlength="500" data-autosize-input='{ "space": 40 }' tabindex="5"></textarea>
					
				<input onclick="addRow(this.form);" type="button" name="turnover" value="Add Item" tabindex="6"/>
			</div>
					
		</div>
		
<!-- Blank div for displaying validation errors -->					
		<div id="createItemValidationError"></div>
		
		<div id="Submit">
			<p><input type="submit" name="ok" value="Submit" tabindex="7" ></p>
		</div>
	</form>
	
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
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
</div>
</html>