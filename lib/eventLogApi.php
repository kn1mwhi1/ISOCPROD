<?php

require_once 'Class_Event_Logic.php';
$tierTwo = new Event_Logic();


ob_start();
$tierTwo->checkEventPost();
ob_end_flush();


?>