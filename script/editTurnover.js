/*****************************************************
* Function to add/remove additional rows of Turnover *
******************************************************/

	// Set variable for row number
		var rowNum = 0;
	
	// trnOver is the form name from Create Turnover, this is passing that data into the function
		function addRow(trnOver) {
		
		// Removes any content from the div createItemValidationError
			$("#createItemValidationError").empty();
			
		// Create variable equal to the value of the turnover item box (text entered by the user)
			var itemEntry = document.forms["trnOver"]["add_turnover"].value;
			
		// Check to make sure the variable isn't empty
			if (itemEntry != "") {
			
		// Increment the row number by 1 each time the function runs to ensure every row is unique
			rowNum ++;
			
		// Variable previously used to replace quote characters. It is no longer needed for this purpose but removing it will require other code changes.
			var turnOverValue = trnOver.add_turnover.value;
		
		// Create variable containing HTML code to create a new line containing the text entered by the user and create a button to remove it
			var row = '<p id="rowNum'+rowNum+'"><textarea name="newTurnover[]" class="item">'+turnOverValue+'</textarea><input type="button" value="Remove" onclick="removeRow('+rowNum+');"></p>';
		
		// Append the new HTML code to the page inside the div addTurnover		
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
			// End - reset textarea resize on button click
				} else {
				
				// Create HTML to display an error if blank turnover is added
					document.getElementById('createItemValidationError').innerHTML = '<p><img src="http://10.176.105.22/img/yodaIcon.png"></p>Enter a blank turnover item, you cannot.';
				}
		}
		
		
/***********************************************************************
* Function to remove a row of Turnover before it's submitted to the DB *
************************************************************************/

	function removeRow(rnum) {
	
	// Pop up window to confirm action
		if (confirm("Are you sure you want to delete this item?")) {
		
		// Removes the selected row
			$('#rowNum'+rnum).remove();
		}
	}
	
	
/******************************************
* Function to remove existing Technicians *
*******************************************/

	function removeoldTech () {
	
	// Ajax function to remove an existing Technician when the "-" button is clicked
		$(".oldTech").on("click", function(){
		
		// Removes the Technician, that was clicked, from the HTML
			$(this).remove();
		
		// Turns off jQuery click handler, this prevents additional Technicians from being removed from the HTML
			$(".oldTech").off("click");
		
		// Create variable using the isoctechs_id (from the database) to identify the correct row in the DB
			var removeOldTech = $(this).attr('id');
		
			// Ajax call to remove Technicians from the DB
				$.ajax({
			// Request sent via HTTP POST request
				type: "POST",
			// URL containing code to process the POST data
				url: "/lib/toDataBaseDelete.php",
			// Variable used in ajax request
				data: {oldTech:removeOldTech},	
				});
		// Create a confirmation message that a Technician was deleted
			document.getElementById('deleteTechnicianValidation').innerHTML = '<p><img src="/img/cyberman.png"></p>A Technician has been <p>DELETED!</p>';
		});
	}

	
/**************************************************************************************************
* Function to clear the confirmation "Technician has been DELETED!" message on mouse click or tab *
***************************************************************************************************/

	$(document).ready(function() {
	
	// Works on tab or other key press
		$('html').keyup(function() {
		
		// Clear the confirmation message
			$('#deleteTechnicianValidation').empty();
		});
		
	// Works on mouse click
		$('html').mouseup(function() {
		
		// Clear the confirmation message
			$('#deleteTechnicianValidation').empty();
		});
	
	});
	
	
