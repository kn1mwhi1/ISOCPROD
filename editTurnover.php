<?php 
require 'lib/fromDataBaseGetTurnover.php'; 
require 'lib/fromDataBaseGetTechnicians.php'; 
?>
<?php
require_once 'lib/Class_LoginLogic.php'; 
$login = new LoginLogic();
// Check login first
$login->checkSession();

?>

<?php
$login->getNavBar();
?>

<!DOCTYPE html>
<html>
<head>
	<title>ISOC EDIT TURNOVER</title>
	
	<link rel="stylesheet" type="text/css" href="css/turnoverStylesheet.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
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
					<li class="create"><a href="createTurnover.php">Create</a></li>
					<li class="search"><a href="searchTurnover.php">Search</a></li>
					<li class="edit"><a class="active" href="editTurnover.php">Edit</a></li>
					<li class="View"><a href="viewTurnover.php">View</a></li>
				</ul>
			</div>
		</div>

	<form name="trnOver" method="POST" id="turnoverForm" action="toDataBaseEdit.php" onsubmit="return validateForm()">

		<div id="DateShiftContainer">
	
		<div id="Date">
			Open Date: <?php echo $currentDate;?>
			Turnover ID:<?php echo $currentTurnover_id; ?>
		
<!-- Adding a hidden text input to get value of the turnover id. Used to identify the correct row in DataBase -->
			<input type="hidden" name="turnover_id" value='<?php echo $currentTurnover_id; ?>'>
		</div>
	
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
			
<!-- Using <p> tags to align everything. Class is being used for jquery to identify the elements and id is the isoctechs_id from DB used to identify specific row. -->
		
			Technicians:
				<?php for ($i=0; $i < count($techs); $i++) { ?>
					<p class="oldTech" id="<?php echo $techs[$i]['isoctechs_id'];?>"> <input type="text" value="<?php echo $techs[$i]['tech_name'];?>" readonly> <input type="button" value="-" onclick="removeoldTech();"></p>
				<?php } ?>
			</div>
			
			<div id="newTech">
				Add Technicians: 
				<br>
				<br>
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
			
		</div>
		
<!-- Blank div for displaying validation errors -->		
		<div id="createTechnicianValidationError"></div>
		<div id="deleteTechnicianValidation"></div>
		
		<div id="EventLog">
			<p>The Event Log will go here</p>
		</div>
	
		<div id="itemContainer">
		<div id="addTurnover">
			<strong>Current Turnover Items<strong>

			<?php
				for ($i = 0; $i < count($t_items); $i++){ ?>
					<p class="oldTurnover" id="<?php echo $t_items[$i]['item_id'];?>"><textarea id="textbox" class"old_item" name="updateTurnover[]" maxlength="500"><?php echo $t_items[$i]['turnover_item'];?></textarea>
					<input type="button" value="Remove" onclick="removeoldTurnover()"></p>
					
					<input type="hidden" name="turnover_item[]" value="<?php echo $t_items[$i]['item_id'];?>">
			<?php	} ?>
	
			<div id="charNum"></div> 
			 
				<textarea placeholder="Please Enter Turnover Item" id="textbox" name="add_turnover" maxlength="500" data-autosize-input='{ "space": 40 }' tabindex="5"></textarea>
					
				<input onclick="addRow(this.form);" type="button" name="turnover" value="Add Item" tabindex="6"/>
		</div>
			
		</div>
		
<!-- Blank div for displaying validation errors -->
		<div id="createItemValidationError"></div>
		
		<div id="Submit">
			<p><input type="submit" name="ok" value="Submit" tabindex="7"></p>
		</div>

</form>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="script/turnover.js"></script>
<script src="script/editTurnover.js"></script>


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