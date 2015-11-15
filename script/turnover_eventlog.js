


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