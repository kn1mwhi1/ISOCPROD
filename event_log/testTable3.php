<!--  view-source:http://issues.wenzhixin.net.cn/bootstrap-table/index.html  -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-table.css">
<script src="script/jquery.js"></script>
<script src="script/bootstrap.min.js"></script>
<script src="script/bootstrap-table.js"></script>



</head>
<body>


  <div id="dynamicTable" class="container">

  </div>




</body>



<script>
 
$(document).ready(function(){
     setInterval(ajaxcall, 1000);
 });
 
 var temp ='';
 
 function ajaxcall(){
     $.ajax({
         url: 'script/eventLogDashBoard.php',
         success: function(data){
			if ( temp != data)
			{
				 $(dynamicTable).html(data);
				 temp = data;
			 }
         }
     });
 }
 
</script>
</html>