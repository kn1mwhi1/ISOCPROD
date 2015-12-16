<?php

require_once 'Class_LoginLogic.php';

   // must be on all pages
	if(!isset($_SESSION)) 
	{
		session_start();
	}
		 
$tierTwo = new LoginLogic();



ob_start();
$tierTwo->checkPost();
ob_end_flush();


?>