<!doctype html>
<html>
<head>
    <title>PHP Basics</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />   
</head>

<body>
<div>
</div>
<?php
	// Basic Variable with concatenation
	$test="I'm a variable";
	echo $test."<br />";
	
	// Array
	$myArray=array("Matt" , "Matthew", "coffee");
	
	$myArray[0] = "test";
	print_r($myArray);
	echo "<br />";
	
	
	if (isset($_POST["submit"])) 
	{
		if (isset($_POST["name"]))
		{
			for ($x=0; $x < count($myArray) ; $x++)
			{
				if ($_POST["name"] == $myArray[$x] )
				{
					echo "Your logged in ".$_POST["name"];
					return Null;
				}
				elseif ( $x == (count($myArray) - 1))
				{
					echo "I do not know who you are";
				}
					
			}
			
		}
		else
		{
			echo "Please enter your name";
		}
	}
?>


<form method="post">

<label for="name">Name:</label>
<input name="name" type="text" />

<input type="submit" name="submit" value="Submit Your Name" />

</form>

</body>
</html>