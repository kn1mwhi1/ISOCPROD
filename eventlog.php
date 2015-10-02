<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<!-- Tag to inform IE to be smart -->
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<head>
	<title>Event Log</title>
	
	
	<!-- Load CSS --> 
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" /> 
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" /> 
	<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.css" />
	<link rel="stylesheet" type="text/css" href="css/SupportRequestForm.css" /> 
	<link rel="stylesheet" type="text/css" href="css/sweetalert.css" />	
	<link rel="stylesheet" type="text/css" href="css/eventlog.css" />
	
	
	<!-- Load Javascript -->
	<script type="text/javascript" src="script/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="script/bootstrap.min.js"></script>
	<script type="text/javascript" src="script/moment-with-locales.js"></script>
	<script type="text/javascript" src="script/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="script/getdatetime.js"></script>

	
	
<?php
require_once 'lib/Class_LoginLogic.php'; 
require_once 'lib/Class_Event_Logic.php';
$login = new LoginLogic();
$tierTwo = new Event_Logic();

// Check login first
$login->checkSession();
?>

</head>


<body class="" >
<?php
$login->getNavBar();
?>

<div class="header " >
	<h1 class="text-center  navbarCustom">Event Log</h1>
</div>



<div class="container h850 moveUp40 ">
    <div class="row clearfix ">
    	<div class="col-md-12 table-responsive">
			<table class="table table-bordered table-hover" id="tab_logic" >
			
				<thead>
	
					<tr id="dynamicTableRow " >
					
						<!-- normalView Button -->
						<button type="submit" class="navbar-btn btn-info btn normalView highlight" name="view" id='view' value="Normal View">
						  <i class="glyphicon glyphicon-eye-open"></i> Normal
						</button>
						
						<button type="submit" class="navbar-btn btn-info btn detailedView" name="view" id='view' value="Detailed View">
						  <i class="glyphicon glyphicon-eye-open"></i> Detailed
						</button>
						
						<div id="dynamicTable" class=""></div>
					</tr>
					
					
					
					<tr class="">
						<th class="text-center">
							Initiator
						</th>
						<th class="text-center">
							Reference
						</th>
						<th class="text-center">
							Action Required
						</th> 
						<th class="text-center">
							Start Time
						</th>
						<th class="text-center">
							End Time
						</th>
					</tr>
				</thead>
				
				
				<tbody>
				<tr class="table-hover">
				
						<td id="initiatorTD"  name="initiatorTD" >
						    <input class="form-control" style="width:210px" type="text" id="initiatorInput"  name="initiatorInput" onblur="validation( this, 'ALL' );" />
						</td>
						<td id="referenceTD"  name="referenceTD" >
						    <select name="reference" id="reference" class="form-control" style="width:125px">
        				        <option value="IM">IM</option>
    					        <option value="PHONE">Phone</option>
        				        <option value="EMAIL">Email</option>
								<option value="INPERSON">In-Person</option>
								<option value="SUPPORT FORM">Support Form</option>
						    </select>
						</td>

						<td id="actionRequiredTD" name="actionRequiredTD" >
						    <textarea style="height:100px;width:250px" id="actionRequiredInput" name="actionRequiredInput" placeholder="Job Name" class="form-control" onblur="validation( this, 'ALL' );"></textarea>
						</td>
    				
					
					
						<td id="startTime" name="startTime" >
							<div class='input-group date' id='datetimepicker1'>
								<input type='text' class="form-control" name='datetime1' id="datetime1" value="" onblur="validation( this, 'ALL' );"/>
									<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
									</span>
							</div>
							  
						</td>
						
						
						
						<td id="endTime" name="endTime" class="table-hover">

							<div class='input-group date'  id='datetimepicker2'>
								<input type='text' class="form-control" name='datetime2' id="datetime2" value="" onblur="validation( this, 'ALL' );" />
									<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
									</span>
							</div>								
		
		
							<label class="checkbox-inline"><input type="checkbox" id="noEndDateInput" name="noEndDateInput" value="" class="" >No End Date</label>
						</td>
					</tr>

		
					
					
				</tbody>
			</table>
				
		</div>
	</div>	
	
			<div class="nodisplay completeMenu" >	
			<table class="table table-bordered table-hover completeMenu" >
				<thead>
	
					<tr >
						<th class="text-center">
							Completion Notes:
						</th>
					</tr>
				</thead>
				
				<tbody>
				<tr class="table-hover">
						<td>
							<textarea id="completeNotes" name="completeNotes" placeholder="Optional Notes" class="form-control" ></textarea>
						</td>
				</tr>
		
				</tbody>
			</table>
		</div>	
		
		<div>
					<input class="btn btn-primary pull-right add" type="submit" name="submit" id='submit' value="Add Event">
					<input class="btn btn-primary pull-right update"  type="submit" name="submit" id='submit' value="Update Event">
					<input class="btn btn-danger pull-right clear"  type="submit" name="submit" id='submit' value="Clear">
		</div>
		<div class="">
					
					<!--<input class="btn btn-primary pull-left activeButton nodisplay"  type="submit" name="submit" id='submit' value="Activate"> -->
					<input class="btn btn-primary pull-left complete nodisplay"  type="submit" name="submit" id='submit' value="COMPLETED">
					<input class="btn btn-danger pull-left cancel nodisplay"  type="submit" name="submit" id='submit' value="CANCEL">
		</div>
	
	
</div>

</body>





<!-- footer navbar-->
<nav class="navbar navbar-default navbar-fixed-bottom">
     <div class="container">
      <p class="navbar-text pull-left">Created: 2015 IS Operations Center
      </p>
	  
       <div  class="btn-toolbar pull-right"> 
	   
			<!-- Current Events Button -->
			<button type="submit" class="navbar-btn btn-primary btn currentEvents highlight" name="submit" id='submit' value="Current Events">
			  <i class="glyphicon glyphicon-search"></i> Current
			</button>
			
			<!-- expiredEvents Button -->
			<button type="submit" class="navbar-btn btn-danger btn expiredEvents" name="submit" id='submit' value="Expired Events">
			  <i class="glyphicon glyphicon-search"></i> Expired
			</button>
			
			<!-- completedEvents Button -->
			<button type="submit" class="navbar-btn btn-info btn completedEvents" name="submit" id='submit' value="Completed Events">
			  <i class="glyphicon glyphicon-search"></i> Completed
			</button>
			
			<!-- pendingEvents Button -->
			<button type="submit" class="navbar-btn btn-info btn pendingEvents" name="submit" id='submit' value="Pending Events">
			  <i class="glyphicon glyphicon-search"></i> Future
			</button>
		
			<!-- allEvents Button -->
			<button type="submit" class="navbar-btn btn-info btn allEvents" name="submit" id='submit' value="All Events">
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
