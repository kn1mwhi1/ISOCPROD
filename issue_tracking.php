<?php 

//Connect to the database and set error mode to show exceptions
try {
	$db = new PDO('mysql:host=localhost;dbname=ISOCDB', 'isocdev', 'opsisfun11');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e) {
	echo $e->getMessage();
	die();
}

?>

<!-- Below Code Only Executes If Request Method Is Post -->

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$name = $_POST["name"];
$email = $_POST["email"];
$page = $_POST["page"];
$issue = $_POST["issue"];
$recreate = $_POST["recreate"];

try {
	$sql = "INSERT INTO TB_ISSUE_TRACKING (TECH_NAME, TECH_EMAIL, ISSUE_PAGE, ISSUE_DESCRIPTION, ISSUE_RECREATE, ISSUE_RESOLVED) VALUES ('$name', '$email', '$page', '$issue', '$recreate', 'N' )";
	$db->exec($sql);
} catch(Exception $e) {
	echo $e->getMessage();
	die();
}

header("Location: issue_tracking.php?status=confirm");
exit;
}

?>

<!-- Above Code Only Executes If Request Method Is Post -->

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
	if (isset($_GET["status"]) AND $_GET["status"] == "confirm") { ?>
		
		<p id="confirm">Thanks for your reporting your issue. We may reach out to you with further questions.</p>
		
	<?php		
	}
	
	else {
?>

<form method="post" name="issue_tracking_form" action="issue_tracking.php">

<div id="trackingForm">
<p class="trackingTextStyle">Name:</p> <input type="text" name="name" id="trackingName" tabindex="1">

<p class="trackingTextStyle">Email Address:</p> <input type="email" name="email" id="trackingEmail" tabindex="2">

<p class="trackingTextStyle">Page Where Issue Occurred:</p> <input type="text" name="page" id="trackingPage" tabindex="3">

<p class="trackingTextStyle">Bug/Problem/Issue:</p> <textarea name="issue" id="trackingIssue" maxlength="750" tabindex="4"></textarea>

<p class="trackingTextStyle">Steps To Recreate The Issue:</p> <textarea name="recreate" id="trackingRecreate"maxlength="1500" tabindex="5"></textarea>

<div id="trackingSubmitStyle">
<input type="submit" value="Send" id="trackingSubmit" tabindex="6">
</div>

</form>

</body>

	<?php } ?>

</html>
