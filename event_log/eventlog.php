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
						    <textarea style="height:100px;width:300px" id="actionRequired" name="actionRequired" placeholder="Job Name" class="form-control"></textarea>
						</td>
    				
						<td id="startTime" name="startTime" >
						    <input  style="width:200px" type="datetime-local"  name="startTime"  class="form-control"/>	
						</td>
						<td id="endTime" name="endTime" class="table-hover">
						    <input  style="width:200px" type="datetime-local"  name="endTime"  class="form-control"/>
							<label class="checkbox-inline"><input type="checkbox" value="" class="" >No End Date</label>
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
 
 
 
 

 $(document).on('click', 'td', function () {
			var postID = this.id;
			//alert(postID);

				$.getJSON('eventLogCustomActive.php', {name:'Darian Brown',age:40}, function(data) {
						alert('made it');
				});
  
  
			
	 /*		
	   $.ajax({
			 type: "POST",
			 url: 'eventLogCustomActive.php',
			 data: 'data1=testdata1&data2=testdata2&data3=testdata3&data4=testdata4&data5=testdata5&data6=testdata6&data7=testdata7&data8=testdata8&data9=testdata9&data10=testdata10&data11=testdata11&data12=testdata12&data13=testdata13',
             dataType: 'json',
             cache: false,
			 success: function(someData){
					alert(someData);
					var ticketID = someData[0];
					var startTime = someData[1];
					var endTime = someData[2];
					var noEndTime = someData[3];
					var status = someData[4];
					var reference = someData[5];
					var initiator = someData[6];
					var actionRequired = someData[7];
					var creatorTech = someData[8];
					var createTime = someData[9];
					var completeNotes = someData[10];
					var completionTech = someData[11];
					var requestTicket = someData[12];
					
					alert(ticketID);
					// place values in inputs
					//$(initiator).value(initiator);
					
					$(dynamicTable).html(ticketID);
					$(dynamicTable).html(ticketID);
					$(dynamicTable).html(ticketID);
					$(dynamicTable).html(ticketID);
					$(dynamicTable).html(ticketID);
					
					
			 }
		 });
*/

});


 
  var temp ='';
  var selection='CUSTOM';
 function ajaxcall(){
     $.ajax({
		 type: "POST",
         url: 'eventLogCustomActive.php',
		 data:{ SELECTION : selection },
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
