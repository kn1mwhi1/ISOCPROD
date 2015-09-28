document.write('<script type="text/javascript" src="script/sweetalert.min.js"></script>');  

 // Global Variables
 
 selection = 'Current Events';
 viewSelection = 'Normal View';
 temp ='';


// function to show calendar
$(function () {	
	$('#datetimepicker1').datetimepicker({
		showClear: true
	});
	
	});
	
	
// function to show calendar 2
$(function () {$('#datetimepicker2').datetimepicker();
		showClear: true
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
		 data:{ buttonType : aValue, ticket : ticketID },
         success: function(someData){
			 
			 alert('buttonType: ' + buttonType + 'aValue: ' + aValue + 'ticket: ' + ticket + 'ticketID: ' + ticketID );
			 
			 
								swal("Change Successful!", "Your change was successful!", "success"); 
			
         }
     });
 }
 
 
 
 function clearAllValues()
 {
	$('#initiatorInput').val("");
	$('#actionRequiredInput').val("");
	$('#reference').val("");				
	$('#datetime1').val("");
	$('#datetime2').val("");		
	$('#noEndDateInput').val("");
	 // Show edit menu		 
	$( ".completeMenu" ).hide();
	// Show edit menu
	$( ".complete" ).hide();		 
	$( ".cancel" ).hide();
	$( ".activeButton" ).hide();
	$( ".update" ).hide();
   $( ".add" ).show();
 }
 

 

 
	// convert a mysql time and date to a customer time and date
   function convertDate( dateTime )
   {
		// Split timestamp into [ Y, M, D, h, m, s ]
		var t = dateTime.split(/[- :]/);

		// Apply each element to the Date function
		var timeNow = new Date(t[0], t[1], t[2], t[3], t[4], t[5]);
		
		var year = timeNow.getFullYear();
		var day = timeNow.getDate();
		var month = timeNow.getMonth(); 
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

 // When document has loaded run ajax command every second.
$(document).ready(function(){
     setInterval(ajaxcall, 1000);
 });
 

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
		
		$( "#datetime2" ).val( getSixtyDays() );
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



$(document).on('click', '.update', function () {
   $( ".update" ).hide();
   $( ".clear" ).hide();
   $( ".add" ).show();
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
									data:{ submit : 'CANCEL', ticket : ticketID }
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
						
						$( ".activeButton" ).show();	
					}
					 

					
			 }
		 });


});
   
   