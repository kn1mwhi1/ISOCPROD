<?php
require_once 'lib/Class_LoginLogic.php'; 
$login = new LoginLogic();
// Check login first
$login->checkSession();

?>

<?php
$login->getNavBar();
?>	

<html>
<head>
<title>ISOC VIEW TURNOVER</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/turnoverStylesheet.css">
<link rel="icon" type="image/png" href="img/8bmicon.png">
</head>
		
<body>			
<div id="Header">
	<h1>ISOC Turnover</h1>
								
		<!-- Navigation Bar -->	
		<div class="navigation">
			<ul>
				<li class="create"><a href="createTurnover.php">Create</a></li>
				<li class="search"><a href="searchTurnover.php">Search</a></li>
				<li class="edit"><a href="editTurnover.php">Edit</a></li>
				<li class="View"><a class="active" href="viewTurnover.php">View</a></li>
			</ul>
		</div>
						
		</div>
	<div id="noTurnoverFound">
		<h1>Where are we? I'm not sure this is right.</h1>
			<p><img src="img/stewartHat.jpg"></p>
			<p><h2>No Turnover exists for the criteria selected. Go back to Search and try again.</h2></p></div>';
						
</body>
</html>