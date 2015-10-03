<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<!-- Tag to inform IE to be smart -->
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<head>
	<title>Shift Log</title>
	
	
	<!-- Load CSS --> 
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" /> 
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" /> 
	<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.css" />
	<link rel="stylesheet" type="text/css" href="css/SupportRequestForm.css" /> 
	<link rel="stylesheet" type="text/css" href="css/sweetalert.css" />	
	<link rel="stylesheet" type="text/css" href="css/shiftlog.css" />
	
	
	<!-- Load Javascript -->
	<script type="text/javascript" src="script/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="script/bootstrap.min.js"></script>
	<script type="text/javascript" src="script/moment-with-locales.js"></script>
	<script type="text/javascript" src="script/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="script/getdatetime.js"></script>

	
	
<?php
require_once 'lib/Class_LoginLogic.php'; 
require_once 'lib/Class_ShiftLog_Logic.php';
$login = new LoginLogic();
$tierTwo = new ShiftLog_Logic();

// Check login first
$login->checkSession();
?>

</head>

<?php
$login->getNavBar();
?>
<body class="" >


<div class="header " >
	<h1 class="text-center  navbarCustom">Shift Log</h1>
</div>



<div class="container h850 moveUp40 ">
    <div class="row clearfix ">
    	<div class="col-md-12 table-responsive">
			<table class="table table-bordered table-hover" id="tab_logic" >
			
				<thead>
	
					<tr id="shiftLogDynamicTableRow " >
							
						<!-- normalView Button -->
						<button type="submit" class="navbar-btn btn-info btn selfView highlight" name="selfButton" id='selfButton' value="Your Calls">
						  <i class="glyphicon glyphicon-eye-open"></i> Self
						</button>
						
						<button type="submit" class="navbar-btn btn-info btn everyoneView" name="everyoneButton" id='everyoneButton' value="All Calls">
						  <i class="glyphicon glyphicon-eye-open"></i> Everyone
						</button>
						
						<div class="center" id="serverTimeCentral"></div>
					
					
						<div id="dynamicTable" class=""></div>
					</tr>
					
					
					
					<tr class="">
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
							Ticket (if applicable)
						</th>
					</tr>
				</thead>
				
				
				<tbody>
				<tr class="table-hover">
							<td id="datetimepickerTD"  name="datetimepickerTD" >
								<div class='input-group date' id='datetimepickerDiv'>
									<input type='text' class="form-control" name='datetime1Input' id="datetime1Input" value="" onblur="validation( this, 'ALL' );"/>
										<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
										</span>
								</div>
							</td>
						  
					
						<td id="methodTD"  name="methodTD" >
						    <select name="method" id="method" class="form-control" style="width:125px">
        				        <option value="IM">IM</option>
    					        <option value="PHONE">Phone</option>
        				        <option value="EMAIL">Email</option>
								<option value="INPERSON">In-Person</option>
								<option value="SUPPORT FORM">Support Form</option>
						    </select>
						</td>

						
						
						
						<td id="personContactedTD" name="personContactedTD" >
						    <input class="form-control" style="width:210px" type="text" id="personContacted"  placeholder="First and Last Name" name="personContacted" onblur="validation( this, 'ALL' );" />
						</td>
    				
					
					
						<td id="notesTD" name="notesTD" >
							  <textarea style="height:100px;width:250px" id="notes" name="notes" placeholder="Notes" class="form-control" onblur="validation( this, 'ALL' );"></textarea>
						</td>
						
						
						<td id="ticketNumberTD" name="ticketNumberTD" class="table-hover">
							 <input class="form-control" style="width:210px" type="text" id="ticketNumber"  name="ticketNumber" placeholder="Any ticket Number(if applicable)" onblur="validation( this, 'ALL' );" />
						</td>
					</tr>
				</tbody>
			</table>
				
		</div>
	</div>	
	

		
		<div>
					<input class="btn btn-primary pull-right addCall" type="submit" name="submit" id='submit' value="Add Call">
					<input class="btn btn-primary pull-right updateCall"  type="submit" name="submit" id='submit' value="Update Call">
					<input class="btn btn-danger pull-right clear"  type="submit" name="submit" id='submit' value="Clear">
		</div>

	
	
</div>

</body>





<!-- footer navbar-->
<nav class="navbar navbar-inverse navbar-fixed-bottom">
     <div class="container">
      <p class="navbar-text pull-left">Created: 2015 IS Operations Center
      </p>
	  
       <div  class="btn-toolbar pull-right"> 
	   
			<!-- Current Events Button -->
			<button type="submit" class="navbar-btn btn-primary btn twelveHours highlight" name="submit" id='submit' value="Twelve Hours">
			  <i class="glyphicon glyphicon-search"></i> 12 Hours
			</button>
			
			<!-- expiredEvents Button -->
			<button type="submit" class="navbar-btn btn-danger btn oneDay" name="submit" id='submit' value="One Day">
			  <i class="glyphicon glyphicon-search"></i> 1 Day
			</button>
			
			<!-- expiredEvents Button -->
			<button type="submit" class="navbar-btn btn-danger btn sevenDays" name="submit" id='submit' value="Seven Days">
			  <i class="glyphicon glyphicon-search"></i> 7 Days
			</button>
			
			<!-- completedEvents Button -->
			<button type="submit" class="navbar-btn btn-info btn fifteenDays" name="submit" id='submit' value="Fifteen Days">
			  <i class="glyphicon glyphicon-search"></i> 15 Days
			</button>
			
			<!-- pendingEvents Button -->
			<button type="submit" class="navbar-btn btn-info btn thirtyDays" name="submit" id='submit' value="Thirty Days">
			  <i class="glyphicon glyphicon-search"></i> 30 Days
			</button>
		
			<!-- allEvents Button -->
			<button type="submit" class="navbar-btn btn-info btn allCalls" name="submit" id='submit' value="All Calls">
			  <i class="glyphicon glyphicon-search"></i> All
			</button>
		</div>
	</div>
</nav> 






<!-- Load eventLog scripts -->
<script type="text/javascript" src="script/eventlog.js"></script>
 <?php 
$tierTwo->notifyMessage(); 
?>



</html>
