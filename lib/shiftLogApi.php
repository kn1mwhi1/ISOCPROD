<?php

require_once 'Class_ShiftLog_Logic.php';

   // must be on all pages
	if(!isset($_SESSION)) 
	{
		session_start();
	}
		 
$tierTwo = new ShiftLog_Logic();



ob_start();
$tierTwo->checkEventPost();
ob_end_flush();


?>