/*****************************************************
* Function to remove existing rows of Turnover Items *
******************************************************/

	function removeoldTurnover () {
	
	// Creates a pop up window to confirm before deleting the Turnover Item
		if (confirm("Are you sure you want to delete this item?")) {
		
		// Ajax function to remove a Turnover Item when the "Remove" button is clicked
			$(".oldTurnover").on("click", function(){
			
			// Create variable using the item_id (from the database) to identify the correct row in the DB
				var removeOldTurnover = $(this).attr('id');		

				// Ajax call to remove the Turnover Item
					$.ajax({
				// Request sent via HTTP POST request
					type: "POST",
				// URL containing code to process the POST data
					url: "/lib/toDataBaseDelete.php",
				// Variable used in ajax request
					data: {oldTurnover:removeOldTurnover}
					});
			
			// Replace the Turnover Item with new HTML code to display img and message to confirm the Item was deleted
				$(this).replaceWith('<div class="deleteTurnoverValidation"><p><img src="/img/cyberman.png"></p>A Turnover Item has been <p>DELETED!</p><div>');
				$(".oldTurnover").off("click");
			});
		}
	}

	
/********************************************************************************************************
* Function to clear the confirmation "A Turnover Item has been DELETED!" message on mouse click or tab  *
*********************************************************************************************************/

	$(document).ready(function() {
	
	// Works on tab or other key press
		$("html").mousedown(function() {
		
		// Clear the confirmation message
			$(".deleteTurnoverValidation").empty();
		});
		
	// Works on mouse click
		$("html").keydown(function() {
		
		// Clear the confirmation message
			$(".deleteTurnoverValidation").empty();
		});
	});
		
		
/**************************************************************************
* Function to add text counter to Turnover Item Field (works on tab over) *
***************************************************************************/

	$(document).ready(function() {
	
	// Create variable for the maximum allowed characters 
		var text_max = 500;
		
	// Display character count (Remaining/Allowed) to the charNum div just above the Turnover Items
		$('#charNum').html(text_max + ' /500');
		
	// Call function to reset value when a key is pressed
		$("textarea[name=add_turnover]").keyup(function() {
		
		// Create variable with current character count
			var text_length = $("textarea[name=add_turnover]").val().length;
			
		// Create variable with the remaining character count after subtracting what has been used
			var text_remaining = text_max - text_length;
			
		// Re-display character count after changes take place
			$('#charNum').html(text_remaining + ' /500');
		});
	});
	
	
/*****************************************************************************
* Function to add text counter to Turnover Item Field (works on mouse click) *
******************************************************************************/

	$(document).ready(function() {
	
	// Create variable for the maximum allowed characters
		var text_max = 500;
		
	// Display character count (Remaining/Allowed) to the charNum div just above the Turnover Items
		$('#charNum').html(text_max + ' /500');
		
	// Call function to reset value when the mouse is clicked
		$("textarea[name=add_turnover]").mouseup(function() {
		
		// Create variable with current character count
			var text_length = $("textarea[name=add_turnover]").val().length;
			
		// Create variable with the remaining character count after subtracting what has been used
			var text_remaining = text_max - text_length;
			
		// Re-display character count after changes take place
			$('#charNum').html(text_remaining + ' /500');
		});
	});

	
/******************************************************
* Function to Validate all required data is populated *
*******************************************************/

	function validateForm() {
	
	// Create variables for validation
		var manEntry = document.forms["trnOver"]["add_turnover"].value;
		var techSelect = document.forms["trnOver"]["add_Technician"].value;
	
	// Create HTML for error message and prevent form submission if text remains in the Turnover Item field without being added
		if (manEntry != "") {
			document.getElementById('createItemValidationError').innerHTML = '<p><img src="http://10.176.105.22/img/yodaIcon.png"></p>An unsaved turnover item there is. Delete text from the turnover field or click Add Item, you should. Herh herh herh.';
			return false;
		}
		
	// Create HTML for error message and prevent form submission if a Technician was selected but not added to Turnover
		else if (techSelect != "Select Technician") {
			document.getElementById('createTechnicianValidationError').innerHTML = '<p><img src="http://10.176.105.22/img/yodaIcon.png"></p>Added to turnover a selected technician was not. Click "+" to add you must. Hrrrmmm.';
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
		// Variables used in the Ajax request
			 data:{ submit : selection, view : viewSelection },
		// Function to run if the Ajax request is successful
			 success: function(someData){
				
					if ( temp != someData)
					{
						 $('#dynamicTable').html(someData);
						 temp = someData;
					 }
			 }
		 });
	}