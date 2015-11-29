/************************************************
* Function to control the focus on turnoverForm *
*************************************************/

	$(document).ready(function() {
			
	// Sets focus to shift selection on page load
		$("#turnoverForm [name='shift']").focus();
					
	// Sets focus back to Technicians when new row is added to turnover items
		$("#turnoverForm [name='technicians']").click(function(){
			$("#turnoverForm [name='add_Technician']").focus();
		});
			
	// Sets focus back to textarea when new row is added to turnover items
		$("#turnoverForm [name='turnover']").click(function(){
			$("#turnoverForm [name='add_turnover']").focus();
		});
		
	});
	
	
/******************************
* Function to add Technicians *
*******************************/

// Create variable containing values of the HTML Form with the ID turnoverForm
	var form = document.getElementById("turnoverForm");
	
// Create variable for row number which contains the Technician name
	var techNum = 0;
	
// Function to create HTML for new Technicians, form is a blank variable to be used in the function
	function techRow(form) {
	
	// Removes any content from the div ID createTechnicianValidationError
		$("#createTechnicianValidationError").empty();
		
	// Validates a Technician was selected
		if ($("#selTech").val() != "Select Technician") {
	
	// Increment the row number by 1 each time the function runs to ensure every row is unique
		techNum ++;

	// Create variable containing HTML code to create a new line containing the Technician name and a button to remove it
		var row = '<p id="techNum'+techNum+'"> <input type="text" class="selectedTech" name="technicians[]" value="'+form.add_Technician.value+'" readonly> <input type="button" value="-" onclick="removeTech('+techNum+');"></p>';
		
	// Append the new HTML code to the page inside the div addTechnicians to display the Technician added
		$('#addTechnicians').append(row);
	
	// Reset the drop-down menu to display the default value "Select Technician"
		form.add_Technician.value = 'Select Technician';
		} else {
		
		// Create HTML to display an error message if the "+" button is pressed without selecting a Technician from the drop-down
			document.getElementById('createTechnicianValidationError').innerHTML = '<p><img src="http://10.176.105.22/img/yodaIcon.png"></p> Select a real person, you must. Hrrrmmm';
			return false;
		}
	}


/**************************************************************
* Function to remove a Technician before submitting to the DB *
***************************************************************/
	
// Pass the techNum variable through to the function to identify which row to remove
	function removeTech(techNum) {
	
	// Remove the selected Technician
		$('#techNum'+techNum).remove();
	}


/***********************************************************************************
* Function to resize the turnover item box (works on tab over or other key press ) *
************************************************************************************/

	$(document).ready(function(){

	// Add event listener on the textarea for key press
		$('textarea').on('keydown', function(event){
		
		// Removes any content from the div ID createItemValidationError
			$("#createItemValidationError").empty();
		
		// Prevents textarea from resizing when enter key is pressed, no extra white space
			if (event.which == 13) {event.preventDefault();}
			}).on('input', function(){
			
		// Create variable for textarea height required to view all text without the need of a scroll bar
			var totalHeight = $(this).prop('scrollHeight') - parseInt($(this).css('padding-top')) - parseInt($(this).css('padding-bottom'));
			
		// Resize the Turnover Item box based on the amount of text
			$(this).height(totalHeight);
		});
	});	


/**********************************************************************
* Function to clear validation error messages when error is corrected *
***********************************************************************/

	$(document).ready(function(){
	
	// Runs when the date is changed on Advance Date in Search Turnover
		$('#advancedDate').change(function(){
		
		// Clears error message stating a Shift and Date are required in Search Turnover
			$("#searchValidationError").empty();
		});
	
	// Runs when a Shift check-box is checked or unchecked in Search Turnover
		$('.shift').change(function(){
		
		// Clears error message stating a Shift and Date are required in Search Turnover
			$("#searchValidationError").empty();
		});
		
	// Runs when the drop-down menu selection changes to a valid option (Shift) in Create Turnover
		$('#selShift').change(function(){
		
		// Clear error message that alerted to select a shift in Create Turnover
			$("#createShiftValidationError").empty();
		});
		
	// Runs when text is added to the Turnover Item box in Create or Edit Turnover
		$('#textbox').change(function(){
		
		// Clear error message for attempting to add blank turnover item to Create or Edit Turnover
			$("#createItemValidationError").empty();
		});
		
	// Runs when the drop-down menu selection changes to valid option (Technician Name) or when "+" button is pressed to add the Technician to Turnover
		$('#selTech').change(function(){
		
		// Clear error both error messages related to adding Technicians in Create and Edit Turnover
			$("#createTechnicianValidationError").empty();
		});

	});

	
/******************************************************
* Function to hide/show the Event/Shift Log Container *
*******************************************************/

// Run function when the HTML ID hideEventLog (currently assigned to the ninja img) is clicked
	$("#hideEventLog").click(function() {
	
	// Use the jQuery slideToggle function to slowly slide up or down the div container for the Event and Shift Log
		$(".eventShiftLog").slideToggle("slow");
	
	// Use the jQuery toggle function to change the display text under the image (Ninja Show and Ninja Hide)
		$(".ninjaHideShow").toggle();
	});
	
	
					
			