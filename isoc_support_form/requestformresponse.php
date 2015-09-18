<!--
/ Request Form Response History
5/27/2015 - Form created
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?php
require('lib/Class_LogicIsocSupportForm.php');
require('lib/Class_LoginLogic.php');

$Login = new LoginLogic();
$TierTwo = new LogicIsocSupportForm();
$Login->checkSession();


// get the request URI  anything with ?$DATA
$requestTicketNumber = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

	if ( is_numeric ($requestTicketNumber) )
	{
		// load fields
		$TierTwo->loadTicketInfoArray( $requestTicketNumber);
		$isocTechID = '53741';
		$TierTwo->isocUpdateRequestAccept( $requestTicketNumber, $isocTechID );
	}
	
?>	

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>I.S. Operations Support Request Form</title>
	
	<!--  Load JavaScript --> 
	<script type="text/javascript" src="script/supportscript.js" async></script> 
	<script type="text/javascript" src="script/bootstrap.js"></script>
	<script type="text/javascript" src="script/bootstrap-datetimepicker.js"></script>
		
	<!--  Load CSS -->
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.css" />
	<link rel="stylesheet" href="css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="css/menubar.css" /> 
	<link rel="stylesheet" type="text/css" href="css/SupportRequestForm.css" /> 

</head>




<body onLoad=DoTheCookieStuff()>




<!-- <h1>Data Center Operations Support Request</h1> -->
<img class="center block" src="img/IS_Operations_Support_Request_Form_Response_New.gif" />








<!-- Input boxes for ISOC Technician, Name, Contact Number and Email.-->
<form name="response_form" method="post" action="">


<div class="Contact_Box">
   <div class="center customWidthHeight leftTen">
	<div class="inputLeft">
	   <div class="left">
		  <b>ISOC Tech Name</b>
		  <b>ISOC Ticket ID</b>
		  <b>Requester Name:</b>
		  <b>Reply to:</b>
		  <b>Copy to:</b> 
		  <b>Subject:</b>   
	   </div>
	   <div class="right">
		  <input class="input_box form-control" type='text' name='ISOCTechName' id='ISOCTechName' value='<?php echo $TierTwo->getTicketInfo('ISOCTechName');?>' onblur='' readonly>
		  <input class="input_box form-control" type='text' name='ISOCTicketID' id='ISOCTicketID' value='<?php echo $TierTwo->getTicketInfo('ISOCTicketID');?>' onblur='' readonly>
		  <input class="input_box form-control" type='text' name='RequesterName'id='RequesterName' value='<?php echo $TierTwo->getTicketInfo('RequesterName');?>' onblur='' readonly>
		  <input class="input_box form-control" type='text' name='ReplyTo'  id='ReplyTo' value='<?php echo $TierTwo->getTicketInfo('ReplyTo');?>' onblur='' readonly>
		  <input class="input_box form-control" type='text' name='CopyTo'  id='CopyTo' value='<?php echo $TierTwo->getTicketInfo('CopyTo');?>' onblur='' readonly>
		  <input class="input_box form-control" type='text' name='textboxSubject' id='textboxSubject' value='<?php echo $TierTwo->getTicketInfo('textboxSubject');?>' onblur='' readonly>
	   </div>
	  </div>
	 <div class="inputRight">
	   <div class="left">
		  <b>ISOC Technician ID:</b>
		  <b class="colorWhite">Button</b>
		  <b>Initial Submit Time:</b>
		  <b>Response Time:</b>
		  <b>Completion Counter:</b> 
		  <b class="colorWhite">Subject:</b>   
	   </div>
	   <div class="right">
		  <input class="input_box form-control" type='text' name='ISOCTechnician' id='ISOCTechnician' value='<?php echo $TierTwo->getTicketInfo('ISOCTechnician');?>' onblur='' >
		  <div class="customBlock"></div><input class="btn-xs btn-danger customMarginButton" type='submit' name='submit' id='submit' value="Assume Ownership"><div class="customBlock"></div>
		  <input class="input_box form-control" type='text' name='RequesterName'id='RequesterName' value='<?php echo $TierTwo->getTicketInfo('RequesterName');?>' onblur='' readonly>
		  <input class="input_box form-control" type='text' name='ReplyTo'  id='ReplyTo' value='<?php echo $TierTwo->getTicketInfo('ReplyTo');?>' onblur='' readonly>
		  <input class="input_box form-control" type='text' name='CopyTo'  id='CopyTo' value='<?php echo $TierTwo->getTicketInfo('CopyTo');?>' onblur='' readonly>
		  <input class="input_box form-control" type='text' name='textboxSubject' id='textboxSubject' value='<?php echo $TierTwo->getTicketInfo('textboxSubject');?>' onblur='' readonly>
	   </div>
	 </div> 
   </div>
   </div>

 <!-- Selections for preferred contact method -->

 	<div class="">
			<!-- This div is used to add a space, much like a break -->
	</div>
 
  


</div>




<div class="box">

	<!-- RESPONSE TEST BOX -->
	<div class="spacer10"></div>
	<strong>*** Request Overview ***</strong>
	<div class="spacer10">
			<!-- This div is used to add a space, much like a break -->
	</div>
	<div>
	
	Blah blah blah a response
	</div>
	
	

	<!-- RESPONSE TEST BOX -->
	<div class="spacer10"></div>
	<strong>*** Enter your response below ***</strong>
	<div class="spacer10">
			<!-- This div is used to add a space, much like a break -->
	</div>
	<textarea class='form-control' id='test' name='details' rows='7' cols='100' placeholder="An IS Operations Technician is submitting your request." ></textarea>
	</div>
</div>

<!-- FORM SUBMISSION --> 
<div class='box'>
<input class="btn btn-primary" type="submit" name="submit" id='submit' value="Send Response">
</div>
	
</form>




</body>
<footer>
<hr>
<!-- UPDATE TO REFLECT CURRENT REVISION OF PAGE -->
<p id="Revision" >Rev. 5.27.2015</p></p>
</footer>
<?php
$TierTwo->popup->notifyMessage();

?>
</html>
