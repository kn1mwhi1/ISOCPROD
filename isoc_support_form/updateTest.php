<?php 
require('lib/Class_ISOCSupportFormDB_In.php'); 
 
$test = new ISOCSupportFormDB_In();

$updateArray = array("FIRST_NAME"=>"Test", "TEST"=>"blah");
$whereArray = array("FIRST_NAME"=>"Ma");


//updateOneRecordOneTable( $updateArray , $whereArray, $equalsOrLike, $aTable , $fieldTypes = '', $limit = 1)

$test->updateRecordOneTable( $updateArray , $whereArray, 'like' , 'TB_TESTMATT' , 'sss');
echo 'The ID is: '.$test->getLastTransactionID();

?>

