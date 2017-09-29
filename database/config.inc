<?php

$hostname = 'localhost';        // Your MySQL hostname. Usually named as 'localhost', so you're NOT necessary to change this even this script has already online on the internet.
$dbname   = 'aaronwa1_AaronWalton'; // Your database name.
$username = 'aaronwa1_imus';             // Your database username.
$password = 'imuswalton61';                 // Your database password. If your database has no password, leave it empty.

// Let's connect to host
$uconn = mysqli_connect($hostname, $username, $password, $dbname) or DIE('Connection to host is failed, perhaps the service is down!');
// Select the database
//mysqli_select_db($dbname) or DIE('Database name is not available!');

?>