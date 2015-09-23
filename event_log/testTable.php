<html>

<!-- http://mottie.github.io/tablesorter/docs/index.html#Widget-options -->
<head>
<!-- choose a theme file -->
<link rel="stylesheet" href="/path/to/theme.default.css">
<!-- load jQuery and tablesorter scripts -->

	<!--  Load JavaScript --> 
	<script type="text/javascript" src="script/bootstrap.js"></script>
	<script type="text/javascript" src="script/sweetalert.min.js"></script>
	<script type="text/javascript" src="script/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="script/jquery-2.1.4.js"></script>
	<!--
	<script type="text/javascript" src="script/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="script/jquery.metadata.js"></script>   -->
	<script type="text/javascript" src="script/tableSortCombine.js"></script>
		
	<!--  Load CSS -->
	<link rel="stylesheet" href="css/tableSort.css" />
	<link rel="stylesheet" href="css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="css/sweetalert.css" />

	
	



</head>
<body>

	<table id="tablesorter" class="tablesorter">
		<thead>
			<tr>
				<th>Account #</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Age</th>
				<th>Total</th>
				<th>Discount</th>
				<th>Difference</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>A42b</td>
				<td>Peter</td>
				<td>Parker</td>
				<td>28</td>
				<td>$9.99</td>
				<td>20.9%</td>
				<td>+12.1</td>
				<td>Jul 6, 2006 8:14 AM</td>
			</tr>
			<tr>
				<td>A255</td>
				<td>Bruce</td>
				<td>Jones</td>
				<td>33</td>
				<td>$13.19</td>
				<td>25%</td>
				<td>+12</td>
				<td>Dec 10, 2002 5:14 AM</td>
			</tr>
			<tr>
				<td>A33</td>
				<td>Clark</td>
				<td>Evans</td>
				<td>18</td>
				<td>$15.89</td>
				<td>44%</td>
				<td>-26</td>
				<td>Jan 12, 2003 11:14 AM</td>
			</tr>
			<tr>
				<td>A1</td>
				<td>Bruce</td>
				<td>Almighty</td>
				<td>45</td>
				<td>$153.19</td>
				<td>44.7%</td>
				<td>+77</td>
				<td>Jan 18, 2001 9:12 AM</td>
			</tr>
			<tr>
				<td>A102</td>
				<td>Bruce</td>
				<td>Evans</td>
				<td>22</td>
				<td>$13.19</td>
				<td>11%</td>
				<td>-100.9</td>
				<td>Jan 18, 2007 9:12 AM</td>
			</tr>
			<tr>
				<td>A42a</td>
				<td>Bruce</td>
				<td>Evans</td>
				<td>22</td>
				<td>$13.19</td>
				<td>11%</td>
				<td>0</td>
				<td>Jan 18, 2007 9:12 AM</td>
			</tr>
		</tbody>
	</table>



<script type="text/javascript">
/*
// Tell Document to sort when loaded
$(document).ready(function() 
    { 
        $("#myTable").tablesorter({widgets: ['zebra']}); 
    } 
); 
    

// Click on headers to sort the tables	
$(document).ready(function() 
    { 
        $("#myTable").tablesorter( {sortList: [[0,0], [1,0]]} ); 
    } 
); 

*/
	$(function() {
		$.extend( $.tablesorter.defaults, {
			theme: 'blue',
			widthFixed: true
		});
		$('.compatibility').tablesorter();
		$('#tablesorter').tablesorter({widgets:['zebra']});
		$('table.options, table.api').tablesorter({widgets:['stickyHeaders']});
	});


</script>


</html>