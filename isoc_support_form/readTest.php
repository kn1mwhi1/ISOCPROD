<?php require('lib/Class_ISOCSupportFormDB_Out.php'); 

$test = new ISOCSupportFormDB_Out();

//print_r( $test->getOtherEnvironmentOptions() );
//print_r( $test->getFileEnvironmentOptions() );
//print_r( $test->getStreamEnvironmentOptions() );
//print_r( $test->getJobEnvironmentOptions() );
//print_r( $test->getFileRequestOptions() );
//print_r( $test->getStreamRequestOptions() );
//print_r( $test->getOtherRequestOptions() );

//print_r( $test->getJobRequestOptions() );
//print_r( $test->getMainOptions() );

print_r( $test->getEmail() );


//echo json_encode($test->getMainOptions() );

?>

