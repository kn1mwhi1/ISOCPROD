<?php

class BaseDataBase {
	
	// PROPERTIES AND CONSTANTS
	private static $HOST = 'localhost';
	private static $USER = 'isocdev';
	private static $PASSWORD = 'opsisfun11';
	private static $DATABASE_NAME = 'ISOCDB';
	
	// Database connection variable
	private static $DATABASE_CONNECTION;
	
		// Constructor
	function BaseDataBase()
	{
		self::startConnection();
	}

	// Instantiate the connection
	private static function startConnection()
	{
		if (!isset(self::$DATABASE_CONNECTION))
		{
			self::setDbConnection( self::$HOST, self::$USER, self::$PASSWORD, self::$DATABASE_NAME);
		
			if (self::getDbConnection()->connect_errno) {
			
				throw new Exception("Failed to connect to MySQL: " . self::getDbConnection()->connect_error );
			}
		}
	}

	// Retrieve database connection
	protected static function getDbConnection()
	{ 
		self::startConnection();
		
		return self::$DATABASE_CONNECTION;
	}
	
	// Set database connection
	private static function setDbConnection($host, $user, $password, $database)
	{
		self::$DATABASE_CONNECTION = new mysqli( $host , $user , $password , $database );
	}

	public static function closeDbConnection()
	{
		mysqli_close(self::$DATABASE_CONNECTION );
	}


}
?>