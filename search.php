<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Search Shift Log</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="robots" content="index,follow" />
	
	<!--  Load CSS -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="css/alt.css" />
	
	<!-- Load Javascript -->
	<script type="text/javascript" src="script/bootstrap.js"></script>
	<script type="text/javascript" src="script/jquery.js"></script>
	<script type="text/javascript" src="script/bootstrap.min.js"></script>
	<script type="text/javascript" src="script/table.js"></script>
	
	
	<div class="navbar navbar-default navbar-top">
    <div class="container">
	<div>
	  <ul class="nav navbar-nav navbar-right">
	  <button onclick="search()" class="navbar-btn btn-default btn">Search</button>
	  
	  </div>
	  
      <button onclick="goBack()"class="navbar-btn btn-default btn">Go Back</button>
	<script>
	function goBack() {
    window.history.back();
	}
	</script>
	  
    </div>
</div>
	
    <div class= "form-group" "form-control" >
	
	</div>
	
	<div class= "header">
	<h1 class="text-center">History</h1>
</div>

</head>

<body>
<div class="container">
    <div class="row clearfix">
    	<div class="col-md-12 table-responsive">
			<table class="table table-bordered table-hover table-sortable" id="tab_logic">
				<thead>
					<tr >
						<th class="text-center">
							User
						</th>
						<th class="text-center">
							Date/Time
						</th>
						<th class="text-center">
							Method
						</th>
						<th class="text-center">
							Person Contacted
						</th>
						<th class="text-center">
							Notes
						</th>
    					<th class="text-center">
							Ticket
						</th>
        				<th class="text-center" style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;">
						</th>
					</tr>
				</thead>
				

</body>





<div class="navbar navbar-default navbar-fixed-bottom">
    <div class="container">
      <p class="navbar-text pull-left">Created: 2015 Those who don't remember the past are condemned to search it.
           </p>

      <a href="ShiftLogindex.php" class="navbar-btn btn-info btn pull-right">
      <span class="glyphicon glyphicon-asterisk"></span>Shift Log</a>
    </div>
	<?php
		print_r ($_POST);
	?>
	
</html>








