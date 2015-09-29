<?php 
require 'fromDataBaseGetTurnover.php';
require 'turnoverVariables.php';
if (empty($turnover_id)) {
	
} ?>

<!DOCTYPE html>
<html>
<head>
	<title>ISOC VIEW TURNOVER</title>
	<link rel="stylesheet" type="text/css" href="css/turnoverStylesheet.css">
	<link rel="icon" type="image/png" href="http://10.176.105.22/img/8bmicon.png">
</head>

<!-- WRAPPING BODY IN DIV TO HELP PUSH FOOTER TO BOTTOM OF PAGE -->
<div class="wrapper">
	<body>	

		<div id="Header">
			<h1>ISOC Turnover</h1>
			
<!-- Navigation Bar -->	
			<div class="nav">
				<ul>
					<li class="create"><a href="http://10.176.105.22/createTurnover.php">Create</a></li>
					<li class="search"><a href="http://10.176.105.22/searchTurnover.php">Search</a></li>
					<li class="edit"><a href="http://10.176.105.22/editTurnover.php">Edit</a></li>
					<li class="View"><a class="active" href="http://10.176.105.22/viewTurnover.php">View</a></li>
				</ul>
			</div>
			
		</div>

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

		<div id="EventLog">
			<p>The Event Log will go here</p>
		</div>
		
		<div id="TurnoverContainer">
			<div id="TurnoverItemContainer">
				<div id="TurnoverItem">
					<h2>Turnover Items</h2>
						<?php
							if (!empty($t_items)) {
								for ($i = 0; $i < count($t_items); $i++){
									echo '<p><textarea id="textbox" readonly>'.$t_items[$i]['turnover_item'].'</textarea></p>';
								}
							}
						?>
				</div>
			</div>
		</div>
		
	</body>
	
<!-- HIDDEN DIV TO PUSH FOOTER TO BOTTOM OF PAGE -->
		<div class="push">
			<footer>
				<p> Created by ISOC &copy;2015</p>
				<div class="img"><a href="http://10.176.105.22/img/ISOClogo.JPG"><img src="http://10.176.105.22/img/ISOClogo.JPG" alt=""></a></div>
			 </footer>
		</div>
</div>
</html>