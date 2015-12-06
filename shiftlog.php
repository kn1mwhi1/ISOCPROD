<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<!-- Tag to inform IE to be smart -->
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<head>
	<title>Shift Log</title>
	
	
	<!-- Load CSS --> 
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" /> 
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" /> 
	
	<link rel="stylesheet" type="text/css" href="css/sweetalert.css" />	
	<link rel="stylesheet" type="text/css" href="css/shiftlog.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.css" />
	
	
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
						<button type="submit" class="navbar-btn btn-toprowbtn btn selfView" name="selfButton" id='selfButton' value="Your Calls">
						  <i class="glyphicon glyphicon-hand-right"></i> You
						</button>
						
						<button type="submit" class="navbar-btn btn-everyonebtn btn everyoneView" name="everyoneButton" id='everyoneButton' value="All Calls">
						  <i class="glyphicon glyphicon-eye-open"></i> Everyone
						</button>
						
						<div class="center" id="serverTimeCentral"></div>
					
					
						<div id="dynamicTable" class="">
					</tr>
					
					<!-- added css style here to ensure buttons work.-->
					<link rel="stylesheet" type="text/css" href="css/shiftlog.css" />
					
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
									<input type='text' class="form-control" name='datetime1Input' id="datetime1Input" value="" tabindex="1" onblur="validation( this, 'ALL' );"/>
										<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar spanIcon" ></span>
										</span>
								</div>
								
								<div class="input-group center">
											<button type="submit" class="navbar-btn btn-everyonebtn btn enterDate spanIcon" name="submit" id='submit' value="Current Date" onclick="" >
												<i class="glyphicon glyphicon-calendar"></i> Current Date Time
											</button>
								</div>
							</td>
						  
					
						<td id="methodTD"  name="methodTD" >
						    <select name="method" id="method" class="form-control" style="width:125px" tabindex="2">
        				        <option value="IM">IM</option>
    					        <option value="PHONE">Phone</option>
        				        <option value="EMAIL">Email</option>
								<option value="INPERSON">In-Person</option>
								<option value="SUPPORT FORM">Support Form</option>
						    </select>
						</td>

						
						
						
						<td id="personContactedTD" name="personContactedTD" >
						    <input class="form-control" style="width:210px" type="text" id="personContacted"  placeholder="First and Last Name" name="personContacted" tabindex="3" onblur="validation( this, 'ALL' );" />
						</td>
    				
					
					
						<td id="notesTD" name="notesTD" >
							  <textarea style="height:100px;width:250px" id="notes" name="notes" placeholder="Notes" class="form-control" tabindex="4" onblur="validation( this, 'ALL' );"></textarea>
						</td>
						
						
						<td id="ticketNumberTD" name="ticketNumberTD" class="table-hover">
							 <input class="form-control" style="width:210px" type="text" id="ticketNumber"  name="ticketNumber" tabindex="5" placeholder="Any ticket Number(if applicable)" onblur="validation( this, 'ALL' );" />
						</td>
					</tr>
				</tbody>
			</table>
				
		</div>
	</div>	
	

		
		<div>
					<input class="btn btn-green pull-right addCall highlight" type="submit" name="submit" id='submit' tabindex="5" value="Add Call">
					<input class="btn btn-update pull-right updateCall highlight"  type="submit" name="submit" id='submit' value="Update Call">
					<input class="btn btn-clear  pull-right clear highlight"  type="submit" name="submit" id='submit' value="Clear">
					<input class="btn btn-clear  pull-left delete highlight"  type="submit" name="submit" id='submit' value="Delete">
		</div>

	
	
</div>

</body>





<!-- footer navbar-->
<nav class="navbar navbar-inverse navbar-fixed-bottom">
     <div class="container">
      <p class="navbar-text pull-left">Created: 2015 IS Operations Center 
	  <a href="IsocLogo2.jpg"><img src="img/IsocLogo2.jpg"alt=""></a>
      </p>
	  
       <div  class="btn-toolbar pull-right"> 
	   
			<!-- 12 Hours Button -->
			<button type="submit" class="navbar-btn btn-bottomnavbtn btn twelveHours highlight" name="submit" id='submit' value="Current Calls">
			  <i class="glyphicon glyphicon-search"></i> 12 Hours
			</button>
			
			<!-- 1 Day Button -->
			<button type="submit" class="navbar-btn btn-bottomnavbtn btn oneDay" name="submit" id='submit' value="One Day">
			  <i class="glyphicon glyphicon-search"></i> 1 Day
			</button>
			
			<!-- All Button -->
			<button type="submit" class="navbar-btn btn-bottomnavbtn btn allDays" name="submit" id='submit' value="All Days">
			  <i class="glyphicon glyphicon-search"></i> All
			</button>
			
			
		</div>
	</div>
</nav> 






<!-- Load eventLog scripts -->
<script type="text/javascript" src="script/shiftlog.js"></script>
 <?php 
$tierTwo->notifyMessage(); 
?>



</html>
