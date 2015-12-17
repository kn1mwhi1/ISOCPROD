document.write('<script type="text/javascript" src="script/sweetalert.min.js"></script>');  


 // When document has loaded run ajax command every second.
$(document).ready(function(){

     //setInterval(ajaxcall, 1000);
	FirstLoadPageajaxcall();
 });
 
 function FirstLoadPageajaxcall(){
     $.ajax({
		 type: "POST",
         url: 'lib/editAccountApi.php',
		 data:{ submit : 'Load Page' },
         success: function(data){
					//alert(data);
					someData = JSON.parse(data);
					
					// transfer data from parsed variable to its own variable(global)
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
				
				// Detects the Role and calls the appropriate function to set up the view
				if ( ISOC_TECH_ROLE == "Admin" )
				{
				   	setUpAdminView();
				}
				
				else
				{
					setupUserView();	
				}
         }
     });
 }
 
 function LoadOtherUser( userID ){
    
//alert( userID );

	$.ajax({
		 type: "POST",
         url: 'lib/editAccountApi.php',
		 data:{ submit : 'Load Other', OTHER_ID : userID },
         success: function(data){
					//alert(data);
					someData = JSON.parse(data);
					
					// transfer data from parsed variable to its own variable(global)
					OTHER_ISOC_TECH_EMPLOYEE_ID =  someData.ISOC_TECH_EMPLOYEE_ID;
					OTHER_ISOC_TECH_PASSWORD = someData.ISOC_TECH_PASSWORD;
					OTHER_ISOC_TECH_FIRST_NAME = someData.ISOC_TECH_FIRST_NAME;
					OTHER_ISOC_TECH_LAST_NAME = someData.ISOC_TECH_LAST_NAME;
					OTHER_ISOC_TECH_EMAIL = someData.ISOC_TECH_EMAIL;
					OTHER_ISOC_TECH_SECRET_WORD = someData.ISOC_TECH_SECRET_WORD;
					OTHER_ISOC_TECH_LAST_LOGIN = someData.ISOC_TECH_LAST_LOGIN;
					OTHER_ISOC_TECH_ROLE = someData.ISOC_TECH_ROLE;
					OTHER_ISOC_TECH_SHIFT = someData.ISOC_TECH_SHIFT;
					OTHER_ACCOUNT_LOCKED = someData.ACCOUNT_LOCKED;
					
					
					// Fill objects with other persons data.
					$('.firstName').val(OTHER_ISOC_TECH_FIRST_NAME);
					$('.lastName').val(OTHER_ISOC_TECH_LAST_NAME);
					$('.email').val(OTHER_ISOC_TECH_EMAIL);
					$('.secretWord').val(OTHER_ISOC_TECH_SECRET_WORD);
					$('.role-select').val(OTHER_ISOC_TECH_ROLE);
					$('.shift').val(OTHER_ISOC_TECH_SHIFT);
					$('.id').val(OTHER_ISOC_TECH_EMPLOYEE_ID);
					
					
				
         }
     });
 }
 
  // Function sets up the admins view and transfers data to appropriate text boxes and selects
 function setUpAdminView()
 {
 // Fill all text boxes with data for admin role
	$('.firstName').val(ISOC_TECH_FIRST_NAME);
	$('.lastName').val(ISOC_TECH_LAST_NAME);
	$('.email').val(ISOC_TECH_EMAIL);
	$('.secretWord').val(ISOC_TECH_SECRET_WORD);
	$('.role-select').val(ISOC_TECH_ROLE);
	$('.shift').val(ISOC_TECH_SHIFT);
	$('.id').val(ISOC_TECH_EMPLOYEE_ID);
	
// Show Admin Drop-down
$('.adminUserPicker').show();
					
// Hide text boxes for regular uses
	$('.role-text').hide(); 
 
 }
 
 // Function sets up the user view and transfers data to appropriate text boxes and selects
 function setupUserView()
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
	$('.adminUserPicker').hide();
					
	//show textboxes for users
	$('.role-text').show();
					
	// modify textboxes to be read only
	$('.role-text').attr('readonly', true);
 }
 
 // compares passwords before updating.
 function validatePasswords()
 {
	
	// compare passwords
	password1 = $('.password1').val();
	password2 = $('.password2').val();
	
	if ( password1 != password2)
	{
		// add error class to password text boxes
		$('.password1').addClass('error');
		$('.password2').addClass('error');
		
		swal("Oops", "your passwords does not match please try again!", "error");
		// set password validation to false;
		passwordValidation = false;
		return false;
	}
	else
	{
		// Remove any red outlines on password change box
		$('.password1').removeClass('error');
		$('.password2').removeClass('error');

		passwordValidation = true;
	}
	
 }
 
 function updateUserAccountInfoToDatabase()
 {
	// get user values
	
	var tempFirstName = $('.firstName').val();
	var tempLastName = $('.lastName').val();
	var tempEmail = $('.email').val();
	var tempSecretWord = $('.secretWord').val();
	
	var tempRole = $('.role-text').val()
	if ( $('.role-text').val() == '' )
	{
	tempRole = 	$('.role-select').val()
	}
	
	
	var tempShift = $('.shift').val();
	var tempID = $('.id').val();
	var tempPassword1 = $('.password1').val();
	var tempPassword2 = $('.password2').val();
	
	
	if (typeof OTHER_ISOC_TECH_EMPLOYEE_ID === 'undefined' )
	{
		OTHER_ISOC_TECH_EMPLOYEE_ID = ISOC_TECH_EMPLOYEE_ID;
	}
	
  
  // Save it all if user is changing password
  if ( tempPassword1 != "" && tempPassword2 != "" )
  {
  
		  // Save All user account info
		  $.ajax({
				 type: "POST",
				 url: 'lib/editAccountApi.php',
				 data:{ submit : 'Update Account All', ACC_FIRST_NAME : tempFirstName, ACC_LAST_NAME : tempLastName, ACC_EMAIL : tempEmail, ACC_SECRET_WORD : tempSecretWord, ACC_ROLE : tempRole, ACC_SHIFT : tempShift, 
						ACCT_NEW_ID : tempID, ACCT_OLD_ID : OTHER_ISOC_TECH_EMPLOYEE_ID, ACC_NEW_PASSWORD : tempPassword1},
				 success: function(data){
							//alert(data);
							someData = JSON.parse(data);
							
							
										swal("Account Updated!", "Account Information was updated successfully.", "success");
									
									
							
				 }
			 });
	 
	 }
	 else   // Just save everything without the password
	 {
	 
		 // Save User Account info to Database
		  $.ajax({
				 type: "POST",
				 url: 'lib/editAccountApi.php',
				 data:{ submit : 'Update Account No Password', ACC_FIRST_NAME : tempFirstName, ACC_LAST_NAME : tempLastName, ACC_EMAIL : tempEmail, ACC_SECRET_WORD : tempSecretWord, ACC_ROLE : tempRole, ACC_SHIFT : tempShift, 
						ACCT_NEW_ID : tempID, ACCT_OLD_ID : OTHER_ISOC_TECH_EMPLOYEE_ID },
				 success: function(data){
							//alert(data);
							someData = JSON.parse(data);
							
							swal("Account Updated!", "Account Information was updated successfully.", "success");
				 }
			 });
	 
	 }
 
 }
 
 
 
 
 
 
 
 function clearAllValues()
 {
	$('#initiatorInput').val("");
 }
 


 


