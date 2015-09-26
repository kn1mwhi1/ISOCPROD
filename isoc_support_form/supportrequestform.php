<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<title>I.S. Operations Support Request Form</title>
<div id='background'>
<?php
require('lib/Class_LogicIsocSupportForm.php');
$TierTwo = new LogicIsocSupportForm();
 

?>	
<script type="text/javascript">
// JavaScript variables created through PHP
<?php $TierTwo->createJavaScriptVariables(); ?>
</script>





	<!--  Load JavaScript --> 
	<script type="text/javascript" src="script/supportscript.js" ></script>
	<script type="text/javascript" src="script/jquery.js"></script>
	<script type="text/javascript" src="script/moment.js"></script>
	<script type="text/javascript" src="script/sweetalert.min.js"></script>
	<script type="text/javascript" src="script/bootstrap.js"></script>
	
	


	<!--  Load CSS --> 
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.css" />
	<link rel="stylesheet" href="css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="css/menubar.css" /> 
	<link rel="stylesheet" type="text/css" href="css/sweetalert.css" />
	<link rel="stylesheet" type="text/css" href="css/SupportRequestForm.css" /> 
	
<?php $TierTwo->checkUserSubmittedData(); ?>
	
</head>




<body onLoad="loadCookies()">




<div class="center" id="isocImage" >
	<img src="img/isocsupportrequestformlogo.gif" />
</div>




