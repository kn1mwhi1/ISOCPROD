<?php header("refresh:5; URL=searchTurnover.php"); // Redirects the browser after 5 seconds to the Search Turnover page ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<html>
<!-- Tag to inform IE to be smart -->
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>

<head>
	<title>Turnover Confirmation</title>
	<link rel="stylesheet" type="text/css" href="css/turnoverStylesheet.css">
	<link rel="icon" type="image/png" href="/img/8bmicon.png">
</head>

<body>

	<div id="Header">
		<h1>Great Success!</h1>
	</div>

	<div id="confMsg">
		<h2>Your Turnover was saved.</h2>
		<p>We are now attempting to re-direct you to a secret location.</p>
		<p>If we have failed at the modest task which was our charge, click this guy: </p>
			<div id=warpPipe>
			<a href="searchTurnover.php">
			<img src="/img/warp_pipe.gif"></a>
			</div>
		<p>to search for a turnover</p>
	</div>

</body>
</html>
