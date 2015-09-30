// Disables ability to check more than 1 CheckBox, used in Search Turnover
	$(document).ready(function() {
		$('input[type="checkbox"]').on('change', function() {
			$(this).siblings('input[type="checkbox"]').not(this).prop('checked', false);
		});
	});
	
// Script to validate a Shift and Date were both selected on Advanced Search in the Search Turnover Form	
	function validateForm() {
		var shiftIsChecked = $('input[name="shift-box"]:checked').length;
		var dateIsSelected = document.getElementById('advancedDate').value;
		
		if(shiftIsChecked == 0 || dateIsSelected == "") {
			document.getElementById('searchValidationError').innerHTML = '<p><img src="http://10.176.105.22/img/yodaIcon.png"></p>Choose a shift and a date, you must.';
			return false;
			
		}
	}