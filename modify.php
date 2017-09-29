<?php
// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: login.php');
}

include 'database/config.php';
include 'database/opendb.php';

$beerid = $_POST['beerid'];
$servingid = $_POST['serve'];

$beername = str_replace("'", "''", $_POST['name']);
$url = $_POST['url'];
$date = $_POST['date'];
$thoughts = str_replace("'", "''", $_POST['thoughts']);
$serving =  $_POST['serving'];
$location =  $_POST['location'];
$list =  $_POST['list'];
$cellar = $_POST['cellar'];
$cellardate = $_POST['cellardate'];
$photo = $_POST['photo'];
$char = $_POST['character'];
$check = $_POST['check'];
$vintage = $_POST['vintage'];
$notes = $_POST['notes'];

$deep = $_POST['deep'];
    
$query = "";

if ( $beerid != "" || $servingid != "" )
{
    if ( $beerid != "" )
        $query = "UPDATE Beer SET Name='{$beername}'";
    else
        $query = "UPDATE BeerServings SET Name2='{$beername}'";

    //Query of Beer to Edit
    if ( $url != "" )
       $query = $query . ", BeerAdvocate='{$url}'";
    if ( $thoughts != "" )
       $query = $query . ", Review='{$thoughts}'";
    if ( $vintage != "" )
       $query = $query . ", Vintage='{$vintage}'";
    if ( $date !="" )
       $query = $query . ", Date='{$date}'";
    if ( $serving !="" )
    {
       if ( $beerid != "" )
          $query = $query . ", CellarServing='{$serving}'";
       else
          $query = $query . ", Serving='{$serving}'";
    }
    if ( $location !="" )
       $query = $query . ", Location='{$location}'";

    if ( $char !="" )
       $query = $query . ", Characteristics='{$char}'";

    if ( $list !="" )
       $query = $query . ", List='{$list}'";

    if ( $cellar !="" )
       $query = $query . ", cellared='{$cellar}'";

    if ( $deep !="" )
       $query = $query . ", ExtendedCellar='{$deep}'";

    if ( $cellardate !="" )
       $query = $query . ", CellarDate='{$cellardate}'";

    if ( $photo != "" )
       $query = $query . ", photo_id='{$photo}'";

    if ( $notes != "" )
       $query = $query . ", Notes='{$notes}'";

    if ( $beerid != "" )
        $query = $query . " WHERE beer_id='{$beerid}'";
    else
        $query = $query . " WHERE id='{$servingid}'";

    $result = $conn->query($query);

    if ( $beerid != "" )
    {
        $query = "UPDATE BeerServings SET Name2='{$beername}' WHERE beer_id='{$beerid}'";
        $result = $conn->query($query);
    }
$result->free();
}

include 'database/closedb.php';
?>