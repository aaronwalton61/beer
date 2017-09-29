<?php
// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: login.php');
}

include 'database/config.php';
include 'database/opendb.php';

$beername = str_replace("'", "''", $_POST['beer']);
$url = $_POST['link'];
$date = $_POST['date'];
$char = $_POST['char'];
$thoughts = str_replace("'", "''", $_POST['thoughts']);
$serving =  $_POST['serving'];
$location =  $_POST['location'];
$list =  $_POST['list'];
$cellar = $_POST['cellar'];
$deep = $_POST['deep'];

if ( beername != "" )
{
    switch ($date)
    {
         case 0:
           $date = "0000-00-00";
           break;
         case 1:
           $date = date("Y-m-d");
           break;
         default:
           $date = "0000-00-00";
    }

    if ( $cellar > 0 )
    {
       $cellar1 = ", Cellared, CellarDate, CellarServing";
       $cellar2 = ", '$cellar', '".date("Y-m-d")."', '$serving'";
       $cellar3 = ", _CellarDate";
       $cellar4 = ", '".date("Y-m-d")."'";
    }

    $query = "INSERT INTO Beer (Name, BeerAdvocate, Characteristics, ExtendedCellar $cellar1 ) VALUES ('$beername', '$url', '$char', '$deep' $cellar2 )";
    if (!$new = $conn->query($query))
    {
        // Oh no! The query failed. 
        echo "Sorry, the website is experiencing problems.";

        // Again, do not do this on a public site, but we'll show you how
        // to get the error information
        echo "Error: Our query failed to execute and here is why: \n";
        echo "Query: " . $sql . "\n";
        echo "Errno: " . $conn->errno . "\n";
        echo "Error: " . $conn->error . "\n";
        exit("Insert Beer");
    }

    $new->free();

    $query = "SELECT * FROM Beer WHERE Name='$beername'";
    if (!$new = $conn->query($query))
    {
        // Oh no! The query failed. 
        echo "Sorry, the website is experiencing problems.";

        // Again, do not do this on a public site, but we'll show you how
        // to get the error information
        echo "Error: Our query failed to execute and here is why: \n";
        echo "Query: " . $sql . "\n";
        echo "Errno: " . $conn->errno . "\n";
        echo "Error: " . $conn->error . "\n";
        exit("Select Beer");
    }

    $row = $new->fetch_assoc();
    $new->free();
 
       // if date is non zero then add in a serving as well, drinking it now.
       if ( $date != "0000-00-00" )
       {
	    $beer_id = $row['beer_id'];

	    $query = "INSERT INTO BeerServings (beer_id, Name2, Review, Date, Location, List, Serving $cellar3) VALUES ('$beer_id','$beername','$thoughts', '$date', '$location', '$list', '$serving' $cellar4 )";
	    $new = $conn->query($query);
        $new->free();
       }
}

include 'database/closedb.php';
?>