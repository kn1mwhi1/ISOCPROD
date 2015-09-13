// Production version of javascript for Support Request Form

// *********************    CONSTANTS  ***************************

// main_options Constants
//var MAIN_OPTIONS = ["Select Option", "Job", "Stream", "File", "Other"];


// Request Type Constants
// var JOB_REQUEST_TYPE_OPTIONS = ["Submit_Predefined", "Release", "Rerun", "Hold", "Unhold", "Bypass", "Ignore_Alert", "Rerun", "Resubmit", "Cancel", "Information", "Kill"];
// var OTHER_REQUEST_TYPE_OPTIONS = ["Submit_Predefined", "Release", "Rerun", "Hold", "Unhold", "Bypass", "Ignore_Alert", "Rerun", "Resubmit", "Cancel", "Information", "Kill", "File_Transfer_Status", "Open_Ticket"];
// var STREAM_REQUEST_TYPE_OPTIONS = ["Submit_Predefined", "Release", "Rerun", "Hold", "Unhold", "Bypass", "Ignore_Alert", "Rerun", "Resubmit", "Cancel", "Information", "Kill"];
// var FILE_REQUEST_TYPE_OPTIONS = ["Resubmit", "Information", "Ignore_Alert", "File_Transfer_Status", "Restore_File", "Open_Ticket"];

// Environment Constants
// var JOB_ENVIRONMENT = ["PROD", "DEV", "TEST"];
// var STREAM_ENVIRONMENT = ["PROD", "DEV", "TEST"];
// var FILE_ENVIRONMENT = ["TWS", "AXWAY", "NETBACKUP"];
// var OTHER_ENVIRONMENT = ["PROD", "DEV", "TEST", "TWS", "AXWAY"];


// Dynamic Drop-down Request Type Constants BY SELECTION

/*
var BYPASS_SELECTION = ["Confirm failed job to success and allow successor job to run as scheduled.", 
						"Do not confirm failed job to success. Manually release dependent job immediately.",
						"Do not confirm failed job to success. Manually release dependent job when scheduled.", "N/A"]; 

var CANCEL_SELECTION = ["For specific Date/Time/Schedule",  "N/A"];

var FILE_TRANSFER_STATUS_SELECTION = ["For specific Date/Time/Schedule", "N/A"];

var HOLD_SELECTION = ["Do not manually release dependent jobs", "For ____ days", "For specific market", "For the rest of today's plan", 
					  "Manually release dependent jobs on schedule", "Until further notice", "Until mm/dd", "N/A"];
var IGNORE_SELECTION = ["Ignore Alert from ___ to ___."];
var INFORMATION_SELECTION = ["What are the predecessor dependencies for the job?", "What files were transferred by the job?",
							  "When was the last time the job ran and what was the status?", "N/A" ];

var KILL_SELECTION = ["Bypass job and continue with schedule", "Do not bypass job", "N/A"];

var OPEN_TICKET_SELECTION = ["For specific Date/Time/Schedule", "N/A"];

var RERUN_SELECTION = ["Do not execute successor job(s) upon completion", "Release dependencies", "N/A"];

var RELEASE_SELECTION = ["Do not execute successor job(s) upon completion", "Release dependencies", "N/A"];

var RESTORE_FILE_SELECTION = ["For specific Date/Time/Schedule", "N/A"];

var RESUBMIT_SELECTION = ["Do not execute successor job(s) upon completion", "Release dependencies", "N/A"];

var SUBMIT_PREDEFINED_SELECTION = ["Run job - no parameters needed", "Run job with (specific) parameters", "N/A"];

var UNHOLD_SELECTION = ["For next scheduled run", "Run immediately", "N/A"];
*/



// Responsible for clearing and rebuilding the options in select properties
function buildDropDown( propertyString, arrayOption )
{
	// get the property
	var x = document.getElementById(propertyString);

	// Remove all options in select
	x.options.length = 0;
	
	// Add Items
	for (i = 0; i < (arrayOption.length); i++) 
	{   
	   var temp = document.createElement("option");
	   temp.text=arrayOption[i];
	   temp.value=arrayOption[i];
		
		
		
		if ( temp.text != "null" )
		{
			x.add(temp);
		}
		
		
	}
}

