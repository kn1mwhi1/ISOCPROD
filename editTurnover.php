<?php // required DB code to retrieve Turnover from DB
require 'lib/fromDataBaseGetTurnover.php'; 
require 'lib/fromDataBaseGetTechnicians.php'; 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<!-- Tag to inform IE to be smart -->
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<head>
	<title>ISOC EDIT TURNOVER</title>
	
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" /> 
		<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" /> 
		<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.css" />
		<link rel="stylesheet" type="text/css" href="css/SupportRequestForm.css" /> 
		<link rel="stylesheet" type="text/css" href="css/sweetalert.css" />	
		<link rel="stylesheet" type="text/css" href="css/eventlog.css" />
	    <link rel="stylesheet" type="text/css" href="css/turnoverStylesheet.css">
		
		
	<link rel="icon" type="image/png" href="img/8bmicon.png">
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
			<h1>ISOC Turnover</h1>
			
<!-- Navigation Bar -->	
			<div class="navigation">
				<ul>
					<li class="create"><a href="createTurnover.php">Create</a></li>
					<li class="search"><a href="searchTurnover.php">Search</a></li>
					<li class="edit"><a class="active" href="editTurnover.php">Edit</a></li>
					<li class="View"><a href="viewTurnover.php">View</a></li>
				</ul>
			</div>
		</div>

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
		
		<div class="clearBoth"></div>
		
<!-- Begin Form to capture user input. When submitted a JavaScript function validates the data and is sent to the DB -->		
	<form name="trnOver" method="POST" id="turnoverForm" action="/lib/toDataBaseEdit.php" onsubmit="return validateForm()">

		<div id="DateShiftContainer">
	
		<div id="Date">
			Open Date: <?php echo $currentDate;?>
			Turnover ID:<?php echo $currentTurnover_id; ?>
		
<!-- Hidden text input to get value of the turnover id. Used to identify the correct row in DataBase -->
			<input type="hidden" name="turnover_id" value='<?php echo $currentTurnover_id; ?>'>
		</div>

<!-- Using PHP to set the selected attribute for the Select Option on the Shift retrieved from the DB database. This enables the drop-down to display the correct shift. -->	
		<div id="Shift">
		Select a New Shift 
			<select name="shift" tabindex="1">
				<option <?php if ($currentShift == '1st') {echo 'selected';} ?> value="1st">1st Shift</option>
				<option <?php if ($currentShift == '2nd') {echo 'selected';} ?> value="2nd">2nd Shift</option>
				<option <?php if ($currentShift == '3rd') {echo 'selected';} ?> value="3rd">3rd Shift</option>
			</select>			
		</div>
	
		</div>
	
		<div id="addTechnicians">
			<div id="oldTech">
			
<!-- Using <p> tags to align everything. Class is being used for jQuery to identify the elements and id is the isoctechs_id from DB used to identify specific row. -->
		
			Technicians:
				<?php for ($i=0; $i < count($techs); $i++) { ?>
					<p class="oldTech" id="<?php echo $techs[$i]['isoctechs_id'];?>"> <input type="text" value="<?php echo $techs[$i]['tech_name'];?>" readonly> <input type="button" value="-" onclick="removeoldTech();"></p>
				<?php } ?>
			</div>
			
			<div id="newTech">
				Add Technicians: 
				<br>
				<br>
				
		<!-- Use PHP to loop through all Technicians by Shift, concatenate First/Last Names and then echo out the results into each of the select statement option value and display property -->
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
					
		<!-- + button used to call JavaScript function to add selected Technicians to Turnover -->			
				<input onclick="techRow(this.form);" type="button" id="selectedTech" name="technicians" value="+" tabindex="3"/>						
			</div>
			
		</div>
		
<!-- Blank div for displaying validation errors -->		
		<div id="createTechnicianValidationError"></div>
		<div id="deleteTechnicianValidation"></div>



		<div id="itemContainer">
		<div id="addTurnover">
			<strong>Current Turnover Items<strong>

	<?php	
		/* ****************************************************************************************
		* Count total Turnover Items and loop through them creating HTML and content for display. *
		* The $t_items[$i]['item_id'] being echoed in the <p> id is the Primary Key in the DB for *
		* for Turnover Items.  It is being used here to identify each Turnover Item uniquely so   *
		* it can be updated or deleted.  The $t_items[$i]['turnover_item'] being echoed out in    *
		* the <textarea> is the actual Turnover Item.  The PHP is being separated from the HTML,  *
		* the close curly brace is found below the HTML.                                          *
		*******************************************************************************************/

		for ($i = 0; $i < count($t_items); $i++){ 
	?>
		<p class="oldTurnover" id="<?php echo $t_items[$i]['item_id'];?>">

		<textarea id="textbox" class"old_item" name="updateTurnover[]" maxlength="500"><?php echo $t_items[$i]['turnover_item'];?></textarea>

		<input type="button" value="Remove" onclick="removeoldTurnover()"></p>

<!-- This hidden input may no longer be needed. Further testing is needed before removing.  It is echoing the value of the Turnover Item's Turnover ID which is also being put in the <p> tag above. -->

	<input type="hidden" name="turnover_item[]" value="<?php echo $t_items[$i]['item_id'];?>">

	<?php	
	// Closing curly brace the PHP being used to display Turnover Items above
		} 
	?>
	
		<!-- Blank div for displaying Text Counter -->
			<div id="charNum"></div> 
			
		<!-- Turnover Items Box -->	
				<textarea placeholder="Please Enter Turnover Item" id="textbox" name="add_turnover" maxlength="500" data-autosize-input='{ "space": 40 }' tabindex="5"></textarea>
		
		<!-- Add Item button used to call JavaScript function to add Turnover Items to Turnover -->
				<input onclick="addRow(this.form);" type="button" name="turnover" value="Add Item" tabindex="6"/>
		</div>
			
		</div>
		
<!-- Blank div for displaying validation errors -->
		<div id="createItemValidationError"></div>
		
		<div id="Submit">
			<p><input type="submit" name="ok" value="Submit" tabindex="7"></p>
		</div>

</form>

<!-- JavaScript added to end of the page to aid in faster load times -->
	<script type="text/javascript" src="script/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="script/bootstrap.min.js"></script>
	<script type="text/javascript" src="script/moment-with-locales.js"></script>
	<script type="text/javascript" src="script/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="script/getdatetime.js"></script>
<script src="script/turnover.js"></script>
<script src="script/editTurnover.js"></script>
	

	</body>
	
<!-- HIDDEN DIV TO PUSH FOOTER TO BOTTOM OF PAGE -->
		<div class="footer">
			<footer>
				<p> Created by ISOC &copy;2015</p>
				<div class="img"><a href="img/ISOClogo.JPG"><img src="img/ISOClogo.JPG" alt=""></a></div>
			 </footer>
		</div>

</html>