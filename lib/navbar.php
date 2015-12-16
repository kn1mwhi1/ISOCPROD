<?php 
require_once 'Class_LoginLogic.php'; 
$TierTwo = new LoginLogic();
//print_r($_SESSION);
?>

<!-- Gray Example


<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">I.S. Operations</a>
    </div>
    <div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="dashboard.php">Dashboard</a></li>
        <li><a href="requestformresponse.php">Request Response Form</a></li>
        <li><a href="eventlog.php">Event Log</a></li>
        <li><a href="login.php">Login Page</a></li>
      </ul>
    </div>
  </div>
</nav> -->


<!--  Color black example:   -->
<nav class="navbar navbar-inverse navbarCustom ">
  <div class="container-fluid " >
    <div class="navbar-header ">
     <a class="navbar-brand active" href="index.php" tabindex="-1">I.S. Operations</a>
    </div>
    <div>
      <ul class="nav navbar-nav" tabindex="-1">
        <li class="active"><a href="dashboard.php" tabindex="-1">Dashboard</a></li>
        <li><a href="requestformresponse.php" tabindex="-1">Request Response Form</a></li>
		<li><a href="createTurnover.php" tabindex="-1">Turnover</a></li>
        <li><a href="eventlog.php" tabindex="-1">Event Log</a></li>
		<li><a href="shiftlog.php" tabindex="-1">Shift Log</a></li>
      </ul>
	  
	   <ul class="nav navbar-nav pull-right" tabindex="-1">
		
		<?php $TierTwo->loggedInAs(); ?>

      </ul>
    </div>
  </div>
</nav>