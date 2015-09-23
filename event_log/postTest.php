<?php

$first_name= array("Matthew", "Janina", "Christopher");
$last_name = array("White", "White", "White");
$position = array("Right", "Left", "Center");
$office = array("Corner Stone", "Home", "ISOC");
$start_date = array("8/15/2014", "9/8/2010", "1/12/2006");
$salary = array("65000", "79000", "98000");

return echo json_encode(array( $first_name, $last_name, $position, $office, $start_date, $salary));



?>