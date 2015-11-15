// Temporary script to fix height of Turnover Items in Edit Turnover
		
	$(document).ready(function() {
		$("textarea").height(50);
	});


// Script to add/remove additional rows of Turnover
		var rowNum = 0;
		function addRow(trnOver) {
		// Clearing Turnover item validation error when + is clicked
			$("#createItemValidationError").empty();
			var itemEntry = document.forms["trnOver"]["add_turnover"].value;
			if (itemEntry != "") {
			rowNum ++;
			
			// Replace double and single quotes with the html standard of quote
			var turnOverValue = trnOver.add_turnover.value;
			// anything in the [ ] brackets will be replaced with the ' ' quotes
			turnOverValue = turnOverValue.replace(/['"]/g,'&quot;');
			
			var row = '<p id="rowNum'+rowNum+'"><textarea name="newTurnover[]" class="item">'+turnOverValue+'</textarea><input type="button" value="Remove" onclick="removeRow('+rowNum+');"></p>';
			
			$('#addTurnover').append(row);

			trnOver.add_turnover.value = '';
			
		// Start - reset textarea size on button click
			$("textarea").mousemove(function() {
			$(this).height(50);
			$("textarea").show();
			});
		// End - reset textarea resize on button click
			} else {
				document.getElementById('createItemValidationError').innerHTML = '<p><img src="http://10.176.105.22/img/yodaIcon.png"></p>Enter a blank turnover item, you cannot.';
			}
		}
		
		function removeRow(rnum) {
			if (confirm("Are you sure you want to delete this item?")) {
				$('#rowNum'+rnum).remove();
			}
		}
		
// Script to remove existing Technicians	
	function removeoldTech () {
		$(".oldTech").on("click", function(){
			$(this).remove();
			$(".oldTech").off("click");
			var removeOldTech = $(this).attr('id');
			
			$.ajax({
			type: "POST",
			url: "/lib/toDataBaseDelete.php",
			data: {oldTech:removeOldTech},
			
			});
// Adding a confirmation message that a Technician was deleted
			document.getElementById('deleteTechnicianValidation').innerHTML = '<p><img src="/img/cyberman.png"></p>A Technician has been <p>DELETED!</p>';
		});
	}

// Script to remove Technician deleted confirmation on mouse click or tab
	$(document).ready(function() {
	// Works on tab or other key press
		$('html').keyup(function() {
			$('#deleteTechnicianValidation').empty();
		});
	// Works on mouse click
		$('html').mouseup(function() {
			$('#deleteTechnicianValidation').empty();
		});
	
	});

// Script to remove existing rows of Turnover Items
	function removeoldTurnover () {
	//	if (confirm("Are you sure you want to delete this item?")) {
			$(".oldTurnover").on("click", function(){
				var removeOldTurnover = $(this).attr('id');					
					$.ajax({
					type: "POST",
					url: "/lib/toDataBaseDelete.php",
					data: {oldTurnover:removeOldTurnover}
					});
				
				$(this).replaceWith('<div class="deleteTurnoverValidation"><p><img src="/img/cyberman.png"></p>A Turnover Item has been <p>DELETED!</p><div>');
				$(".oldTurnover").off("click");
	// Adding a confirmation message that a Turnover Item was deleted
			//	document.getElementById('deleteTurnoverValidation').innerHTML = '<p><img src="/img/cyberman.png"></p>A Turnover Item has been <p>DELETED!</p>';
			});
	//	}
	}

// Script to clear Turnover Item deleted confirmation
	
	$(document).ready(function() {
		$("html").mousedown(function() {
			$(".deleteTurnoverValidation").empty();
		});
		
		$("html").keydown(function() {
			$(".deleteTurnoverValidation").empty();
		});
	});
	
//Script to add text counter to Turnover Item Field (works on tab over)//		
	$(document).ready(function() {
		var text_max = 500;
		$('#charNum').html(text_max + ' /500');
		$("textarea[name=add_turnover]").keyup(function() {
			var text_length = $("textarea[name=add_turnover]").val().length;
			var text_remaining = text_max - text_length;
			$('#charNum').html(text_remaining + ' /500');
		});
	});
	
//Script to add text counter to Turnover Item Field (works on mouse click)//
	$(document).ready(function() {
		var text_max = 500;
		$('#charNum').html(text_max + ' /500');
		$("textarea[name=add_turnover]").mouseup(function() {
			var text_length = $("textarea[name=add_turnover]").val().length;
			var text_remaining = text_max - text_length;
			$('#charNum').html(text_remaining + ' /500');
		});
	});

// Script to Validate all required data is populated
	function validateForm() {
		var manEntry = document.forms["trnOver"]["add_turnover"].value;
		var techSelect = document.forms["trnOver"]["add_Technician"].value;
		
		if (manEntry != "") {
			document.getElementById('createItemValidationError').innerHTML = '<p><img src="http://10.176.105.22/img/yodaIcon.png"></p>An unsaved turnover item there is. Delete text from the turnover field or click Add Item, you should. Herh herh herh.';
			return false;
		} else if (techSelect != "Select Technician") {
			document.getElementById('createTechnicianValidationError').innerHTML = '<p><img src="http://10.176.105.22/img/yodaIcon.png"></p>Added to turnover a selected technician was not. Click "+" to add you must. Hrrrmmm.';
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
	