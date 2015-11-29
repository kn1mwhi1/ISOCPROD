/**************************************************************************
* Disables ability to check more than 1 CheckBox, used in Search Turnover *
***************************************************************************/

	$(document).ready(function() {
	
	// Event Listener to run function when boxes are checked or unchecked
		$('input[type="checkbox"]').on('change', function() {
		
		// Set the value of all CheckBoxes to be unchecked (or false) except for the one clicked on
			$(this).siblings('input[type="checkbox"]').not(this).prop('checked', false);
		});
	});
	
/********************************************************************************************************
* Script to validate a Shift and Date were both selected on Advanced Search in the Search Turnover Form *
*********************************************************************************************************/

	function validateForm() {
	
	// Create variable for validation, equals 1 if CheckBox is checked and 0 if not
		var shiftIsChecked = $('input[name="shift-box"]:checked').length;
		
	// Create variable for validation, equals the date in quotes if populated and blank quotes "" if not
		var dateIsSelected = document.getElementById('advancedDate').value;
	
	// Validates both a shift and date were selected
		if(shiftIsChecked == 0 || dateIsSelected == "") {
		
		// Create HTML to display error and prevent form submission if a Shift or Date were not selected
			document.getElementById('searchValidationError').innerHTML = '<p><img src="http://10.176.105.22/img/yodaIcon.png"></p>Choose a shift and a date, you must.';
			return false;
		}
	}