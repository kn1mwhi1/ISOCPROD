<?php 

$select_shift = "Select Shift";
$person = "Select Technician";

$date = date("m/d/Y");
$yesterday = date("m/d/Y", time() - 60 * 60 * 24);
$time = date("H:i T");


if (isset ($_POST['shift']) && !empty($_POST['shift'])){
	$shift = $_POST['shift'];
}

if (isset ($_POST['technicians']) && !empty($_POST['technicians'])){
	$selection = array_unique($_POST['technicians']);
}

if (isset ($_POST['turnover']) && !empty($_POST['turnover'])){
	$turnover = $_POST['turnover'];
} else {
	$turnover = "No Turnover Items";
}

if (isset ($_POST['oldTech']) && !empty($_POST['oldTech'])){
	$oldTech = $_POST['oldTech'];
}

if (isset ($_POST['oldTurnover']) && !empty($_POST['oldTurnover'])){
	$oldTurnover = $_POST['oldTurnover'];
}

if (isset ($_POST['turnover_id']) && !empty($_POST['turnover_id'])){
	$turnover_id = $_POST['turnover_id'];
}

if (isset ($_POST['turnover_item']) && !empty($_POST['turnover_item'])){
	$turnover_item = $_POST['turnover_item'];
}

if (isset ($_POST['newTurnover']) && !empty($_POST['newTurnover'])){
	$newTurnover = $_POST['newTurnover'];
}

if (isset ($_POST['updateTurnover']) && !empty($_POST['updateTurnover'])){
	$updateTurnover = $_POST['updateTurnover'];
}




	



$servername = "localhost";
$username = "isocdev";
$password = "opsisfun11";
$dbname = "ISOCDB";
$conn = mysqli_connect($servername, $username, $password, $dbname);
?>