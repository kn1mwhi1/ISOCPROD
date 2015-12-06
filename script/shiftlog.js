document.write('<script type="text/javascript" src="script/sweetalert.min.js"></script>');  

 // Global Variables
 
 selection = 'Current Calls';
 viewSelection = 'Your View';
 temp ='';
 ID='';

// function to show calendar
$(function () {	
	$('#datetime1Input').datetimepicker({
		
		minDate: getServerDateTime('CURRENT TIME'),
		format: 'MM/DD/YYYY H:mm'
	});
	
	});
	
	

 // When document has loaded run ajax command every second.
$(document).ready(function(){

     setInterval(ajaxcall, 1000);
 });
 
 // When document has loaded run ajax command every second.
$(document).ready(function(){

     setInterval(getServerTimeCentral, 1000);
 });
 


 function ajaxcall(){
     $.ajax({
		 type: "POST",
         url: 'lib/shiftLogApi.php',
		 data:{ submit : selection, view : viewSelection },
         success: function(someData){
			
				if ( temp != someData)
				{
					 $(dynamicTable).html(someData);
					 temp = someData;
				 }
         }
     });
 }
 
 
  function ajaxButton( buttonType, aValue ){
     $.ajax({
		 type: "POST",
         url: 'lib/shiftLogApi.php',
		 data:{ buttonType : aValue, EVENT_ID : ticketID },
         success: function(someData){
			 
			// alert('buttonType: ' + buttonType + 'aValue: ' + aValue + 'ticket: ' + EVENT_ID + 'ticketID: ' + ticketID );
			 
			 
					//			swal("Change Successful!", "Your change was successful!", "success"); 
			
         }
     });
 }
 

 
 function clearAllValues()
 {
	
	

	
	$('#initiatorInput').val("");
	$('#actionRequiredInput').val("");
	$('#reference').val('IM');				
	$('#datetime1').val("");

	$( "#datetime1Input" ).val("");
	$('#method').val('IM');
	$('#personContacted').val('');
	$('#notes').val('');
	$('#ticketNumber').val( '');
 }
 

 

 
	// convert a mysql time and date to a customer time and date
   function convertDate( dateTime )
   {
		// Split timestamp into [ Y, M, D, h, m, s ]
		var t = dateTime.split(/[- :]/);

		// Apply each element to the Date function
		var timeNow = new Date(t[0], t[1], t[2], t[3], t[4], t[5]);

		timeString = t[1] + '/' + t[2] + '/' + t[0] + ' ' + t[3] + ':' + t[4] + ':' + t[5];
		
		return timeString;
   }
   

 


// ******************  Click Event Handlers *****************************************

   
$(document).on('click', '.clear', function () {
   $( ".updateCall" ).hide();
   $( ".delete" ).hide();
   $( ".addCall" ).show();
   clearAllValues();
});



 $(document).on('click', '.allDays', function () {
	selection = 'ALL DAYS';
		$('.allDays').addClass('highlight');
		$('.sevenDays').removeClass('highlight');
		$('.twelveHours').removeClass('highlight');
		$('.oneDay').removeClass('highlight');
		$('.fifteenDays').removeClass('highlight');
		clearAllValues();
});

 $(document).on('click', '.allCalls', function () {
	selection = 'All Events';
		$('.allCalls').addClass('highlight');
		$('.sevenDays').removeClass('highlight');
		$('.twelveHours').removeClass('highlight');
		$('.oneDay').removeClass('highlight');
		$('.fifteenDays').removeClass('highlight');
		clearAllValues();
});


 $(document).on('click', '.thirtyDays', function () {
	selection = 'All Events';
		$('.thirtyDays').addClass('highlight');
		$('.sevenDays').removeClass('highlight');
		$('.twelveHours').removeClass('highlight');
		$('.oneDay').removeClass('highlight');
		$('.fifteenDays').removeClass('highlight');
		clearAllValues();
});


 $(document).on('click', '.fifteenDays', function () {
	selection = 'Current Events';
		$('.fifteenDays').addClass('highlight');
		$('.sevenDays').removeClass('highlight');
		$('.twelveHours').removeClass('highlight');
		$('.oneDay').removeClass('highlight');
		$('.thirtyDays').removeClass('highlight');
		clearAllValues();
});


