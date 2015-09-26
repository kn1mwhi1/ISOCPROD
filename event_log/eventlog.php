<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<!-- Tag to inform IE to be smart -->
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<head>
	<title>Event Log</title>
	<!-- Load Javascript -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-table.css">
	<link rel="stylesheet" type="text/css" href="css/alt.css" />
	
	<!-- Load CSS -->
	<script src="script/jquery.js"></script>
	<script src="script/bootstrap.min.js"></script>
	<script src="script/bootstrap-table.js"></script>	
	<script type="text/javascript" src="script/bootstrap.js"></script>	
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
<div id="EventLog">
	 <div id="dynamicTable" class="container"></div>
</div>




<div class="container spacing">
    <div class="row clearfix ">
    	<div class="col-md-12 table-responsive">
			<table class="table table-bordered table-hover" id="tab_logic">
				
				<thead>
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
						    <input class="form-control" style="width:250px" type="text" id="initiatorInput"  name="initiatorInput" />
						</td>
						<td id="referenceTD"  name="referenceTD" >
						    <select name="reference" id="reference">
        				        <option value"IM">IM</option>
    					        <option value"Phone">Phone</option>
        				        <option value"Email">Email</option>
								<option value"In-Person">In-Person</option>
						    </select>
						</td>

						<td id="actionRequiredTD" name="actionRequiredTD" >
						    <textarea style="height:100px;width:300px" id="actionRequiredInput" name="actionRequiredInput" placeholder="Job Name" class="form-control"></textarea>
						</td>
    				
						<td id="startTime" name="startTime" >
						    <input  style="width:200px" type="datetime-local"  id="startTimeInput" name="startTimeInput"  class="form-control"/>	
						</td>
						<td id="endTime" name="endTime" class="table-hover">
						    <input  style="width:200px" type="datetime-local"  id="endTimeInput" name="endTimeInput"  class="form-control"/>
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
					var reference = someData.REFERENCE;
					var initiator = someData.INITIATOR;
					var actionRequired = someData.ACTION_REQUIRED;
					var creatorTech = someData.CREATOR_TECH;
					var createTime = someData.CREATE_DATETIME;
					var completeNotes = someData.COMPLETION_NOTES;
					var completionTech = someData.COMPLETION_TECH;
					var requestTicket = someData.REQUEST_TICKET;
					
					//alert(ticketID);
					
					
					// place values in inputs
					$(initiatorInput).val(initiator);
					$(actionRequiredInput).val(actionRequired);
					
				
					$(startTimeInput).val('2014-01-02T11:42:13.510');
					//document.getElementById("startTimeInput").value = "2014-01-02 11:42:00";
					//$(endTimeInput).datepicker({ defaultDate: +7 });
					//$(endTimeInput).datepicker({endTime});
					
					
					$(noEndDateInput).val(noEndTime);

					
			 }
		 });


});


 
  var temp ='';
 function ajaxcall(){
     $.ajax({
		 type: "POST",
         url: 'eventLogCustomActive.php',
		 data:{ submit : 'CUSTOM' },
         success: function(someData){
			
				if ( temp != someData)
				{
					 $(dynamicTable).html(someData);
					 temp = someData;
				 }
         }
     });
 }
 
</script>


 <?php 
$tierTwo->notifyMessage(); 
?>



</html>
