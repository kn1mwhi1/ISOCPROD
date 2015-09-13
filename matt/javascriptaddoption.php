<!DOCTYPE html>
<html>
<body>

<p>Click the button to make a BUTTON element with text.</p>
<div id="mySelect">
</div>
<button onclick="myFunction()">+</button>

<script>
function myFunction() {
    
	var newListData = document.createElement("select");
    var frag = document.createDocumentFragment();
	
	newListData.options.add( new Option("Method1","AU", true, true) );
	newListData.options.add( new Option("Method2","FI") );

	
	
	frag.appendChild(newListData);
	
	document.getElementById("mySelect").appendChild(frag);
	
}
</script>

</body>
</html>
