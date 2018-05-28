<?php

// mysql connection variables
$db_user = 'root';
$db_pass = '';
$db_name = 'monitor';
$db_host = 'localhost';

// connect to mysql
$db = new mysqli($db_host, $db_user, $db_pass, $db_name);

// if a connection error is present, print message and exit
if ( $db->connect_errno ) {
	echo "Failed to connect to database!";
	die;
}

?>