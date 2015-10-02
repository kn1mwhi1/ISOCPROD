document.write('<script type="text/javascript" src="script/sweetalert.min.js"></script>');  

 // Global Variables
 
 selection = 'Current Events';
 viewSelection = 'Normal View';
 temp ='';


// function to show calendar
$(function () {	
	$('#datetimepicker1').datetimepicker({
		
		minDate: getServerDateTime('CURRENT TIME'),
		format: 'MM/DD/YYYY H:mm:ss'
	});
	
	});
	
	
	
	$(function () {	
	$('#datetimepicker2').datetimepicker({
		
		minDate: getServerDateTime('CURRENT TIME'),
		format: 'MM/DD/YYYY H:mm:ss'
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
         url: 'lib/eventLogApi.php',
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
         url: 'lib/eventLogApi.php',
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
	$('#datetime2').val("");		
	$('#noEndDateInput').val("");
	 // Show edit menu		 
	$( ".completeMenu" ).hide();
	// Show edit menu
	$( ".complete" ).hide();		 
	$( ".cancel" ).hide();
	//$( ".activeButton" ).hide();
	$( ".update" ).hide();
   $( ".add" ).show();
   $('#noEndDateInput').prop('checked', false);
   $('#completeNotes').val("");
   
   // remove any error classes
   $('#initiatorInput').removeClass('error');
    $('#actionRequiredInput').removeClass('error');
	 $('#datetime1').removeClass('error');
	  $('#datetime2').removeClass('error');
 }
 

 

 
	// convert a mysql time and date to a customer time and date
   function convertDate( dateTime )
   {
		// Split timestamp into [ Y, M, D, h, m, s ]
		var t = dateTime.split(/[- :]/);

		// Apply each element to the Date function
		var timeNow = new Date(t[0], t[1], t[2], t[3], t[4], t[5]);
		/*
		var year = timeNow.getFullYear();
		var day = timeNow.getDate();
		var month = timeNow.getMonth(); 
		if (month == '00')
		{
			month = 12;
			year = year - 1;
		}
		
		var hours   = timeNow.getHours();
		var minutes = timeNow.getMinutes();
		var timeString = ( month < 10) ? "0" + month + "/" : month + "/";
	   
		timeString += (day < 10 ) ? "0" + day + "/" : day + "/" ;
		timeString += year + " ";
		timeString += "" + ((hours > 12) ? hours - 12 : hours);
		timeString += ((minutes < 10) ? ":0" : ":") + minutes;
		timeString += (hours >= 12) ? " PM" : " AM";
		//alert(dateTime);
		*/
		timeString = t[1] + '/' + t[2] + '/' + t[0] + ' ' + t[3] + ':' + t[4] + ':' + t[5];
		
		return timeString;
   }
   
  /* 
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
   
   */
   /*
   function getSixtyDays()
{
	var timeNow = new Date();
    var year = timeNow.getFullYear();
    var day = timeNow.getDate();
    var month = timeNow.getMonth() + 3; 
    var hours   = timeNow.getHours();
    var minutes = timeNow.getMinutes();
	
	// ensure that mont is not over 12 months
	if (month > 12)
	{
		month = month - 12;
	}
	
    var timeString = ( month < 10) ? "0" + month + "/" : month + "/";
    timeString += (day < 10 ) ? "0" + day + "/" : day + "/" ;
    timeString += year + " ";
    timeString += "" + ((hours > 12) ? hours - 12 : hours);
    timeString += ((minutes < 10) ? ":0" : ":") + minutes;
    timeString += (hours >= 12) ? " PM" : " AM";
	
	return timeString;
}
*/





// ******************  Click Event Handlers *****************************************

   
$(document).on('click', '.clear', function () {
   $( ".update" ).hide();
   //$( ".clear" ).hide();
   $( ".add" ).show();
   clearAllValues();
   $('#noEndDateInput').prop('checked', false);
   $( "#datetimepicker2" ).show();
   
});


$(document).on('click', '#noEndDateInput', function () {
	
	if ($('#noEndDateInput').is(':checked')) 
	{
		
		$( "#datetime2" ).val( getServer60Days('SIXTY DAYS') );
	    $( "#datetimepicker2" ).hide();
	}
	else
	{
		$( "#datetimepicker2" ).show();
	}
	
});


 $(document).on('click', '.allEvents', function () {
	selection = 'All Events';
		$('.allEvents').addClass('highlight');
		$('.completedEvents').removeClass('highlight');
		$('.pendingEvents').removeClass('highlight');
		$('.expiredEvents').removeClass('highlight');
		$('.currentEvents').removeClass('highlight');
		clearAllValues();
});


 $(document).on('click', '.currentEvents', function () {
	selection = 'Current Events';
		$('.currentEvents').addClass('highlight');
		$('.completedEvents').removeClass('highlight');
		$('.pendingEvents').removeClass('highlight');
		$('.expiredEvents').removeClass('highlight');
		$('.allEvents').removeClass('highlight');
		clearAllValues();
});


   
// Cancel button event
$(document).on('click', '.cancel', function () {

	swal({   
	title: "Cancel Event?",   
	text: "Are you sure you want to cancel Event Ticket: " + ticketID + " ?" ,   
	type: "info",   
	showCancelButton: true,   
	closeOnConfirm: false,   
	showLoaderOnConfirm: true, }, 
	function(){   
	setTimeout(function(){ 

							$.ajax({
									type: "POST",
									url: 'lib/eventLogApi.php',
									data:{ submit : 'CANCEL', EVENT_ID : ticketID }
								  })
									  .done(function(data) {
										swal("Canceled!", "The event has been canceled!", "success");
									
									  })
									  .error(function(data) {
										swal("Oops", "We couldn't connect to the server!", "error");
									  });
								  
								}, 2000); 
	});


});



// Cancel button event
$(document).on('click', '.complete', function () {
	// get compeletion notes
	completeNotes = $('#completeNotes').val();

	swal({   
	title: "Complete the Event?",   
	text: "Are you sure you want to complete Event Ticket: " + ticketID + " ?" ,   
	type: "info",   
	showCancelButton: true,   
	closeOnConfirm: false,   
	showLoaderOnConfirm: true, }, 
	function(){   
	setTimeout(function(){ 

							$.ajax({
									type: "POST",
									url: 'lib/eventLogApi.php',
									data:{ submit : 'COMPLETED', EVENT_ID : ticketID, COMPLETION_NOTES : completeNotes }
								  })
									  .done(function(data) {
										swal("Success!", "The event has been successfully completed.", "success");
									
									  })
									  .error(function(data) {
										swal("Oops", "We couldn't connect to the server!", "error");
									  });
								  
								}, 2000); 
	});

clearAllValues();
});


// Insert or Add new event
$(document).on('click', '.add', function () {
	
	
	
	if (!checkIfEmptyAndValidateOnUpdateSend() )
	{
		return;
	}
		
	
	
	
		//ticketID = someData.EVENT_ID;
		startTime = $('#datetime1').val();
		endTime = $('#datetime2').val();
		noEndTime = $('#noEndDateInput').is(':checked');
		status = 'PENDING'; 
		referenceData = $('#reference').val();
		initiator = $('#initiatorInput').val();
		actionRequired = $('#actionRequiredInput').val();
		//completeNotes = $('#completeNotes').val();

			
		
		
		swal({   
	title: "Adding Event",   
	text: "One moment while the event is being added to the database" ,   
	type: "info",   
	showCancelButton: false,   
	closeOnConfirm: false,   
	showLoaderOnConfirm: true, }, 
	function(){   
	setTimeout(function(){ 

							$.ajax({
									type: "POST",
									url: 'lib/eventLogApi.php',
									data:{ submit : 'ADD EVENT', START_DATETIME : startTime, END_DATETIME : endTime, 
									NO_ENDDATE : noEndTime, STATUS : status, REFERENCE : referenceData, INITIATOR : initiator, ACTION_REQUIRED : actionRequired }
								  })
									  .done(function(data) {
										swal("Event Added!", "The event has been successfully added.", "success");
									
									  })
									  .error(function(data) {
										swal("Oops", "We couldn't connect to the server!", "error");
									  });
								  
								}, 2000); 
	});
		

clearAllValues();
});


// Insert or Add new event
$(document).on('click', '.update', function () {
	
	if (!checkIfEmptyAndValidateOnUpdateSend() )
	{
		return;
	}
	
	
	
		//EVENT_ID = someData.EVENT_ID;
		startTime = $('#datetime1').val();
		endTime = $('#datetime2').val();
		noEndTime = $('#noEndDateInput').is(':checked');
		
		//alert('blah' + noEndTime);
		
		//status = 'PENDING'; 
		referenceData = $('#reference').val();
		initiator = $('#initiatorInput').val();
		actionRequired = $('#actionRequiredInput').val();
		//completeNotes = $('#completeNotes').val();

	
		
		
		swal({   
	title: "Updating Event",   
	text: "One moment while the event is being updated." ,   
	type: "info",   
	showCancelButton: false,   
	closeOnConfirm: false,   
	showLoaderOnConfirm: true, }, 
	function(){   
	setTimeout(function(){ 

							$.ajax({
									type: "POST",
									url: 'lib/eventLogApi.php',
									data:{ submit : 'UPDATE EVENT', EVENT_ID : ticketID, START_DATETIME : startTime, END_DATETIME : endTime, 
									NO_ENDDATE : noEndTime, REFERENCE : referenceData, INITIATOR : initiator, ACTION_REQUIRED : actionRequired },
									 success: function(data){
					//alert(data);

					
									 }
					
								  })
									  .done(function(data) {
										swal("Event Updated!", "The event has been successfully updated.", "success");
									
									  })
									  .error(function(data) {
										swal("Oops", "We couldn't connect to the server!", "error");
									  });
								  
								}, 2000); 
	});
		
// do button stuffs
  $( ".update" ).hide();
   $( ".clear" ).show();
   $( ".add" ).show();
  clearAllValues();
});




$(document).on('click', '.completedEvents', function () {
	selection = 'Completed Events';
		$('.completedEvents').addClass('highlight');
		$('.currentEvents').removeClass('highlight');
		$('.pendingEvents').removeClass('highlight');
		$('.expiredEvents').removeClass('highlight');
		$('.allEvents').removeClass('highlight');
		clearAllValues();
});

$(document).on('click', '.expiredEvents', function () {
	selection = 'Expired Events';
		$('.expiredEvents').addClass('highlight');
		$('.currentEvents').removeClass('highlight');
		$('.pendingEvents').removeClass('highlight');
		$('.completedEvents').removeClass('highlight');
		$('.allEvents').removeClass('highlight');
		clearAllValues();
});



$(document).on('click', '.pendingEvents', function () {
	selection = 'Pending Events';
		$('.pendingEvents').addClass('highlight');
		$('.currentEvents').removeClass('highlight');
		$('.expiredEvents').removeClass('highlight');
		$('.completedEvents').removeClass('highlight');
		$('.allEvents').removeClass('highlight');
		clearAllValues();
});


// *****  Normal and Detailed View button
$(document).on('click', '.normalView', function () {
	viewSelection = 'Normal View';
	$('.normalView').addClass('highlight');
	$('.detailedView').removeClass('highlight');
	clearAllValues();
});

$(document).on('click', '.detailedView', function () {
	viewSelection = 'Detailed View';
	$('.detailedView').addClass('highlight');
	$('.normalView').removeClass('highlight');
	clearAllValues();
});

// When user clicks on table loads ticket info into textboxes
 $(document).on('click', '.clickMe', function () {
			var postID = this.id;
			//alert(postID);



	   $.ajax({
			 type: "POST",
			 url: "lib/eventLogApi.php",
			 data: { ID : postID },
			 success: function(data){
					//alert(data);
					var someData = JSON.parse(data);
					
					
					ticketID = someData.EVENT_ID;
					EVENT_ID = someData.EVENT_ID;
					startTime = someData.START_DATETIME;
					endTime = someData.END_DATETIME;
					noEndTime = someData.NO_ENDDATE;
					status = someData.STATUS;
					referenceData = someData.REFERENCE;
					initiator = someData.INITIATOR;
					actionRequired = someData.ACTION_REQUIRED;
					creatorTech = someData.CREATOR_TECH;
					createTime = someData.CREATE_DATETIME;
					completeNotes = someData.COMPLETION_NOTES;
					completionTech = someData.COMPLETION_TECH;
					requestTicket = someData.REQUEST_TICKET;
					

					if (status == 'COMPLETED' || status == 'CANCELED')
					{
						$( ".completeMenu" ).hide();
						// Show edit menu
						$( ".complete" ).hide();		 
						$( ".cancel" ).hide();
						//clearAllValues();
					}
					else
					{
						$( ".completeMenu" ).show();
						// Show edit menu
						$( ".complete" ).show();		 
						$( ".cancel" ).show();
						
						
						// place values in inputs
						$('#initiatorInput').val(initiator);
						$('#actionRequiredInput').val(actionRequired);
						$('#reference').val(referenceData.trim());
							
						$('#datetime1').val(convertDate( startTime ));
						$('#datetime2').val(convertDate( endTime ));
						$('#noEndDateInput').val(noEndTime);
						$( ".add" ).hide();
						$( ".update" ).show();
					
					}
					
					
					if(status == 'PENDING')
					{
					    $( ".completeMenu" ).hide();
						// Show edit menu
						$( ".complete" ).hide();	
						
						//$( ".activeButton" ).show();	
					}
					
					if(status == 'ACTIVE')
					{
					//	$( ".activeButton" ).hide();
						
					}
					
					if(status == 'EXPIRED')
					{
					//	$( ".activeButton" ).show();
					}
				
					 

					
			 }
		 });


});

function checkIfEmptyAndValidateOnUpdateSend()
{


	if ( $( "#initiatorInput" ).val() == '' )
	{
		$( "#initiatorInput" ).addClass( "error" );
	}
	
	if($( "#actionRequiredInput" ).val() == '' )
	{
		$( "#actionRequiredInput" ).addClass( "error" );
	}
	
	if ($( "#datetime1" ).val() == '')
	{
		$( "#datetime1" ).addClass( "error" );	
	}
	if ($( "#datetime2" ).val() == '' )
	{
		$( "#datetime2" ).addClass( "error" );
	}	
	
	if ($( "#datetime2" ).val() <= $( "#datetime1" ).val() )
	{
		$( "#datetime2" ).addClass( "error" );
	}
    
	// ensure that error class is removed when user fixes date.
	if ($( "#datetime2" ).val() > $( "#datetime1" ).val() )
	{
		$( "#datetime2" ).removeClass( "error" );
	}
	
	
	if ( $( "#initiatorInput" ).hasClass( "error" ) ||
	$( "#actionRequiredInput" ).hasClass( "error" ) ||
	$( "#datetime1" ).hasClass( "error" ) ||
	$( "#datetime2" ).hasClass( "error" ) )
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
			 url: "lib/eventLogApi.php",
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
			 url: "lib/eventLogApi.php",
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

function getServer60Days( time )
{
	   $.ajax({
			 type: "POST",
			 url: "lib/eventLogApi.php",
			 data: { submit : time },
			 success: function(data){
					//alert(data);
					var someData = JSON.parse(data);
					
					var ServerTime = someData.SIXTY_SERVER_TIME
				
					//alert(currentServerTime);
					$( "#datetime2" ).val( convertDate(ServerTime) );
					return currentServerTime;
					
					
			 }
		 });
		 
}


function getServerTimeCentral()
{
	   $.ajax({
			 type: "POST",
			 url: "lib/eventLogApi.php",
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
















   
   