function hideDiv( someDiv )
{
	var x = document.getElementById(someDiv );
	x.style.display="none";
}

function showDiv ( someDiv )
{
	var x = document.getElementById(someDiv );
	x.style.display="block";
}


// Hides all properties
function hideSelection(){
document.getElementById("div_dynamic_request_type").style.display="none";

}

function showSelection(){
document.getElementById("div_dynamic_request_type").style.display="inline";
document.getElementById("div_dynamic_request_type").style.height="50px";
}

function selectOptionDropDown(){

var dropdown = document.getElementById("main_options");
var current_value = dropdown.options[dropdown.selectedIndex].value;

// If Select Option is selected then hide the other details
if (current_value == "Select Option") 
{
    document.getElementById("container_environment_request_type").style.display = "none";
	
}
else
{
    document.getElementById("container_environment_request_type").style.display = "block";			
}
}


function selectRequestTypeDropDown(){

var dropdown_main_options = document.getElementById("main_options");
var current_value_main_options = dropdown_main_options.options[dropdown_main_options.selectedIndex].value;


switch(current_value_main_options) {
    case "Job":
		buildDropDown( "environment_opts", JOB_ENVIRONMENT );
        buildDropDown( "request_type_opts", JOB_REQUEST_TYPE_OPTIONS );
        break;
    case "Stream":
		buildDropDown( "environment_opts", STREAM_ENVIRONMENT );
        buildDropDown( "request_type_opts", STREAM_REQUEST_TYPE_OPTIONS );
        break;
	case "File":
		buildDropDown( "environment_opts", FILE_ENVIRONMENT );
        buildDropDown( "request_type_opts", FILE_REQUEST_TYPE_OPTIONS );
        break;
	case "Other":
		buildDropDown( "environment_opts", OTHER_ENVIRONMENT );
        buildDropDown( "request_type_opts", OTHER_REQUEST_TYPE_OPTIONS );
        break;
   default:
        hideSelection();
		return;
}


selectionValueRequestTypeDropDown();
}

function selectionValueRequestTypeDropDown(){

var dropdown_options = document.getElementById("request_type_opts");
var current_value_options = dropdown_options.options[dropdown_options.selectedIndex].value;
showSelection();

switch(current_value_options) {
    case "Submit Predefined":
        buildDropDown( "select_dynamic_request_type", SUBMIT_PREDEFINED_SELECTION );
        break;
	case "Rerun":
        buildDropDown( "select_dynamic_request_type", RERUN_SELECTION );
        break;
    case "Release":
        buildDropDown( "select_dynamic_request_type", RELEASE_SELECTION );
        break;
	case "Hold":
        buildDropDown( "select_dynamic_request_type", HOLD_SELECTION );
        break;
	case "Unhold":
        buildDropDown( "select_dynamic_request_type", UNHOLD_SELECTION );
        break;
	case "Bypass":
        buildDropDown( "select_dynamic_request_type", BYPASS_SELECTION );
        break;
	case "Ignore Alert":
        buildDropDown( "select_dynamic_request_type", IGNORE_SELECTION );
        break;
	case "Resubmit":
        buildDropDown( "select_dynamic_request_type", SUBMIT_PREDEFINED_SELECTION );
        break;
	case "Cancel":
        buildDropDown( "select_dynamic_request_type", CANCEL_SELECTION );
        break;
	case "Information":
        buildDropDown( "select_dynamic_request_type", INFORMATION_SELECTION );
        break;
	case "Kill":
        buildDropDown( "select_dynamic_request_type", KILL_SELECTION );
        break;
	case "File Transfer Status":
        buildDropDown( "select_dynamic_request_type", FILE_TRANSFER_STATUS_SELECTION );
        break;
	case "Restore File":
        buildDropDown( "select_dynamic_request_type", RESTORE_SELECTION );
        break;
	case "Open Ticket":
        buildDropDown( "select_dynamic_request_type", OPEN_TICKET_SELECTION );
        break;
}

}



