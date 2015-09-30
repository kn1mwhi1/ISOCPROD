<?php

require_once 'Class_Event_Logic.php';

   // must be on all pages
	if(!isset($_SESSION)) 
	{
		session_start();
	}
		 
$tierTwo = new Event_Logic();



ob_start();
$tierTwo->checkEventPost();
ob_end_flush();


?>