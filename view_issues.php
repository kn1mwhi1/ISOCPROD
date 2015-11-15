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

echo "<ul>";
foreach($issues as $issue){
	echo '<li><a href="films.php?id='.$issue["ISSUE_ID"].'"> '.$issue["ISSUE_ID"].' '.$issue["TECH_NAME"].' '.$issue["TECH_EMAIL"].' '.$issue["ISSUE_PAGE"].' '.$issue["ISSUE_RESOLVED"].'</li>';
}
echo "</ul>";

?>