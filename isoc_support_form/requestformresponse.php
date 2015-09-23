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
$TierTwo->retrieveTicket();
$TierTwo->checkPost();

?>	

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>I.S. Operations Support Request Form</title>
	
	<!--  Load JavaScript --> 
	<script type="text/javascript" src="script/supportscript.js" async></script> 
	<script type="text/javascript" src="script/bootstrap.js"></script>
	<script type="text/javascript" src="script/sweetalert.min.js"></script>
	<script type="text/javascript" src="script/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="script/jquery.js"></script>
		
	<!--  Load CSS -->
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.css" />
	<link rel="stylesheet" href="css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="css/sweetalert.css" />
	<link rel="stylesheet" type="text/css" href="css/menubar.css" /> 
	<link rel="stylesheet" type="text/css" href="css/SupportRequestForm.css" /> 
	<link rel="stylesheet" type="text/css" href="css/countDown.css" />
	<link rel="stylesheet" type="text/css" href="css/ledlights.css" />

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
	 <div class="inputRight ">
	   <div class="left">
		  <b>ISOC Technician ID:</b>
		  <b>Ticket Status:</b>
		  <b>Initial Submit Time:</b>
		  <b>Response Date-Time:</b>
		  <b>Complete Date-Time:</b> 
		  <b class="<?php $TierTwo->getTicketInfo('timer_hide'); ?>" >Total Time:</b>   
	   </div>
	   <div class="right">
		
			  <input class="input_box form-control techIDSize inner" type='text' name='ISOCTechnician' id='ISOCTechnician' value='<?php echo $TierTwo->getTicketInfo('ISOCTechnician');?>' onblur='' readonly>
			  <input class="btn-xs btn-danger buttonMargin inner <?php $TierTwo->getTicketInfo('assume_button'); ?>" type='submit' name='submit' id='submit' value="Assume Ownership">
		
				<?php $TierTwo->getTicketInfo('status_indicator'); ?>
		
		  <input class="input_box form-control metaBox" type='text' name='initialSubmitTime'id='initialSubmitTime' value='<?php echo $TierTwo->getTicketInfo('initialSubmitTime');?>' onblur='' readonly>
		  <input class="input_box form-control metaBox" type='text' name='responseTime'  id='responseTime' value='<?php echo $TierTwo->getTicketInfo('responseTime');?>' onblur='' readonly>
		  <input class="input_box form-control metaBox" type='text' name='completeTime'  id='completeTime' value='<?php echo $TierTwo->getTicketInfo('completeTime');?>' onblur='' readonly>
		  
		  <div class="timer <?php $TierTwo->getTicketInfo('timer_hide'); ?>" id="timer" name="timer">
				<ul class="countdown">
				<li> <span class="days"id="days">00</span>
				<p class="days_ref">days</p>
				</li>
				<li class="seperator">.</li>
				<li> <span class="hours" id="hours">00</span>
				<p class="hours_ref">hours</p>
				</li>
				<li class="seperator">:</li>
				<li> <span class="minutes" id="minutes">00</span>
				<p class="minutes_ref">minutes</p>
				</li>
				<li class="seperator">:</li>
				<li> <span class="seconds" id="seconds">00</span>
				<p class="seconds_ref">seconds</p>
				</li>
				</ul>
		  </div>
		  
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
	<b><u>Request Overview</u></b> 
	
	
	
	<div class="spacer10">
			<!-- This div is used to add a space, much like a break -->
	</div>
	
	<div class="customW400HAuto textAlignLeft" name="request_overview" id="request_overview">
		<?php echo $TierTwo->getTicketInfo('request_overview');?>
	</div>
	
	

	<!-- RESPONSE TEST BOX -->
	<div class="spacer10"></div>
	<div class="spacer10"></div>
	<div class="spacer10"></div>
	<b><u>Enter your response below</u></b>
	<div class="spacer10">
			<!-- This div is used to add a space, much like a break -->
	</div>
	<textarea class='form-control' id='test' name='details' rows='7' cols='100' placeholder="Leave blank for default message of: Your request has been completed." ></textarea>
	</div>
</div>

<!-- FORM SUBMISSION --> 
<div class='box'>
<input class="btn btn-primary" type="submit" name="submit" id='submit' value="Send Response">
<input class="btn btn-danger" type="submit" name="submit" id='submit' value="Cancel Request">
</div>
	
</form>

<script>
 $(document).ready(function(){
     setInterval(ajaxcall, 1000);
 });
 function ajaxcall(){
     $.ajax({
         url: 'gettime.php',
         success: function(data) {
             data = data.split(':');
             $('#days').html(data[0]);
			 $('#hours').html(data[1]);
             $('#minutes').html(data[2]);
             $('#seconds').html(data[3]);
         }
     });
 }

 
 $( function() {
  var $winHeight = $( window ).height()
  $( '.container' ).height( $winHeight );
});
 
 </script>
<!--<span id="hours">0</span>:<span id="minutes">0</span>:<span id="seconds">0</span>-->




</body>
<footer>
<hr>
<!-- UPDATE TO REFLECT CURRENT REVISION OF PAGE -->
<p id="Revision" >Rev. 5.27.2015</p></p>
</footer>
<?php
if ($TierTwo->popup->notifyMessage())
{		
}
?>






</html>
