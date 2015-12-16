document.write('<script type="text/javascript" src="script/sweetalert.min.js"></script>');  


 // When document has loaded run ajax command every second.
$(document).ready(function(){

     //setInterval(ajaxcall, 1000);
	ajaxcall();
 });
 
 function ajaxcall(){
     $.ajax({
		 type: "POST",
         url: 'lib/editAccountApi.php',
		 data:{ submit : 'Load Page' },
         success: function(data){
					//alert(data);
					someData = JSON.parse(data);
	
					ISOC_TECH_EMPLOYEE_ID =  someData.ISOC_TECH_EMPLOYEE_ID;
					ISOC_TECH_PASSWORD = someData.ISOC_TECH_PASSWORD;
					ISOC_TECH_FIRST_NAME = someData.ISOC_TECH_FIRST_NAME;
					ISOC_TECH_LAST_NAME = someData.ISOC_TECH_LAST_NAME;
					ISOC_TECH_EMAIL = someData.ISOC_TECH_EMAIL;
					ISOC_TECH_SECRET_WORD = someData.ISOC_TECH_SECRET_WORD;
					ISOC_TECH_LAST_LOGIN = someData.ISOC_TECH_LAST_LOGIN;
					ISOC_TECH_ROLE = someData.ISOC_TECH_ROLE;
					ISOC_TECH_SHIFT = someData.ISOC_TECH_SHIFT;
					ACCOUNT_LOCKED = someData.ACCOUNT_LOCKED;
					
					
					//alert("Hello " + ISOC_TECH_FIRST_NAME + " " + ISOC_TECH_LAST_NAME);
					
				if ( ISOC_TECH_ROLE == "admin" )
				{
				   	// Fill all text boxes with data for admin role
					$('.firstName').val(ISOC_TECH_FIRST_NAME);
					$('.lastName').val(ISOC_TECH_LAST_NAME);
					$('.email').val(ISOC_TECH_EMAIL);
					$('.secretWord').val(ISOC_TECH_SECRET_WORD);
					$('.role-select').val(ISOC_TECH_ROLE);
					$('.shift').val(ISOC_TECH_SHIFT);
					$('.id').val(ISOC_TECH_EMPLOYEE_ID);
					
					// Hide text boxes for regular uses
					$('.role-text').hide();
				
				}
				
				else
				{
				
					// Fill all text boxes with data for user role
					$('.firstName').val(ISOC_TECH_FIRST_NAME);
					$('.lastName').val(ISOC_TECH_LAST_NAME);
					$('.email').val(ISOC_TECH_EMAIL);
					$('.secretWord').val(ISOC_TECH_SECRET_WORD);
					$('.role-text').val(ISOC_TECH_ROLE);
					$('.shift').val(ISOC_TECH_SHIFT);
					$('.id').val(ISOC_TECH_EMPLOYEE_ID);
					
					//Hide drop downs for Admin
					$('.role-select').hide();
					
					//show textboxes for users
					$('.role-text').show();
					
					// modify textboxes to be read only
					$('.role-text').attr('readonly', true);
					
				}	
					
					
					

         }
     });
 }
 
 
 function clearAllValues()
 {
	$('#initiatorInput').val("");
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
		$('.twelveHours').removeClass('highlight');
		$('.oneDay').removeClass('highlight');

		clearAllValues();
});


$(document).on('click', '.oneDay', function () {
	selection = '1 DAY';
		$('.oneDay').addClass('highlight');
		$('.twelveHours').removeClass('highlight');
		$('.allDays').removeClass('highlight');
		clearAllValues();
});


$(document).on('click', '.twelveHours', function () {
		$('.twelveHours').addClass('highlight');
		$('.oneDay').removeClass('highlight');
		$('.allDays').removeClass('highlight');
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
	else
	{
		$( "#personContacted" ).removeClass( "error" );
	}
	
	if($( "#notes" ).val() == '' )
	{
		$( "#notes" ).addClass( "error" );
	}
	else
	{
		$( "#notes" ).removeClass( "error" );
	}
	
	if ($( "#datetime1Input" ).val() == '')
	{
		$( "#datetime1Input" ).addClass( "error" );	
	}
	else
	{
		$( "#datetime1Input" ).removeClass( "error" );
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
function getServerTimeEastern()
{
	   $.ajax({
			 type: "POST",
			 url: "lib/shiftLogApi.php",
			 data: { submit : 'EASTERN TIME' },
			 success: function(data){
					//alert(data);
					var someData = JSON.parse(data);
					
					var currentServerTime = someData.SERVER_TIME
				
					//alert(currentServerTime);
					$('#serverTime').html(convertDate(currentServerTime) + ' Eastern Time');
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


// Insert or addCall 
$(document).on('click', '.addCall', function () {
	
	if (!checkIfEmptyAndValidateOnupdateCallSend() )
	{
		return;
	}
	
	
		input_DATE_TIME = $( "#datetime1Input" ).val();
		input_METHOD = $('#method').val( );
		input_PERSON_CONTACTED = $('#personContacted').val();
		input_NOTES = $('#notes').val();
		input_TICKET = $('#ticketNumber').val();
		
		if ( input_TICKET == '' )
		{
			input_TICKET = 'n/a';
		}

				
							$.ajax({
									type: "POST",
									url: 'lib/shiftLogApi.php',
									data:{ submit : 'Add Call', DATE_TIME : input_DATE_TIME, METHOD : input_METHOD, PERSON_CONTACTED : input_PERSON_CONTACTED, NOTES : input_NOTES, TICKET : input_TICKET}
								  });
		
clearAllValues();
});



// Update to Database from controls
$(document).on('click', '.updateCall', function () {
	
	if (!checkIfEmptyAndValidateOnupdateCallSend() )
	{
		return;
	}
	
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
    
	//timeString += (hours >= 12) ? " PM" : " AM";
	
	return timeString;
}
   
  $(document).on('click', '.spanIcon', function () {
	
	$('#datetime1Input').val( getDateTime() );
	$( "#datetime1Input" ).removeClass( "error" )

});
