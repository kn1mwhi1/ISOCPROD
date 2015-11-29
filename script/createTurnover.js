/************************************************************************************
* Function to add and reset text counter to Turnover Item Field (works on tab over) *
*************************************************************************************/

	$(document).ready(function() {
	
	// Create variable for the maximum allowed characters
		var text_max = 500;
		
	// Display character count (Remaining/Allowed) to the charNum div just above the Turnover Items
		$('#charNum').html(text_max + ' /500');
		
	// Call function to reset value when a key is pressed
		$('#textbox').keyup(function() {
		
		// Create variable with current character count
			var text_length = $('#textbox').val().length;
			
		// Create variable with the remaining character count after subtracting what has been used
			var text_remaining = text_max - text_length;
			
		// Re-display character count after changes take place
			$('#charNum').html(text_remaining + ' /500');
		});
	});
	
	
/***************************************************************************************
* Function to add and reset text counter to Turnover Item Field (works on mouse click) *
****************************************************************************************/

	$(document).ready(function() {
	
	// Create variable for the maximum allowed characters
			var text_max = 500;
			
	// Display character count (Remaining/Allowed) to the charNum div just above the Turnover Items
			$('#charNum').html(text_max + ' /500');
			
	// Call function to reset value when the mouse is clicked
			$('#textbox').mouseup(function() {
			
		// Create variable with current character count
				var text_length = $('#textbox').val().length;
				
		// Create variable with the remaining character count after subtracting what has been used
				var text_remaining = text_max - text_length;
				
		// Re-display character count after changes take place
				$('#charNum').html(text_remaining + ' /500');
			});
		});

		
/**********************************************
* Function to add additional rows of Turnover *
***********************************************/

	// Create variable for row number
		var rowNum = 0;
		
	// Pass the values of the HTML form through to the function using the form name, trnOver
		function addRow(trnOver) {
		
		// Removes any content from the div ID createItemValidationError
			$("#createItemValidationError").empty();
			
		// Create variable equal to the value of the turnover item box (text entered by the user)
			var itemEntry = document.forms["trnOver"]["add_turnover"].value;
			
		// Validates text was added to the Turnover Item and it's not blank
			if (itemEntry != "") {
			
		// Increment the row number by 1 each time the function runs to ensure every row is unique
			rowNum ++;
			 
		// Variable previously used to replace quote characters. It is no longer needed for this purpose but removing it will require other code changes.
			var turnOverValue = trnOver.add_turnover.value;
		
		// Create variable containing HTML code to create a new line with the text entered by the user and a button to remove it
			var row = '<p id="rowNum'+rowNum+'"><textarea name="turnover[]" class="item">'+turnOverValue+'</textarea><input type="button" value="Remove" onclick="removeRow('+rowNum+');"></p>';
		
		// Append the new HTML code to the page inside the div addTurnover to display the Turnover Item created
			$('#addTurnover').append(row);
		
		// Clears text from the box entered by the user once it has been moved to a new line
			trnOver.add_turnover.value = '';
			
			// Reset textarea size when mouse is moved
				$("textarea").mousemove(function() {
				
			// Set height of the textarea
				$(this).height(50);
				
			// Not sure why this code is here, not really serving a purpose since the textarea isn't hidden
				$("textarea").show();
				});
			} else {
			
			// Create HTML to display an error if blank turnover is added
				document.getElementById('createItemValidationError').innerHTML = '<p><img src="img/yodaIcon.png"></p>Enter a blank turnover item you cannot. Yeesssssss.';
			}
		}
	

/***********************************************************
* Remove a row of Turnover before it's submitted to the DB *
************************************************************/

// Pass the rowNum variable through to the function to identify which row to remove
	function removeRow(rowNum) {

	// Pop up window to confirm action
		if (confirm("Are you sure you want to delete this item?")) {
		
		// Removes the selected row
			$('#rowNum'+rowNum).remove();
		}
	}
		

/****************************************************
* Script to Validate all required data is populated *
*****************************************************/

	function validateForm() {
	
	// Clear content from the createItemValidationError div
		$("#createItemValidationError").empty();
		
	// Create variables for validation
		var manEntry = document.forms["trnOver"]["add_turnover"].value;
		var shiftEntry = document.forms["trnOver"]["shift"].value;
		var techEntry = document.querySelector(".selectedTech");
		var techSelect = document.forms["trnOver"]["add_Technician"].value;
	
	// Create HTML for error message and prevent form submission if text remains in the Turnover Item field without being added
		if(manEntry != "") {
			document.getElementById('createItemValidationError').innerHTML = '<p><img src="/img/yodaIcon.png"></p>An unsaved turnover item, there is. Delete the text from the turnover field or click add item, you must.';
			return false;
		}
		
	// Create HTML for error message and prevent form submission if a Shift was not selected
		else if (shiftEntry == "Select Shift") {
			document.getElementById('createShiftValidationError').innerHTML = '<p><img src="/img/yodaIcon.png"></p>Select a shift, you must. Choose one from the dropdown, you should.';
			return false;
		}
		
	// Create HTML for error message and prevent form submission if a Technician was selected but not added to Turnover
		else if (techSelect != "Select Technician") {
			document.getElementById('createTechnicianValidationError').innerHTML = '<p><img src="/img/yodaIcon.png"></p>Added to turnover a selected technician was not. Click "+" to add you must. Hrrrmmm.';
			return false;
		}
		
	// Create HTML for error message and prevent form submission if no Technicians are added to Turnover
		else if (techEntry == null) {
			document.getElementById('createTechnicianValidationError').innerHTML = '<p><img src="/img/yodaIcon.png"></p>Added to turnover a technician was not.  Select at least 1 technician, you must. Yeesssssss.';
			return false;
		}
	}


/*******************************************
* Function to load Event Log into Turnover *
********************************************/		

// Global Variables

	 selection = 'Current Events';
	 viewSelection = 'Normal View';
	 temp ='';

// Function to load Event Log into Turnover
	$(document).ready(function(){
	
	// Function to load Event Log onto the page
		ajaxcall();
	
	// Refresh Event Log data every 60 seconds
		setInterval(ajaxcall, 60000);
	 });

// Ajax function to get the Event Log data and format into a Table
	function ajaxcall(){
		 $.ajax({
		// Request sent via HTTP POST request
			 type: "POST",
		// URL containing code to process the POST data
			 url: 'lib/eventLogApi.php',
		// Variables used in the ajax request
			 data:{ submit : selection, view : viewSelection },
		// Function to run if the ajax request is successful
			 success: function(someData){
				
					if ( temp != someData)
					{
						 $('#dynamicTable').html(someData);
						 temp = someData;
					 }
			 }
		 });
	}

