<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<!-- Tag to inform IE to be smart -->
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<head>
	<title>Event Log</title>
	
	
	<!-- Load CSS --> 
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" /> 
	<link rel="stylesheet" href="css/bootstrap-table.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" /> 
	<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.css" /> 
	<link rel="stylesheet" type="text/css" href="css/eventLog.css" /> 
	
	
	<!-- Load Javascript -->
	<script type="text/javascript" src="script/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="script/bootstrap.min.js"></script>
	<script type="text/javascript" src="script/moment-with-locales.js"></script>
	<script type="text/javascript" src="script/bootstrap-datetimepicker.js"></script>
	<script src="script/bootstrap-table.js"></script>	
	<script type="text/javascript" src="script/getdatetime.js"></script>
	
<?php
require_once 'lib/Class_Event_Logic.php';
$tierTwo = new Event_Logic();
?>
	
<div class="header" >
	<h1 class="text-center">Event Log</h1>
</div>
</head>

<body>



<div class="container spacing">
    <div class="row clearfix ">
    	<div class="col-md-12 table-responsive">
			<table class="table table-bordered table-hover" id="tab_logic">
				
				<thead>
					<tr>
					<br />
					<br />
					
					</tr>
					<tr id="dynamicTableRow" >
						<div id="dynamicTable" class=""></div>
					</tr>
					
					<tr>
						<br/>
						<br/>

					</tr>
					
					
					<tr >
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
						    <input class="form-control" style="width:225px" type="text" id="initiatorInput"  name="initiatorInput" />
						</td>
						<td id="referenceTD"  name="referenceTD" >
						    <select name="reference" id="reference" class="form-control" style="width:138px">
        				        <option value="IM">IM</option>
    					        <option value="PHONE">Phone</option>
        				        <option value="EMAIL">Email</option>
								<option value="INPERSON">In-Person</option>
								<option value="SUPPORT FORM">Support Form</option>
						    </select>
						</td>

						<td id="actionRequiredTD" name="actionRequiredTD" >
						    <textarea style="height:100px;width:275px" id="actionRequiredInput" name="actionRequiredInput" placeholder="Job Name" class="form-control"></textarea>
						</td>
    				
						<td id="startTime" name="startTime" >
						    <!-- <input style="width:200px" type="datetime-local"  id="startTimeInput" name="startTimeInput"  class="form-control"/>  -->


							<div class='input-group date' id='datetimepicker1'>
								<input type='text' class="form-control" name='datetime1' id="datetime1" value="" />
									<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
									</span>
							</div>
							  
							
						</td>
						<td id="endTime" name="endTime" class="table-hover">
						    
							
					<!--		<input  style="width:200px" type="datetime-local"  id="endTimeInput" name="endTimeInput"  class="form-control"/>   -->
							
							<div class='input-group date'  id='datetimepicker2'>
								<input type='text' class="form-control" name='datetime2' id="datetime2" value="" />
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
	<input class="btn btn-primary pull-right" type="submit" name="submit" id='submit' value="Add Event">
</div>



		






</body>





<!-- footer navbar-->
<nav class="navbar navbar-default navbar-fixed-bottom">
     <div class="container">
      <p class="navbar-text pull-left">Created: 2015 IS Operations Center
           
      </p>
	  
       <div  class="btn-toolbar pull-right"> 
	 <a id="" href="expiredeventlog.html" class="navbar-btn btn-info btn ">
	 <span class="glyphicon glyphicon-search"></span>Expired Events</a>  
		
			
	 <a href="#" class="navbar-btn  btn-green  btn btns-sp pull-right">
			<span id="test" class="glyphicon glyphicon-save-file"></span>  Save</a>
		</div>
  
  
	</div>
</nav> 




<script>

	$(function () {	
	$('#datetimepicker1').datetimepicker({
		showClear: true
	});
	
	});
	
	

	$(function () {$('#datetimepicker2').datetimepicker();
		showClear: true
	});

 
$(document).ready(function(){
     setInterval(ajaxcall, 1000);
 });
 

 /*
 
 $(document).on('click', 'td', function (){
  
    var postID = this.id;
    $.get('eventLogCustomActive.php', { ID:postID }, function(data) {
       
      
       alert(data);
    });
    return false; // prevent default
  
});

 */
 
 $(document).on('click', 'td', function () {
			var postID = this.id;
			//alert(postID);

	   $.ajax({
			 type: "POST",
			 url: "eventLogCustomActive.php",
			 data: { ID : postID },
			 success: function(data){
					//alert(data);
					var someData = JSON.parse(data);
					
					
					var ticketID = someData.EVENT_ID;
					var startTime = someData.START_DATETIME;
					var endTime = someData.END_DATETIME;
					var noEndTime = someData.NO_ENDDATE;
					var status = someData.STATUS;
					var referenceData = someData.REFERENCE;
					var initiator = someData.INITIATOR;
					var actionRequired = someData.ACTION_REQUIRED;
					var creatorTech = someData.CREATOR_TECH;
					var createTime = someData.CREATE_DATETIME;
					var completeNotes = someData.COMPLETION_NOTES;
					var completionTech = someData.COMPLETION_TECH;
					var requestTicket = someData.REQUEST_TICKET;
					
					//alert(ticketID);
					
					
					// place values in inputs
					$('#initiatorInput').val(initiator);
					$('#actionRequiredInput').val(actionRequired);
					$('#reference').val(referenceData.trim());
						
					$('#datetime1').val(convertDate( startTime ));
					$('#datetime2').val(convertDate( endTime ));
					
					
					$(noEndDateInput).val(noEndTime);

					
			 }
		 });


});

 
  var selection = 'CUSTOM';
  var temp ='';
 function ajaxcall(){
     $.ajax({
		 type: "POST",
         url: 'eventLogCustomActive.php',
		 data:{ submit : selection },
         success: function(someData){
			
				if ( temp != someData)
				{
					 $(dynamicTable).html(someData);
					 temp = someData;
				 }
         }
     });
 }
   
	// convert a mysql time and date to a customer time and date
   function convertDate( dateTime )
   {
		// Split timestamp into [ Y, M, D, h, m, s ]
		var t = dateTime.split(/[- :]/);

		// Apply each element to the Date function
		var timeNow = new Date(t[0], t[1], t[2], t[3], t[4], t[5]);
		
		var year = timeNow.getFullYear();
		var day = timeNow.getDate();
		var month = timeNow.getMonth(); 
		var hours   = timeNow.getHours();
		var minutes = timeNow.getMinutes();
		var timeString = ( month < 10) ? "0" + month + "/" : month + "/";
	   
		timeString += (day < 10 ) ? "0" + day + "/" : day + "/" ;
		timeString += year + " ";
		timeString += "" + ((hours > 12) ? hours - 12 : hours);
		timeString += ((minutes < 10) ? ":0" : ":") + minutes;
		timeString += (hours >= 12) ? " PM" : " AM";
		
		return timeString;
   }

</script>


 <?php 
$tierTwo->notifyMessage(); 
?>



</html>
