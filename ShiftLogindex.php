<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Shift Log</title>
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
	<script type="text/javascript" src="script/getdatetime.js"></script>
	
	<script type="text/javascript" src="lib/CallTracker.php"></script>
	
	
	
<div class "form-group" "form-control">
	
	
<form name= "data" method="POST"  >

	
	

	<div class="header">
		<h1>Shift Log</h1>	
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
				<tbody>
					<!-- calls the id from javascript to add rows -->
    				<tr id='addr' data-id="0" class="hidden table-hover">
					
					
						<td data-name="date" name="date" id="date">
						    <input type="datetime-local"   class="form-control"/>
									
														
							
						</td>
						<td data-name='method' name="method" id='method'>
						    <select >
							
        				        <option value"2">IM</option>
    					        <option value"1">Phone</option>
        				        <option value"3">Email</option>
								<option value"3">In-Person</option>
						    </select>
						</td>
						<td data-name="contact" name="contact" id='contact'>
						    <input type="text"  class="form-control"/>
						</td>
						<td data-name="notes" name="notes" id="notes">
						    <textarea  rows="5" placeholder="Job Name" class="form-control"></textarea>
						</td>
    					<td data-name="ticket" name="ticket" id="ticket">
							<input type="text"  class="form-control">
						</td> 
                        <td data-name="del">
                            <button nam"del0" class='btn btn-danger  row-remove'>Remove</button> 
							<span class="glyphicon glyphicon-remove-sign"></span> 
                        
						</td>
					</tr>
					
					<script>
					$(document).ready(function() {
					 ('#tab_logic').DataTable ( {
						"processing":true,
						"serverside":true,
						"ajax":{
							"url":"shiftlog/ShiftLogindex.php"
							"type":"POST"
						},
						"columns":[
						{"data": "datetime"},
						{"data":"method"},
						{"data":"contact"},
						{"data": "notes"},
						{"data": "tickets"},
						"data": "user"}
						]
					 });
					} );						
					</script>
					
					
<?php
//db table
$table='TB_SHIFTLOG';
//primary key
$primaryKey='id';

//db is the column in the database, dt represents data table column identifier
$columns = array(
array('db'=>'DATE_TIME', 'dt'=>'datetime'),
array('db'=>'METHOD', 'dt'=>'method'),
array('db'=>'PERSON_CONTACTED', 'dt'=>'contact'),
array('db'=>'NOTES', 'dt'=>'notes'),
array('db'=>'TICKET', 'dt'=>'ticket'),
array('db'=>'USER', 'dt'=>'user'),
)



?>
					
				</tbody>
			</table>
		</div>
	</div>
	<a id="add_row" class="btn btn-info pull-right">Add Contact</a>
	
	
</div>





</body>
<!-- footer navbar-->



<nav class="navbar navbar-default navbar-fixed-bottom">
     <div class="container">
      <p class="navbar-text pull-left">Created: 2015 IS Operations Center
           
      </p>
       <div class="btn-toolbar pull-right"> 
	 <a href="search.php" class="navbar-btn btn-info btn ">
	 <span class="glyphicon glyphicon-search"></span>Search History</a>  
		
	<button class=" btn btn-green"  onclick="loadXMLDoc('Shiftlogindex.php')">Submit</button>

	
		</div>
  
  
	</div>
</nav> 

</form>
</div>
<?php
		print_r ($_POST);
	?>
</html>
