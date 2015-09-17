<?php 
require('lib/Class_ISOCSupportFormDB_Out.php'); 
require('lib/Class_LoginLogic.php');

$test = new ISOCSupportFormDB_Out();
$test2 = new LoginLogic();

//print_r( $test->getOtherEnvironmentOptions() );
//print_r( $test->getFileEnvironmentOptions() );
//print_r( $test->getStreamEnvironmentOptions() );
//print_r( $test->getJobEnvironmentOptions() );
//print_r( $test->getFileRequestOptions() );
//print_r( $test->getStreamRequestOptions() );
//print_r( $test->getOtherRequestOptions() );

//print_r( $test->getJobRequestOptions() );
//print_r( $test->getMainOptions() );

//print_r( $test->getEmail() );
//session_start();
//print_r($_SESSION);
$test2->checkSession();
echo "Everything is awesome! http://  HTTPHost: $_SERVER[HTTP_HOST]  URI: $_SERVER[REQUEST_URI]<br />";



print_r($_SESSION);
//echo json_encode($test->getMainOptions() );
/*
function clear()
{
session_unset(); 
session_destroy();
}
*/
?>

<html>
<form method="get" action="logout.php">
    <button type="submit">Clear Session</button>
</form>
</html>