<?php

require('conn.php');

$var = $_GET["q"];                   //q is the variable which gets from rf.php which stores the input value of emailid
//echo $var;

$query = "SELECT `emailid` FROM `form` WHERE `emailid` = '$var' ";
//echo $query;
    $sql=mysqli_query( $conn, $query);
    if( mysqli_num_rows($sql) >  0){                        //mysqli_num_rows return 0 or 1 for the coondition either it is true or false
    	$emailiderr = "This email is already being used";
  
	}else{
		//echo "Emailid is valid";
		$emailiderr= "";
	}
	echo $emailiderr; 

?>