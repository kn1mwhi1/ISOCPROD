// Script to control the focus on turnoverForm
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

// Script to warn user on page reload or close if "Submit" not clicked 
		$(window).on('beforeunload', function(){
			var turnoverExists = $('.item').length;
			if (turnoverExists) {
				return 'Turnover has not been saved. All changes will be lost!';
			}
		});
		
		$(document).on("submit", "form", function(event){
		$(window).off('beforeunload');
		});
		
// Script to add/remove Technicians
		var form = document.getElementById("turnoverForm");
		var techNum = 0;
		function techRow(frm) {
			$("#createTechnicianValidationError").empty();
			if ($("#selTech").val() != "Select Technician") {
			techNum ++;			
			var row = '<p id="techNum'+techNum+'"> <input type="text" class="selectedTech" name="technicians[]" value="'+frm.add_Technician.value+'" readonly> <input type="button" value="-" onclick="removeTech('+techNum+');"></p>';
			$('#addTechnicians').append(row);
			frm.add_Technician.value = 'Select Technician';
			} else {
				document.getElementById('createTechnicianValidationError').innerHTML = '<p><img src="http://10.176.105.22/img/yodaIcon.png"></p> Select a real person, you must. Hrrrmmm';
				return false;
			}
		}

		function removeTech(rnum) {
			$('#techNum'+rnum).remove();
		}
		
// Script to dynamically resize the textarea for turnover item when keydown event is called
	$(document).ready(function(){
		$('textarea').on('keydown', function(e){
		// Clearing validation error in turnover item when keydown event is called
			$("#createItemValidationError").empty();
			if (e.which == 13) {e.preventDefault();}
			}).on('input', function(){
			$(this).height(50);
			var totalHeight = $(this).prop('scrollHeight') - parseInt($(this).css('padding-top')) - parseInt($(this).css('padding-bottom'));
			$(this).height(totalHeight);
		});
	});	

// Script to clear validation error message when error is corrected
	$(document).ready(function(){
		$('#advancedDate').change(function(){
			$("#searchValidationError").empty();
		});
		
		$('.shift').change(function(){
			$("#searchValidationError").empty();
		});
		
		$('#selShift').change(function(){
			$("#createShiftValidationError").empty();
		});
		
		$('#textbox').change(function(){
			$("#createItemValidationError").empty();
		});
		
		$('#selTech').change(function(){
			$("#createTechnicianValidationError").empty();
		});

	});

	
	
					
			