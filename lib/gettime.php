<?php 
// must be on all pages
	 if(!isset($_SESSION)) 
		{
			session_start();
		}
//print_r($_SESSION);
if (isset($_SESSION['REQUEST_TICKET_NUMBER']) && $_SESSION['REQUEST_TICKET_NUMBER'] != '')
{
		if ( !isset($_SESSION['REQUEST_COMPLETION_DATETIME']) && $_SESSION['REQUEST_COMPLETION_DATETIME'] == '')
		{
				$dateTimeNow = date('Y-m-d H:i:s');
		}
		else
		{
		
			$dateTimeNow = $_SESSION['REQUEST_COMPLETION_DATETIME'];
		}

}
else
{
	echo "00:00:00:00";
	exit();
}


//echo $date = date( 'd h:i:s', ( strtotime($dateTimeNow) - strtotime($_SESSION['REQUEST_SUBMISSION_DATETIME']) ) );


$dateTimeNow = new DateTime( $dateTimeNow) ;
$other = new DateTime ( $_SESSION['REQUEST_SUBMISSION_DATETIME']  );

$interval = $other->diff( $dateTimeNow);

echo $hour = $interval->format('%D:%H:%I:%S');

//print_r($_SESSION);

?>

