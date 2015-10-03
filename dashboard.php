<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	
	<title>ISOC DASHBOARD</title>
    
	<link rel="stylesheet" type="text/css" href="css/turnoverStylesheet.css">
	<link rel="icon" type="image/png" href="/img/8bmicon.png">
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	
	

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	
<?php

require('lib/Class_LoginLogic.php');


$Login = new LoginLogic();
$Login->checkSession();


?>	

</head>

<body>

<?php
$Login->getNavBar();
?>

	
	<div class="header moveup">
		<h1>ISOC Dashboard</h1>	
	</div>

	<div class="isoc_stats">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title">ISOC Stats</h3>
		  </div>
		  <div class="panel-body">
			<p>Average Response Time: </p>
			<p>Total Requests: </p>
		  </div>
		</div>
	</div>
	
	<div id="nav_container">
		<div class="row">
			<div class="call_tracker_nav">
				<div class="col-md-6"><button type="button"class="button-group btn-group-justified" role="group" onclick="location.href='ShiftLogindex.php';">Shift Log</button></div>
			</div>
				
			<div class="event_log_nav">
				<div class="col-md-6"><button type="button"class="button-group btn-group-justified" role="group" onclick="location.href='eventlog.php';">Event Log</button></div>
			</div>
				
			<div class="turnover_nav">
				<div class="col-md-6"><button type="button"class="button-group btn-group-justified" role="group" onclick="location.href='createTurnover.php';">Turnover</button></div>
			</div>
				
			<div class="request_response_form_nav">
				<div class="col-md-6"><button type="button"class="button-group btn-group-justified" role="group" onclick="location.href='supportrequestform.php';">Request Form</button></div>
			</div>
		</div>
	</div>
		
</body>

</html>
