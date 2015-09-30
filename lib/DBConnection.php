<?php

class DatabaseConnection

private static $servername = "localhost";
private static $username = "isocdev";
private static $password = "opsisfun11";
private static $dbname = "ISOCDB";

//connection variables
	private static $DBCONNECTION;
	
	function DatabaseConnection ()
	{
		self:createConnection ();		
	}

//start connection
	private static function createConnection()
	{
		if (!isset(self::$DBCONNECTION))
		{
			self::setDBConnection(self::$servername, $username, $password, $dbname);
		
					if self::getDBConnection() ->connect_error)	{
						
					
				die ("connection failed:" . $conn->connect_error);
			}
		}
	}
		//set connection
	protected static function getDBConnection ()
	{
		self::startConnection();
		
		return self::DBCONNECTION;
	}

	private static function seDBConnection($servername, $username, $password, $dbname)
	{
		self::DBCONNECTION =new mysqli($servername, $username, $password, $dbname);
	}
	

$conn = new mysql($servername, $username, $password, $dbname);



$sql="SELECT * FROM TB_SHIFTLOG";



	if ($conn->query($sql)== TRUE){
		echo "Database successfully created";
	}else {
		echo "Error creating database:" . $conn->error;
	}



$conn->close();

?>