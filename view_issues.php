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

//Connect to the database and set error mode to show exceptions
try {
	$db = new PDO('mysql:host=localhost;dbname=ISOCDB', 'isocdev', 'opsisfun11');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e) {
	echo $e->getMessage();
	die();
}

try {
  $results = $db->query('SELECT * FROM TB_ISSUE_TRACKING');
} catch(Exception $e){
  echo $e->getMessage();
  die();
}

$issues = $results->fetchAll(PDO::FETCH_ASSOC);

//Begin code for table

echo "<table>";
	echo "<tr>";
		echo "<th>Issue Number</th>";
		echo "<th>Submitted By</th>";
		echo "<th>Contact Email</th>";
		echo "<th>Page Where Issue Occurred</th>";
		echo "<th>Issue Resolved (Y/N)</th>";
		echo "<th>View</th>";
	echo "</tr>";
	
	foreach($issues as $issue) {
		echo "<tr>";
			echo '<td>'.$issue["ISSUE_ID"].'</td>';
			echo '<td>'.$issue["TECH_NAME"].'</td>';
			echo '<td>'.$issue["TECH_EMAIL"].'</td>';
			echo '<td>'.$issue["ISSUE_PAGE"].'</td>';
			echo '<td>'.$issue["ISSUE_RESOLVED"].'</td>';
			echo '<td>';
				echo '<a href="issue.php?id='.$issue["ISSUE_ID"].'">View</a>';
			echo '</td>';
		echo "</tr>";
		
	}
	
echo "</table>"

?>

</body>
</html>