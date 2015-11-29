<!DOCTYPE html>

<html>

<head>
<title>ISOC Initiative Issue Tracking</title>
<link rel="stylesheet" type="text/css" href="css/issue_stylesheet.css">
</head>

<body>

<div id="trackingHeader">
<!--<h1 style="color:red">THIS IS NOT YET OPERATIONAL</h1>
<h1 style="color:red">FOR IMMEDIATE ASSISTANCE, PLEASE DIAL:</h1>
<h1 style="color:red">865-777-8771</h1>-->
<h1>ISOC Initiative Issue Tracking</h1>
</div>

<?php 

if(!empty($_GET['id'])) {
	$issue_id = $_GET['id'];
}

//Connect to the database and set error mode to show exceptions
try {
	$db = new PDO('mysql:host=localhost;dbname=ISOCDB', 'isocdev', 'opsisfun11');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e) {
	echo $e->getMessage();
	die();
}

try {
  $results = $db->query('SELECT * FROM TB_ISSUE_TRACKING WHERE ISSUE_ID = '.$issue_id);
} catch(Exception $e){
  echo $e->getMessage();
  die();
}

$issue = $results->fetch(PDO::FETCH_ASSOC);

echo $issue['ISSUE_ID']; 

?>

</body>
</html>