$(document).on('click', '.sevenDays', function () {
	selection = 'Completed Events';
		$('.sevenDays').addClass('highlight');
		$('.fifteenDays').removeClass('highlight');
		$('.twelveHours').removeClass('highlight');
		$('.oneDay').removeClass('highlight');
		$('.thirtyDays').removeClass('highlight');
		clearAllValues();
});

$(document).on('click', '.oneDay', function () {
	selection = '1 DAY';
		$('.oneDay').addClass('highlight');
		$('.fifteenDays').removeClass('highlight');
		$('.twelveHours').removeClass('highlight');
		$('.sevenDays').removeClass('highlight');
		$('.thirtyDays').removeClass('highlight');
		clearAllValues();
});



$(document).on('click', '.twelveHours', function () {
		$('.twelveHours').addClass('highlight');
		$('.fifteenDays').removeClass('highlight');
		$('.oneDay').removeClass('highlight');
		$('.sevenDays').removeClass('highlight');
		$('.thirtyDays').removeClass('highlight');
		clearAllValues();
		selection = 'Current Calls';
});




// *****  selfView and everyoneView button
$(document).on('click', '.selfView', function () {

	$('.selfView').addClass('highlight');
	$('.everyoneView').removeClass('highlight');
	clearAllValues();
	viewSelection = 'Your View';
});

$(document).on('click', '.everyoneView', function () {
	
	$('.everyoneView').addClass('highlight');
	$('.selfView').removeClass('highlight');
	clearAllValues();
	viewSelection = 'Everyone View';
});




function checkIfEmptyAndValidateOnupdateCallSend()
{
	if ( $( "#personContacted" ).val() == '' )
	{
		$( "#personContacted" ).addClass( "error" );
	}
	
	if($( "#notes" ).val() == '' )
	{
		$( "#notes" ).addClass( "error" );
	}
	
	if ($( "#datetime1Input" ).val() == '')
	{
		$( "#datetime1Input" ).addClass( "error" );	
	}

	if ( $( "#personContacted" ).hasClass( "error" ) ||
	$( "#notes" ).hasClass( "error" ) ||
	$( "#datetime1Input" ).hasClass( "error" ) )
	{
		swal("Oops", "Please fill out all required fields correctly", "error");
		return false;
	}
	
	return true;
}

// Fix the issue where table columns were not updating when the window was resized.

$( window ).resize(function() {
  //alert('Resize has cicked off');
  $('#table').bootstrapTable('resetView', '460');
});


function validation( aHtmlElementName, typeOfValidation )
{
	   
	   // get value and assign to aHtmlValue
	   var aHtmlValue = $(aHtmlElementName).val();
	   
	   //alert('The value is:' + aHtmlValue + ' The id is ' + aHtmlElementName.id );
	   
	   $.ajax({
			 type: "POST",
			 url: "lib/shiftLogApi.php",
			 data: { submit : 'VALIDATION', OBJECT_NAME : aHtmlElementName.id, VALUE : aHtmlValue , TYPE : typeOfValidation },
			 success: function(data){
					//alert(data);
					var someData = JSON.parse(data);
					
					var passOrFail = someData.PASS_VALIDATION;
					var cleanValue = someData.VALUE;
				
					
					if (passOrFail == 'false')
					{
						//alert(someData.PASS_VALIDATION);
						$(aHtmlElementName).addClass('error');
						$(aHtmlElementName).val(cleanValue);
					}
					else
					{
						$(aHtmlElementName).removeClass('error');
						$(aHtmlElementName).val(cleanValue);
						
					}
					
					
			 }
		 });
}


function getServerDateTime( time )
{	   
	   $.ajax({
			 type: "POST",
			 url: "lib/shiftLogApi.php",
			 data: { submit : time },
			 success: function(data){
					//alert(data);
					var someData = JSON.parse(data);
					
					currentServerTime = someData.SERVER_TIME
				
					//alert(currentServerTime);
					$( "#datetime1" ).val( convertDate(currentServerTime) );
					$( "#datetime2" ).val( convertDate(currentServerTime) );
					return currentServerTime;
					
					
			 }
		 });
}




// Retrieve Central Time , so it can be displayed
function getServerTimeCentral()
{
	   $.ajax({
			 type: "POST",
			 url: "lib/shiftLogApi.php",
			 data: { submit : 'CURRENT TIME' },
			 success: function(data){
					//alert(data);
					var someData = JSON.parse(data);
					
					var currentServerTime = someData.SERVER_TIME
				
					//alert(currentServerTime);
					$('#serverTimeCentral').html(convertDate(currentServerTime) + ' Central Time');
			 }
		 });
}




