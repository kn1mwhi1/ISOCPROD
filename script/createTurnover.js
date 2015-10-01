

//Script to add text counter to Turnover Item Field (works on tab over)//		
		$(document).ready(function() {
			var text_max = 500;
			$('#charNum').html(text_max + ' /500');
			$('#textbox').keyup(function() {
				var text_length = $('#textbox').val().length;
				var text_remaining = text_max - text_length;
				$('#charNum').html(text_remaining + ' /500');
			});
		});
	
//Script to add text counter to Turnover Item Field (works on mouse click)//
	$(document).ready(function() {
			var text_max = 500;
			$('#charNum').html(text_max + ' /500');
			$('#textbox').mouseup(function() {
				var text_length = $('#textbox').val().length;
				var text_remaining = text_max - text_length;
				$('#charNum').html(text_remaining + ' /500');
			});
		});

// Script to add/remove additional rows of Turnover
		var rowNum = 0;
		function addRow(trnOver) {
			$("#createItemValidationError").empty();
			var itemEntry = document.forms["trnOver"]["add_turnover"].value;
			if (itemEntry != "") {
			rowNum ++;
			
			// Replace double and single quotes with the html standard of quote
			var turnOverValue = trnOver.add_turnover.value;
			// anything in the [ ] brackets will be replaced with the ' ' quotes
			turnOverValue = turnOverValue.replace(/['"]/g,'&quot;');
			
			var row = '<p id="rowNum'+rowNum+'"><textarea name="turnover[]" class="item">'+turnOverValue+'</textarea><input type="button" value="Remove" onclick="removeRow('+rowNum+');"></p>';
			$('#addTurnover').append(row);

			trnOver.add_turnover.value = '';
			
		// Start - reset textarea size on button click
			$("textarea").mousemove(function() {
			$(this).height(50);
			$("textarea").show();
			});
		// End - reset textarea resize on button click
			} else {
				document.getElementById('createItemValidationError').innerHTML = '<p><img src="img/yodaIcon.png"></p>Enter a blank turnover item you cannot. Yeesssssss.';
			}
		}
		
		function removeRow(rnum) {
			if (confirm("Are you sure you want to delete this item?")) {
				$('#rowNum'+rnum).remove();
			}
		}

// Script to Validate all required data is populated
	function validateForm() {
		$("#createItemValidationError").empty();
		var manEntry = document.forms["trnOver"]["add_turnover"].value;
		var shiftEntry = document.forms["trnOver"]["shift"].value;
		var techEntry = document.querySelector(".selectedTech");
		var techSelect = document.forms["trnOver"]["add_Technician"].value;
		
		if(manEntry != "") {
			document.getElementById('createItemValidationError').innerHTML = '<p><img src="/img/yodaIcon.png"></p>An unsaved turnover item, there is. Delete the text from the turnover field or click add item, you must.';
			return false;
		}
		else if (shiftEntry == "Select Shift") {
			document.getElementById('createShiftValidationError').innerHTML = '<p><img src="/img/yodaIcon.png"></p>Select a shift, you must. Choose one from the dropdown, you should.';
			return false;
		}
		else if (techSelect != "Select Technician") {
			document.getElementById('createTechnicianValidationError').innerHTML = '<p><img src="/img/yodaIcon.png"></p>Added to turnover a selected technician was not. Click "+" to add you must. Hrrrmmm.';
			return false;
		}			
		else if (techEntry == null) {
			document.getElementById('createTechnicianValidationError').innerHTML = '<p><img src="/img/yodaIcon.png"></p>Added to turnover a technician was not.  Select at least 1 technician, you must. Yeesssssss.';
			return false;
		}
	}
	

	// Global Variables
 
	 selection = 'Current Events';
	 viewSelection = 'Normal View';
	 temp ='';

	 // When document has loaded run ajax command every second.
	$(document).ready(function(){
		//alert('test');
		ajaxcall();
		setInterval(ajaxcall, 60000);
	 });

	function ajaxcall(){
		 $.ajax({
			 type: "POST",
			 url: 'lib/eventLogApi.php',
			 data:{ submit : selection, view : viewSelection },
			 success: function(someData){
				
					if ( temp != someData)
					{
						 $('#dynamicTable').html(someData);
						 temp = someData;
					 }
			 }
		 });
	}

