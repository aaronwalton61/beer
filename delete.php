<?php
// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: login.php');
}

include 'database/config.php';
include 'database/opendb.php';

$beerid = $_POST['beer'];
if ($beerid=="") $beerid = $_GET['beer'];
$servingid = $_POST['serving'];
if ($servingid=="") $servingid = $_GET['serving'];

$query = "";

if ( $beerid != "" || $servingid != "" )
{
    if ($beerid != "")
    {
	    $query  = "DELETE FROM Beer WHERE beer_id='$beerid'";
    }
    else
    {
	    $query  = "DELETE FROM BeerServings WHERE id='$servingid'";
    }
    $result = $conn->query($query);
    $result->free();
}
include 'database/closedb.php';
?>