function showForm(){
// Default hide all
hideDiv( 'calendarBottom' );
hideSelection();



// Shows or hides Request type and Environment drop down box
selectOptionDropDown();

// Remove and populate Request Type drop-down box and the environment drop down 
// box based upon user input in main option drop down box
selectRequestTypeDropDown();
}

function requestTypeSelection()
{
selectionValueRequestTypeDropDown();


}

function propertyDisabled( propertyString1,  propertyString2)
{
	var x = document.getElementById(propertyString1 );
	var y = document.getElementById(propertyString2 );
	
	  
	// Update value of inputs for Date

	x.value = getDateTime();
	y.value = getDateTime();	

	x.disabled = true;
	y.disabled = true;
}


function getDateTime()
{
	var timeNow = new Date();
    var year = timeNow.getFullYear();
    var day = timeNow.getDay();
    var month = timeNow.getMonth() + 1; 
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



function propertyEnabled( propertyString1, propertyString2 )
{
	var x = document.getElementById(propertyString1 );
	var y = document.getElementById(propertyString2 );

	x.disabled = false;
	y.disabled = false;
}






/*  ID's 

namebox
Contact_Number
Email
textboxSubject
teambox
contactMethod     <-- Phone or E-mail


main_options
eventIdName
environment_opts
request_type_opts
select_dynamic_request_type
detailsTextArea
Urgency  Immediate or not

datetime1
datetime2



*/


function getAllElementValues()
{
// Create Global Variables
name = document.getElementById('namebox').value;
contactNumber = document.getElementById('Contact_Number').value;
email = document.getElementById('Email').value;
userSubject = document.getElementById('textboxSubject').value;
contactMethod = document.getElementById('contactMethod').checked ? 'Phone' : 'E-mail';
mainOptions = document.getElementById('main_options').value;
textboxProcessName = document.getElementById('eventIdName').value;
environmentOptions = document.getElementById('environment_opts').value;
requestTypeOptions = document.getElementById('request_type_opts').value;
additionalQuestions = document.getElementById('select_dynamic_request_type').value;
textboxDetails = document.getElementById('detailsTextArea').value;
immediateFutureOption = document.getElementById('Urgency').checked ? 'Immediately' : 'In the future';
textboxDate1 = document.getElementById('datetime1').value;
textboxDate2 = document.getElementById('datetime2').value;

}

/*

function createEmailMessage()
{
var body = 		"You have a new request from: " 
				+ "\n"
				+ "\n"
				+ Name
				+ "\n"
				+ Contact_Number
				+ "\n"
				+ Email
				+ "\n"
				+ "Team CC'd: " + "\t" + teamSelect
				+ "\n"
				+ "Preferred contact method: " + "\t" + contact
				+ "\n"
				+ "\n"
				+ "___________________________________________________________"
				+ "\n"
				+ "\n"
				+ id + ': ' 
				+ "\n"
				+ idName
				+ "\n"
				+ "\n"
				+ "Request Type: " 
				+ "\t"	
				+ RequestType
				+ " --- "
				+ Action
				+ " --- Perform: "
				+ urgency1
				+ "\n"
				+ "\n"
				+ "Details:"
				+ "\n"
				+ originalDetails
				+ "\n"
				+ "\n"
				+ "___________________________________________________________"
				+ "\n"
				+ "V.04072015";

body = encodeURIComponent(body);		

}

function createEmailMessage2()
{

var body = 		"You have a new request from: " 
				+ "\n"
				+ "\n"
				+ Name
				+ "\n"
				+ Contact_Number
				+ "\n"
				+ Email
				+ "\n"
				+ "Team CC'd: " + "\t" + teamSelect
				+ "\n"
				+ "Preferred contact method: " + "\t" + contact
				+ "\n"
				+ "\n"
				+ "___________________________________________________________"
				+ "\n"
				+ "\n"
				+ id + ': ' 
				+ "\n"
				+ idName
				+ "\n"
				+ "\n"
				+ "Request Type: " 
				+ "\t"	
				+ RequestType
				+ " --- "
				+ Action
				+ " --- Perform: "
				+ urgency1
				+ "\n"
				+ "\n"
				+ "Details:"
				+ "\n"
				+ originalDetails
				+ "\n"
				+ "\n"
				+ "___________________________________________________________"
				+ "\n"
				+ "V.04072015";

body = encodeURIComponent(body);	
}


function createEmailMessage3()
{

var body = 		"You have a new request from: " 
				+ "\n"
				+ "\n"
				+ Name
				+ "\n"
				+ Contact_Number
				+ "\n"
				+ Email
				+ "\n"
				+ "Team CC'd: " + "\t" + teamSelect
				+ "\n"
				+ "Preferred contact method: " + "\t" + contact
				+ "\n"
				+ "\n"
				+ "___________________________________________________________"
				+ "\n"
				+ "\n"
				+ "Request Type: " 
				+ "\t"	
				+ RequestType
				+ " --- "
				+ Action
				+ " --- Perform: "
				+ urgency1
				+ "\n"
				+ "\n"
				+ "Details:"
				+ "\n"
				+ originalDetails
				+ "\n"
				+ "\n"
				+ "___________________________________________________________"
				+ "\n"
				+ "V.04072015";

	body = encodeURIComponent(body);	
}

function createEmailMessage4()
{

var body = 		"You have a new request from: " 
				+ "\n"
				+ "\n"
				+ Name
				+ "\n"
				+ Contact_Number
				+ "\n"
				+ Email
				+ "\n"
				+ "Team CC'd: " + "\t" + teamSelect
				+ "\n"
				+ "Preferred contact method: " + "\t" + contact
				+ "\n"
				+ "\n"
				+ "___________________________________________________________"
				+ "\n"
				+ "\n"
				+ "Request Type: " 
				+ "\t"	
				+ RequestType
				+ " --- "
				+ Action
				+ " --- Perform: "
				+ urgency1
				+ "\n"
				+ "\n"
				+ "Details:"
				+ "\n"
				+ originalDetails
				+ "\n"
				+ "\n"
				+ "___________________________________________________________"
				+ "\n"
				+ "V.04072015";

	body = encodeURIComponent(body);	
	}
}




function sendEmail()
{

	
	if (cc == '')
	{
		window.location.href = "mailto:isoperationscenter@uscellular.com?body="+body+"&cc=" + teamSelect + "&subject="+subject;
	}
	else
	{
		window.location.href = "mailto:isoperationscenter@uscellular.com?body="+body+"&cc=" + cc + ";" + teamSelect + "&subject="+subject;
	}
	

}


*/





// This function gathers the information input on the form and compiles it into a message to the IS Operations team. 
function submitRequest() 
{

// Get all Data
getAllElementValues();





}








/*
function blahh() {




// Pulls the request type from the form and places it in the variable 'RequestType'
var RequestType = document.input_form.RequestType.value;
	if (RequestType == "BounceDaemon")
		{
			var Action = document.input_form.BounceDaemon.value;
		}
	else if (RequestType == "Bypass")
		{
			var Action = document.input_form.Bypass.value;
		}
	else if (RequestType == "Cancel")
		{	
			var Action = document.input_form.Cancel.value;
		}
	else if (RequestType == "Hold")
		{
			var Action = document.input_form.Hold.value;
		}
	else if (RequestType == "Information")
		{
			var Action = document.input_form.Information.value;
		}
	else if (RequestType == "Kill")
		{
			var Action = document.input_form.Kill.value;
		}
	else if (RequestType == "Rerun")
		{
			var Action = document.input_form.Rerun.value;
		}
	else if (RequestType == "Release")
		{
			var Action = document.input_form.Release.value;
		}
	else if (RequestType == "Submit_Predefined")
		{
			var Action = document.input_form.Submit_Predefined.value;
		}
	else if (RequestType == "AMC_Billing_Request")
		{
			var Action = document.input_form.AMC_Billing_Request.value;
		}
	else if (RequestType == "Unhold")
		{
			var Action = document.input_form.Unhold.value;
		}
	else { var Action = "Null - No item selected"; }
	
	
// Variables to hold information from form
	var Urgency = document.getElementById('Urgency')[0].checked ? 'Immediately' : 'In the future';
	var originalDetails = document.getElementById('detailsTextArea').value;
	var cc = document.getElementById('Email').value;
	var teamSelect = document.getElementById('teambox').value;
	var contact = document.getElementById('contactMethod')[0].checked? 'Phone' : 'E-mail';
	
	var id = getRadioValue();
	
	var idName = document.input_form.eventIdName.value;
	var date1 = document.input_form.datepick_1.value;
	var date2 = document.input_form.datepick_2.value;

// If Urgency is 'In the future', a start date is entered and a second date is not entered, this is a single-day request and the first date is loaded into the urgency1 variable.
if (Urgency == 'In the future' && date1 != '(If Applicable)' && date2 == '(If Applicable)')
{
	var urgency1 = date1;
}
// If Urgency is 'In the future' and date1 and date2 have dates entered, then it is a multiple day request and both dates are entered into the urgency1 variable.
else if (Urgency == 'In the future' && date1 != '(If Applicable)' && date2 != '(If Applicable)') 
{
	var urgency1 = date1 + " - " + date2
}
// If Urgency is 'In the future' and no dates are selected, then an error message prompts the user to check and update the date fields.
else if (Urgency == 'In the future' && date1 == '(If Applicable)' && date2 != '(If Applicable)')
{
	alert("Please enter the starting date.");
	return;
}
else
{
	var urgency1 = 'Immediately';
}

	
// This section determines which options are selected and creates an appropriate subject line for the e-mail that is sent to IS Operations (isoperationscenter@uscellular.com)
if (idName != '(If Applicable)') {
var idNameReplace = idName;
idNameReplace = idNameReplace.replace(/\n/g, " ");
var subject = "New ISOC Support Request: " + idNameReplace  + " - " + '(' + RequestType + " : " + Action + ') - ' + UserSubject + ' - ' + 'Date/Time Requested: ' + urgency1;
	}
	else
	{
	
var subject = "New ISOC Support Request: " + '(' + RequestType + " : " + Action + ') - ' + UserSubject + ' - ' + 'Date/Time Requested: ' + urgency1;

}


var checked = false;

// If a job/process/stream/daemon is selected but the name of that selection is not entered, a message is displayed to the user that one needs to be entered.
for (var i=0; i<document.input_form.eventId.length; i++) {
if (document.input_form.eventId[i].checked) {
checked = true;
}
}



if (checked == true && idName == '(If Applicable)') 
{
alert ("Please enter the name of the job/stream/process/daemon before continuing. This will ensure we are able to accurately and effectively process your request.")
return false;
}
else if (checked == false && idName != '(If Applicable)')
{
alert ("Please select an option (Job / Process / Stream / Daemon) so that your request can be completed.")
return false;
}
else
{

}







// This section creates the e-mail that is sent to IS Ops (isoperationscenter@uscellular.com) depending on what options were selection and what information was entered by the user.

if (Urgency == 'In the future' && date1 == '(If Applicable)' && date2 == '(If Applicable)')
//if (document.input_form.Urgency.value = 'undefined')
{
alert ('Please select when you would like for your request to be processed.');
return false;
}



if (idName != '(If Applicable)')
{
var body = 		"You have a new request from: " 
				+ "\n"
				+ "\n"
				+ Name
				+ "\n"
				+ Contact_Number
				+ "\n"
				+ Email
				+ "\n"
				+ "Team CC'd: " + "\t" + teamSelect
				+ "\n"
				+ "Preferred contact method: " + "\t" + contact
				+ "\n"
				+ "\n"
				+ "___________________________________________________________"
				+ "\n"
				+ "\n"
				+ id + ': ' 
				+ "\n"
				+ idName
				+ "\n"
				+ "\n"
				+ "Request Type: " 
				+ "\t"	
				+ RequestType
				+ " --- "
				+ Action
				+ " --- Perform: "
				+ urgency1
				+ "\n"
				+ "\n"
				+ "Details:"
				+ "\n"
				+ originalDetails
				+ "\n"
				+ "\n"
				+ "___________________________________________________________"
				+ "\n"
				+ "V.04072015";

body = encodeURIComponent(body);			

	}

else
	{
	var body = 		"You have a new request from: " 
				+ "\n"
				+ "\n"
				+ Name
				+ "\n"
				+ Contact_Number
				+ "\n"
				+ Email
				+ "\n"
				+ "Team CC'd: " + "\t" + teamSelect
				+ "\n"
				+ "Preferred contact method: " + "\t" + contact
				+ "\n"
				+ "\n"
				+ "___________________________________________________________"
				+ "\n"
				+ "\n"
				+ "Request Type: " 
				+ "\t"	
				+ RequestType
				+ " --- "
				+ Action
				+ " --- Perform: "
				+ urgency1
				+ "\n"
				+ "\n"
				+ "Details:"
				+ "\n"
				+ originalDetails
				+ "\n"
				+ "\n"
				+ "___________________________________________________________"
				+ "\n"
				+ "V.04072015";

	body = encodeURIComponent(body);	
	}



	if (cc == '')
	{
		window.location.href = "mailto:isoperationscenter@uscellular.com?body="+body+"&cc=" + teamSelect + "&subject="+subject;
	}
	else
	{
		window.location.href = "mailto:isoperationscenter@uscellular.com?body="+body+"&cc=" + cc + ";" + teamSelect + "&subject="+subject;
	}
	
	
	}
	
}	



function getRadioValue()
{
    for (var i = 0; i < document.getElementsByName('eventId').length; i++)
    {
    	if (document.getElementsByName('eventId')[i].checked)
    	{
    		return document.getElementsByName('eventId')[i].value;
    	}
    }
}




//***********Cookie Stuff ******************
function setCookie(NameOfCookie, value, expiredays)
{ 
if(document.contact_form.namebox.value != "") {
var ExpireDate = new Date ();
ExpireDate.setTime(ExpireDate.getTime() + (expiredays * 24 * 3600 * 1000));
document.cookie = NameOfCookie + "=" + escape(value) + 
((expiredays == null) ? "" : "; expires=" + ExpireDate.toGMTString());
window.status="Your information has been saved.";
}
else
{
return;
}
}

function delCookie (NameOfCookie) 
{ 
if (getCookie(NameOfCookie)) {
document.cookie = NameOfCookie + "=" +
"; expires=Thu, 01-Jan-70 00:00:01 GMT";
}
}

function getCookie(NameOfCookie)
{ 
	if (document.cookie.length > 0) 
	{ 
		begin = document.cookie.indexOf(NameOfCookie+"="); 
		
		if (begin != -1) 
		{ 
			begin += NameOfCookie.length+1; 
			end = document.cookie.indexOf(";", begin);
			
			
			if (end == -1) 
			{
				end = document.cookie.length;
				return unescape(document.cookie.substring(begin, end));
			}
		} 
	}
	
	return null; 
}












function DoTheCookieStuff()
{

	Name=getCookie('Name');
	if (Name!=null) 
		 {document.contact_form.namebox.value = Name;}
	 
	ContactNumber=getCookie('ContactNumber');
	
	if (ContactNumber!=null)
		{document.contact_form.numberbox.value = ContactNumber;}

	Email=getCookie('Email');
	
	if (Email!=null)
		{document.contact_form.emailbox.value = Email;}

		Team=getCookie('Team');
	
	if (Team!=null)
	{document.contact_form.teambox.value = Team;}
	
DoTheContactCookieStuff();

}









function DoTheContactCookieStuff()
{
	ContactCookie=getCookie('ContactCookie')
	if(ContactCookie == 'Phone')
	{
		document.getElementsByName("contactMethod")[0].checked = true;
	}
	else
	{
		document.getElementsByName("contactMethod")[1].checked = true;
	}
}






function setContactMethodCookie()
{
var ContactMethodSelect = document.getElementsByName("contactMethod")[0].checked? 'Phone' : 'E-mail';
setCookie('ContactCookie', ContactMethodSelect, 365);
}




*/