<!-- Input boxes for Name, Contact Number and Email.-->
<form name = "contact_form" method="post" action="" >


	<div class="Contact_Box">
	   
		<div class="input">

			   <div class="left">
				  <b>Name:</b>
				  <b>Contact Number:</b>
				  <b>Subject:</b>
				  <b>Contact Email:</b>  
				  <b>Copy Email:</b>
			   </div>

			   <div class="right">
				  <input title="Please type your first and last name." class="input_box form-control <?php $TierTwo->input_error('namebox');?>" type='text' name="namebox" id="namebox" onblur="setCookie('namebox',document.getElementById('namebox').value,365)">
				  <input title="Contact number field should only contain numbers. example: 8657778771" class="input_box form-control <?php $TierTwo->input_error('numberbox');?>" type='text' name='numberbox'  id="Contact_Number" onblur="this.value = cleanContactNumber(this.value); setCookie('Contact_Number',document.getElementById('Contact_Number').value,365);">
				  <input title="Please type any subject." class="input_box form-control <?php $TierTwo->input_error('textboxSubject');?>" type='text' name='textboxSubject' id="textboxSubject" onblur="setCookie('textboxSubject',document.getElementById('textboxSubject').value,365)">
				  <input title="Please type your email address. Only one email address is allowed. example: someone@uscellular.com" class="input_box form-control <?php $TierTwo->input_error('emailbox');?>" type='text' name='emailbox'  id="Email" onblur="this.value = cleanEmail( this.value ); setCookie('Email',document.getElementById('Email').value,365)">
				  <input title="Separate each email address with a comma." class="input_box form-control <?php $TierTwo->input_error('textboxCC');?>" type='text' name='textboxCC' id="textboxCC"  onblur="this.value = cleanCCEmail( this.value ); setCookie('textboxCC',document.getElementById('textboxCC').value,365);">
			   </div>

		 </div>

	 <!-- Selections for preferred contact method -->

	 

	   <div class="preferred_text">
		  <b>Please select your preferred contact method:</b>
		  <input type='radio' class="" id='contactMethod' name='contactMethod' value='Phone' onChange="setCookie('contactMethod',document.contact_form.contactMethod.value,365)"><b>Phone</b>
		  <input type='radio' class="" id='contactMethod' name='contactMethod' value='Email' checked="checked" onChange="setCookie('contactMethod',document.contact_form.contactMethod.value,365)"><b>E-mail</b>
		</div>
	   


	</div>

	<!-- Main selection box drop-down -->
	<div class="box">
		
		<div id="select_option">
			<strong>Please select an option:</strong>
			
				<div class="spacer10" >
				</div>
			
			<select title="Please select a value." class="form-control dropdown_style center input-sm <?php $TierTwo->input_error('options');?>" name="options" id = "main_options" value="" onchange = "showForm()" onblur ="setCookie('main_options',document.getElementById('main_options').selectedIndex,1)">
			</select>
		
		
		
				<div class="spacer10">
				</div>
			
			<div id="please_enter_options_title" >
				Please enter the job/process/stream/daemon name:
			</div>
			<textarea class="form-control" name='eventIdName' id='eventIdName' value="" onblur ="setCookie('eventIdName',document.getElementById('eventIdName').value,1)" placeholder="(If Applicable)"></textarea>
		
		</div>
			
			<!-- Spacer (for formatting) -->
			<div class="spacer10">
			</div>
		
		<!-- This container will Hide automatically until user selects an option in main dropdown box -->
		<div class="center" id="container_environment_request_type" >
			
			<!-- Environment drop-down box -->
			<div class="" id="div_environment_selection" >
				<label class="displayBlock" for="environment_opts">Environment:</label>
				<select class="dropdown_style form-control input-sm" name="environment_opts" id = "environment_opts" value="" onblur ="setCookie('environment_opts',document.getElementById('environment_opts').selectedIndex,1)" >
				</select>
			</div>
		
			<!-- Request Type drop-down box -->
			<div class="" id="div_request_type_selection">
				<label class="displayBlock" for="request_type_opts">Please Select Request Type:</label>
				<select class="dropdown_style form-control displayBlock input-sm" name="request_type_opts" id = "request_type_opts" value="" onchange = "requestTypeSelection()" onblur ="setCookie('request_type_opts',document.getElementById('request_type_opts').selectedIndex,1)">
					<option value = "N/A">Select Option</option>
				</select>
			</div>
			
		</div>
			
			
			
		<!-- The following options allow the second drop-down box to display the correct contents based on the Request Type selection.-->
		
		<!-- General Select Box to be used -->
		<div class="" id="div_dynamic_request_type" >
		<strong>Additional Questions:</strong>
			<select class="form-control center input-sm" name="select_dynamic_request_type" id = "select_dynamic_request_type" value="<" onblur ="setCookie('select_dynamic_request_type',document.getElementById('select_dynamic_request_type').selectedIndex,1)" >
			</select>
		</div>


		<!-- DETAILS REQUEST BOX -->
		<div class="spacer10"></div>
		<strong>*** Please enter the details of your request: ***</strong>
		<textarea class="form-control" id='detailsTextArea' name='detailsTextArea' placeholder="(If Applicable)" value="" onblur ="setCookie('detailsTextArea',this.value,1)" ></textarea>
		</div>
		
		
	</div>
	<!-- SELECTIONS FOR WHEN REQUEST NEEDS TO BE COMPLETED -->
	<div class='box'>
	<strong>Does this need to be executed immediately or at a future time? </strong>
		<div class="spacer10"></div>
	<input type='radio' class="radioImmediatly" id='Urgency' name='Urgency' value='Immediately' onclick="setCookie('Urgency',this.selectedIndex,365); propertyDisabled('datetime1', 'datetime2'); hideDiv( 'calendarBottom' );"> Immediately 
		<div></div>
		
	<input type='radio' id='Urgency' name='Urgency' value='In the future' onclick="setCookie('Urgency',this.selectedIndex,365); propertyEnabled('datetime1', 'datetime2'); showDiv('calendarBottom'); "> In the future 
		<div></div>




	<!-- Date(s) request should be completed: <input type='text' name='datereq' value='(If Applicable)'/> * Please indicate whether 'calendar date' or 'plan date' in 'Request Details' section. -->
	<div id="start_end_date">

	<div class="container topPadding10" id="calendarBottom" >
			<div class="left_date">
			Start Date:
			<div></div>
			End Date:
			</div>	
				<div class="row">
					<div class='col-sm-6'>
						<div class="form-group">
							
							<div class='input-group date smallerTextBox' id='datetimepicker1'>
								<input type='text' class="form-control" name='datetime1' id="datetime1" value="<?php echo $datetime1;?>" />
									<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
									</span>
							</div>
							
							<div class='input-group date smallerTextBox'  id='datetimepicker2'>
								<input type='text' class="form-control" name='datetime2' id="datetime2" value="<?php echo $datetime2;?>" />
									<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
									</span>
							</div>
						</div>
					</div>
					<script type="text/javascript">
						
					</script>
				</div>
			</div>
			
	</div>

			




	<script>

	$(function () {$('#datetimepicker1').datetimepicker();
	});

	$(function () {$('#datetimepicker2').datetimepicker();
	});



	try {
			// click Immediately for default value which will fill in dates automatic.
			$(".radioImmediatly").click();
			buildDropDown( "main_options", MAIN_OPTIONS );
			showForm();
		
		}
	catch(err) 
		{
		   // location.reload(true);
		   alert(err);
		}
		
		

	</script>



		
	</div>




	<!-- FORM SUBMISSION --> 
	<div class='box'>
		<input class="btn btn-primary" type="submit" id='createrequest' >
		<input class="btn btn-primary" type="button" onclick="delAllCookies(); location.reload(true); " value="Reset Form">
	</div>

</form>


<!-- Creates Pop-up using CSS -->





</body>


<footer>

<hr>
<p><em>If you need further assistance with your request, please do not hesitate to call the IS Operations team at (865) 777-8771.</em>
<!-- UPDATE TO REFLECT CURRENT REVISION OF PAGE -->


<p id="Revision" >Rev. 5.28.2015</p></p>
</footer>
<?php
if ($TierTwo->popup->notifyMessage()){}
?>


</div>


	
</html>



