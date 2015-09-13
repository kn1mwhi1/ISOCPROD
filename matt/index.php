<?php 
// How to connect retrieve and save info in database.
	$link = mysqli_connect("localhost", "isocdev", "opsisfun11", "ISOCDB");
	
	
	if (mysqli_connect_error() ) 
	{
		die("Could not connect to database");
	}
	
	// select from database
	//$query = 'SELECT * FROM TB_TESTMATT ';
	
	// Insert into database 
	//$query = "INSERT INTO `ISOCDB`.`TB_TESTMATT` (`FIRST_NAME`, `LAST_NAME`) VALUES ('Janina', 'White')";
	//mysqli_query($link, $query);
	
	$query = 'SELECT * FROM TB_TESTMATT ';
	
	if ($result=mysqli_query($link, $query))
	{
		$row = mysqli_fetch_array($result);
		print_r($row);
		
	}
	else
	{
		echo "It Failed!";
	}

?>