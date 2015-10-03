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

	 // Show edit menu		 
	$( ".completeMenu" ).hide();
	// Show edit menu
	$( ".complete" ).hide();		 
	$( ".cancel" ).hide();
	//$( ".activeButton" ).hide();
	$( ".updateCall" ).hide();
   $( ".addCall" ).show();
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

		timeString = t[1] + '/' + t[2] + '/' + t[0] + ' ' + t[3] + ':' + t[4] + ':' + t[5];
		
		return timeString;
   }
   

   


// ******************  Click Event Handlers *****************************************

   
$(document).on('click', '.clear', function () {
   $( ".updateCall" ).hide();
   $( ".addCall" ).show();
   clearAllValues();
});



// Insert or addCall new event
$(document).on('click', '.addCall', function () {
	
	
	
	if (!checkIfEmptyAndValidateOnupdateCallSend() )
	{
		return;
	}
		
	
	
	
		//ticketID = someData.EVENT_ID;
		startTime = $('#datetime1Input').val();
	
		referenceData = $('#reference').val();
		initiator = $('#initiatorInput').val();
		actionRequired = $('#actionRequiredInput').val();

			
		
		
		swal({   
	title: "addCalling Event",   
	text: "One moment while the event is being addCalled to the database" ,   
	type: "info",   
	showCancelButton: false,   
	closeOnConfirm: false,   
	showLoaderOnConfirm: true, }, 
	function(){   
	setTimeout(function(){ 

							$.ajax({
									type: "POST",
									url: 'lib/shiftLogApi.php',
									data:{ submit : 'addCall EVENT', START_DATETIME : startTime, END_DATETIME : endTime, 
									NO_ENDDATE : noEndTime, STATUS : status, REFERENCE : referenceData, INITIATOR : initiator, ACTION_REQUIRED : actionRequired }
								  })
									  .done(function(data) {
										swal("Event addCalled!", "The event has been successfully addCalled.", "success");
									
									  })
									  .error(function(data) {
										swal("Oops", "We couldn't connect to the server!", "error");
									  });
								  
								}, 2000); 
	});
		

clearAllValues();
});


// Insert or addCall new event
$(document).on('click', '.updateCall', function () {
	
	if (!checkIfEmptyAndValidateOnupdateCallSend() )
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
	text: "One moment while the event is being updateCalld." ,   
	type: "info",   
	showCancelButton: false,   
	closeOnConfirm: false,   
	showLoaderOnConfirm: true, }, 
	function(){   
	setTimeout(function(){ 

							$.ajax({
									type: "POST",
									url: 'lib/shiftLogApi.php',
									data:{ submit : 'updateCall EVENT', EVENT_ID : ticketID, START_DATETIME : startTime, END_DATETIME : endTime, 
									NO_ENDDATE : noEndTime, REFERENCE : referenceData, INITIATOR : initiator, ACTION_REQUIRED : actionRequired },
									 success: function(data){
					//alert(data);

					
									 }
					
								  })
									  .done(function(data) {
										swal("Event updateCalld!", "The event has been successfully updateCalld.", "success");
									
									  })
									  .error(function(data) {
										swal("Oops", "We couldn't connect to the server!", "error");
									  });
								  
								}, 2000); 
	});
		
// do button stuffs
  $( ".updateCall" ).hide();
   $( ".clear" ).show();
   $( ".addCall" ).show();
  clearAllValues();
});

 $(document).on('click', '.allCalls', function () {
	selection = 'All Events';
		$('.allCalls').addCallClass('highlight');
		$('.sevenDays').removeClass('highlight');
		$('.twelveHours').removeClass('highlight');
		$('.oneDay').removeClass('highlight');
		$('.fifteenDays').removeClass('highlight');
		clearAllValues();
});


 $(document).on('click', '.thirtyDays', function () {
	selection = 'All Events';
		$('.thirtyDays').addCallClass('highlight');
		$('.sevenDays').removeClass('highlight');
		$('.twelveHours').removeClass('highlight');
		$('.oneDay').removeClass('highlight');
		$('.fifteenDays').removeClass('highlight');
		clearAllValues();
});


 $(document).on('click', '.fifteenDays', function () {
	selection = 'Current Events';
		$('.fifteenDays').addCallClass('highlight');
		$('.sevenDays').removeClass('highlight');
		$('.twelveHours').removeClass('highlight');
		$('.oneDay').removeClass('highlight');
		$('.thirtyDays').removeClass('highlight');
		clearAllValues();
});


$(document).on('click', '.sevenDays', function () {
	selection = 'Completed Events';
		$('.sevenDays').addCallClass('highlight');
		$('.fifteenDays').removeClass('highlight');
		$('.twelveHours').removeClass('highlight');
		$('.oneDay').removeClass('highlight');
		$('.thirtyDays').removeClass('highlight');
		clearAllValues();
});

$(document).on('click', '.oneDay', function () {
	selection = 'Expired Events';
		$('.oneDay').addCallClass('highlight');
		$('.fifteenDays').removeClass('highlight');
		$('.twelveHours').removeClass('highlight');
		$('.sevenDays').removeClass('highlight');
		$('.thirtyDays').removeClass('highlight');
		clearAllValues();
});



$(document).on('click', '.twelveHours', function () {
	selection = 'Pending Events';
		$('.twelveHours').addCallClass('highlight');
		$('.fifteenDays').removeClass('highlight');
		$('.oneDay').removeClass('highlight');
		$('.sevenDays').removeClass('highlight');
		$('.thirtyDays').removeClass('highlight');
		clearAllValues();
});




// *****  selfView and everyoneView button
$(document).on('click', '.selfView', function () {
	viewSelection = 'Normal View';
	$('.selfView').addCallClass('highlight');
	$('.everyoneView').removeClass('highlight');
	clearAllValues();
});

$(document).on('click', '.everyoneView', function () {
	viewSelection = 'Detailed View';
	$('.everyoneView').addCallClass('highlight');
	$('.selfView').removeClass('highlight');
	clearAllValues();
});




function checkIfEmptyAndValidateOnupdateCallSend()
{
	if ( $( "#personContacted" ).val() == '' )
	{
		$( "#personContacted" ).addCallClass( "error" );
	}
	
	if($( "#notes" ).val() == '' )
	{
		$( "#notes" ).addCallClass( "error" );
	}
	
	if ($( "#datetime1Input" ).val() == '')
	{
		$( "#datetime1Input" ).addCallClass( "error" );	
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
						$(aHtmlElementName).addCallClass('error');
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

// When user clicks on table loads ticket info into textboxes
 $(document).on('click', '.clickMe', function () {
			var postID = this.id;
			//alert(postID);



	   $.ajax({
			 type: "POST",
			 url: "lib/shiftLogApi.php",
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
						$( ".addCall" ).hide();
						$( ".updateCall" ).show();
					
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














   
   