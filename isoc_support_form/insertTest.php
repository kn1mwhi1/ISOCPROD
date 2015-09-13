<?php 
require('lib/Class_ISOCSupportFormDB_In.php'); 
 
$test = new ISOCSupportFormDB_In();


$anArray = array("FIRST_NAME"=>"Matthew", "LAST_NAME"=>"White");


//$test->insertName("Janina", "White");


//$temporary = array("ss","Janina","White");

$test->insertRecordOneTable( $anArray , 'TB_TESTMATT' );




echo 'The ID is: '.$test->getLastTransactionID();

?>

