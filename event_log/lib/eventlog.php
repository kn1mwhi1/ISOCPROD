<?php
if ($_POST && isset ())


//calls data user has put in from file
$Date/Time=$_POST['datetime'];
$Method=$_POST['method'];
$Person Contacted=$_POST['contact'];
$Notes=$_POST['notes'];
$RC=$_POST['RCnum'];

//opens file
$fp=fopen("*test1.txt","a");

//saves data in specific order to file
$savestring=$datetime.",".$method.",".$contact.",".$notes.",".$RCnum."n";

//writes data to the text file collected from prior commands
fwrite($fp,$savestring);

echo"saved to file";


?>