// When user clicks on table loads ticket info into controls
 $(document).on('click', '.clickMe', function () {
			var postID = this.id;
			//alert(postID);

// Ajax function that passes the ID to the shiftlogAPI which will return several variables.
	   $.ajax({
			 type: "POST",
			 url: "lib/shiftLogApi.php",
			 data: { ID : postID },
			 success: function(data){
					
					var someData = JSON.parse(data);
					
					// Variables that represent the row that was  clicked on in Table
					ID = someData.ID;
					DATE_TIME = someData.DATE_TIME;
					METHOD = someData.METHOD;
					PERSON_CONTACTED = someData.PERSON_CONTACTED;
					NOTES = someData.NOTES;
					TICKET = someData.TICKET;
					USER = someData.USER;
				
					//alert(ID);
					
					// Clear old info in controls
					clearAllValues();
					
					// populate values from database to controls
					$( "#datetime1Input" ).val( DATE_TIME );
					$('#method').val( METHOD);
					$('#personContacted').val( PERSON_CONTACTED);
					$('#notes').val( NOTES);
					$('#ticketNumber').val( TICKET);
			 }
		 });

		 
			$( ".updateCall" ).show();
			 $( ".delete" ).show();
});


// Insert or addCall new event
$(document).on('click', '.addCall', function () {
	/*
	if (!checkIfEmptyAndValidateOnupdateCallSend() )
	{
		return;
	}
	*/
	
		input_DATE_TIME = $( "#datetime1Input" ).val();
		input_METHOD = $('#method').val( );
		input_PERSON_CONTACTED = $('#personContacted').val();
		input_NOTES = $('#notes').val();
		input_TICKET = $('#ticketNumber').val();
				
							$.ajax({
									type: "POST",
									url: 'lib/shiftLogApi.php',
									data:{ submit : 'Add Call', DATE_TIME : input_DATE_TIME, METHOD : input_METHOD, PERSON_CONTACTED : input_PERSON_CONTACTED, NOTES : input_PERSON_CONTACTED, TICKET : input_TICKET}
								  });
		
clearAllValues();
});



// Update to Database from controls
$(document).on('click', '.updateCall', function () {
	/*
	if (!checkIfEmptyAndValidateOnupdateCallSend() )
	{
		return;
	}
	*/
		input_Primary_Key = ID;
		input_DATE_TIME = $( "#datetime1Input" ).val();
		input_METHOD = $('#method').val( );
		input_PERSON_CONTACTED = $('#personContacted').val();
		input_NOTES = $('#notes').val();
		input_TICKET = $('#ticketNumber').val();  // Reference ticket number


							$.ajax({
									type: "POST",
									url: 'lib/shiftLogApi.php',
									data:{ submit : 'Update Call', TICKET_NUMBER : input_Primary_Key, DATE_TIME : input_DATE_TIME, 
									METHOD : input_METHOD, PERSON_CONTACTED : input_PERSON_CONTACTED, NOTES : input_NOTES, TICKET : input_TICKET },
									 success: function(data){
					//alert(data);

					
									 }
					
								  });

// do button stuffs
  $( ".updateCall" ).hide();
   $( ".clear" ).show();
   $( ".addCall" ).show();
  clearAllValues();
});


// Delete a row
$(document).on('click', '.delete', function () {
	/*
	if (!checkIfEmptyAndValidateOnupdateCallSend() )
	{
		return;
	}
	*/		
		
	swal({   
	title: "Delete Entry?",   
	text: "Are you sure you want to delete the entry?" ,   
	type: "info",   
	showCancelButton: true,   
	closeOnConfirm: false,   
	showLoaderOnConfirm: true, }, 
	function(){   
	setTimeout(function(){ 

							$.ajax({
									type: "POST",
									url: 'lib/shiftLogApi.php',
									data:{ submit : 'Delete', PRIMARY_KEY : ID }
								  })
									  .done(function(data) {
										swal("Call Deleted!", "The call has been successfully Deleted.", "success");
									
									  })
									  .error(function(data) {
										swal("Oops", "We couldn't connect to the server!", "error");
									  });
								  
								}, 1000); 
	});
		
  
clearAllValues();
	$('.delete').hide();
	$('.updateCall').hide();
});



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
   
  $(document).on('click', '.spanIcon', function () {
	
	$('#datetime1Input').val( getDateTime() );

});
