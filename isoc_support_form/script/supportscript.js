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
document.getElementById("container_environment_request_type").style.display="none";


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
    var day = timeNow.getDate();
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





// This function gathers the information input on the form and compiles it into a message to the IS Operations team. 
function submitRequest() 
{

// Get all Data
getAllElementValues();

}



//***********Cookie Stuff ******************


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

// replace any semicolons and spaces with commas
function cleanEmail( value )
{
	var value = value.replace(/[^a-zA-Z0-9|\.@]/g, "");
	return value;
}

// replace any semicolons and spaces with commas
function cleanCCEmail( value )
{
	var value = value.replace(/;+\s*|,,+|\s\s+/g,',');
	value = value.replace(/[*+?^${}()\s-;&%#!=`~|[\]\\]/g,'');
	return value;
}


// replace any semicolons and spaces with commas
function cleanContactNumber( value )
{
	// Anything in squar brackets looks for one of, kinda like [0-9] <- searches all numbers 0 through 9
	var value = value.replace(/[.*+?^${}()\s-\;&%#@!=`~,|[\]\\_]/g,'');
	return value;
}



function setCookie(NameOfCookie, value, expiredays)
{ 
	
		var ExpireDate = new Date ();
		ExpireDate.setTime(ExpireDate.getTime() + (expiredays * 24 * 3600 * 1000));
		document.cookie = NameOfCookie + "=" + value + ((expiredays == null) ? "" : "; expires=" + ExpireDate.toGMTString());
		window.status="Your information has been saved.";

}


// Single delete of a cookie , input is the name of the cookie
function delCookie(NameOfCookie) 
{ 
	if (getCookie(NameOfCookie)) 
	{
		document.cookie = NameOfCookie + "=" + "; expires=Thu, 01-Jan-70 00:00:01 GMT";
	}
}

// Deletes all cookies that Form has created.   This is called when the user presses the Reset Form button.
function delAllCookies()
{
	delCookie('namebox');
	delCookie('Contact_Number');
	delCookie('Email');
	delCookie('textboxSubject');
	delCookie('textboxCC');
	
	delCookie('contactMethod');
	
	
	delCookie('main_options');
	delCookie('eventIdName');
	delCookie('environment_opts');
	delCookie('request_type_opts');
	delCookie('select_dynamic_request_type');
	delCookie('detailsTextArea');
	delCookie('Urgency');
	delCookie('datetime1');
	delCookie('datetime2');
}


function getCookie(name)
  {
    var re = new RegExp(name + "=([^;]+)");
    var value = re.exec(document.cookie);
    return (value != null) ? unescape(value[1]) : null;
  }


//
function loadCookies()
{

document.getElementById('namebox').value = getCookie("namebox");
document.getElementById('Contact_Number').value = getCookie("Contact_Number");
document.getElementById('Email').value = getCookie("Email");
document.getElementById('textboxSubject').value = getCookie("textboxSubject");
document.getElementById('textboxCC').value = getCookie("textboxCC");

document.getElementById('contactMethod').checked  = getCookie("contactMethod");

document.getElementById('main_options').selectedIndex = getCookie("main_options");
document.getElementById('eventIdName').value = getCookie("eventIdName");
document.getElementById('environment_opts').value = getCookie("environment_opts");
document.getElementById('request_type_opts').value = getCookie("request_type_opts");
document.getElementById('select_dynamic_request_type').value = getCookie("select_dynamic_request_type");
document.getElementById('detailsTextArea').value = getCookie("detailsTextArea");
document.getElementById('Urgency').checked = getCookie("Urgency");
document.getElementById('datetime1').value = getCookie("datetime1");
document.getElementById('datetime2').value = getCookie("datetime2");

// Populate Hide and Show
showForm();

}


// *************************************  Testing Functions ****************************************************
function popupwindow(url, title, w, h) 
{
    var w = 200;
    var h = 200;
    var left = Number((screen.width/2)-(w/2));
    var tops = Number((screen.height/2)-(h/2));

window.open("pop.htm", '', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+tops+', left='+left);
}

function thanksDiv()
{
	document.getElementById("myThanksDiv").style.display ='block';
	setTimeout("hideDiv('myThanksDiv')",9999);
	//js url relocation here if desired
	//hide the form by putting it in div and changing it's display state.
}

function hideDiv(id)
{
	document.getElementById(id).style.display='none';
}



