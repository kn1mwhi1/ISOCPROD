<?php 
require 'lib/fromDataBaseGetTurnover.php';
require 'lib/turnoverVariables.php';
if (empty($turnover_id)) {
	
} ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<html>
<!-- Tag to inform IE to be smart -->
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<head>
	<title>ISOC VIEW TURNOVER</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/turnoverStylesheet.css">
	
	
	
	<link rel="icon" type="image/png" href="img/8bmicon.png">
</head>

<!-- WRAPPING BODY IN DIV TO HELP PUSH FOOTER TO BOTTOM OF PAGE -->
<div class="wrapper">
	<body class="">

<?php
require_once 'lib/Class_LoginLogic.php'; 
$login = new LoginLogic();
// Check login first
$login->checkSession();

?>

<?php
$login->getNavBar();
?>	

		<div class="" id="Header">
			<h1 class="">ISOC Turnover</h1>
			
<!-- Navigation Bar -->	
			<div class="navigation ">
				<ul class="">
					<li class="create"><a href="createTurnover.php">Create</a></li>
					<li class="search"><a href="searchTurnover.php">Search</a></li>
					<li class="edit"><a href="editTurnover.php">Edit</a></li>
					<li class="View"><a class="active" href="viewTurnover.php">View</a></li>
				</ul>
			</div>
			
		</div>

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
			
		
		<div id="shift">
			<?php 
			if (!empty($searchShift)) {
				echo $searchShift.' Shift'; 
			} elseif (!empty($currentShift)) {
				echo $currentShift.' Shift';
			}
			?>
		
		</div>
		
		<div id="Date">
			<?php 
			if (!empty($searchDate)) {
				echo $searchDate;  echo '<br><br> Turnover ID: '.$turnover_id; 
			} elseif (!empty($currentDate)){
				echo $currentDate;  echo '<br><br> Turnover ID: '.$currentTurnover_id;
			}		
			?>

		</div>
		
		<div id="addTechnicians">
			<?php
				if (!empty($techs)) {
					echo 'Technicians:';
					for ($i=0; $i < count($techs); $i++) {
						echo '<br>'.$techs[$i]['tech_name'];
					}
				}
			?>

		</div>


		
		<div id="TurnoverContainer">
			<div id="TurnoverItemContainer">
				<div id="TurnoverItem">
					<h2>Turnover Items</h2>
						<?php
							if (!empty($t_items)) {
								for ($i = 0; $i < count($t_items); $i++){
									echo '<p><textarea class="turnOverItems" id="textbox" readonly>'.$t_items[$i]['turnover_item'].'</textarea></p>';
								}
							}
						?>
				</div>
			</div>
		</div>
		
	<script type="text/javascript" src="script/jquery-2.1.1.min.js"></script>
	<script src="script/turnover_eventlog.js"></script>	
	<script src="script/turnover.js"></script>	

	</body>
	
	
	
<!-- HIDDEN DIV TO PUSH FOOTER TO BOTTOM OF PAGE -->
		<div class="push">
			<footer>
				<p> Created by ISOC &copy;2015</p>
				<div class="img"><a href="img/ISOClogo.JPG"><img src="ISOClogo.JPG" alt=""></a></div>
			 </footer>
		</div>

</html>