// ******************  Click Event Handlers *****************************************

   
$(document).on('change', '.adminUserPicker', function () {
		var aUserID = $('.adminSelect').val();
		LoadOtherUser( aUserID );
});


$(document).on('click', '.save', function () {
		// compare passwords to ensure
		if ( userValidation() )
		{
			updateUserAccountInfoToDatabase();
			
			
			
			
			
		}
		
});






// Validates to ensure no empty input and password matches
// Returns a false if there is an error
// Returns true if all items  pass empty validation and password validation
function userValidation()
{
	if ( $( ".firstName" ).val() == '' )
	{
		$( ".firstName" ).addClass( "error" );
	}

	
	if($( ".lastName" ).val() == '' )
	{
		$( ".lastName" ).addClass( "error" );
	}

	
	if ($( ".email" ).val() == '')
	{
		$( ".email" ).addClass( "error" );	
	}

	
	if ($( ".secretWord" ).val() == '')
	{
		$( ".secretWord" ).addClass( "error" );	
	}

	
	if ($( ".id" ).val() == '')
	{
		$( ".id" ).addClass( "error" );	
	}

	
	// validate Passwords
		validatePasswords();
	
	
	if ( $( ".firstName" ).hasClass( "error" ) ||
		 $( ".lastName" ).hasClass( "error" ) ||
		 $( ".email" ).hasClass( "error" ) || 
		 $( ".secretWord" ).hasClass( "error" ) ||
		 $( ".id" ).hasClass( "error" ) ||
		 $( ".password1" ).hasClass( "error" ) ||
		 $( ".password2" ).hasClass( "error" ) 
		 )
	{
		swal("Oops", "Please fill out all required fields correctly", "error");
		return false;
	}
	
	return true;
}


// on blur action - validate html object with PHP code.
function validation( aHtmlElementName, typeOfValidation )
{
	   
	   // get value and assign to aHtmlValue
	   var aHtmlValue = $(aHtmlElementName).val();
	   
	   //alert('The value is:' + aHtmlValue + ' The id is ' + aHtmlElementName.id );
	   
	   $.ajax({
			 type: "POST",
			 url: "lib/editAccountApi.php",
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
