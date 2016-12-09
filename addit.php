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
       $new = mysql_query($query) or die('Insert Error, insert query failed');
       mysql_free_result($new);

       $query = "SELECT * FROM Beer WHERE Name='$beername'";
       $new = mysql_query($query) or die('Insert Error, insert query failed');
       $row = mysql_fetch_array($new, MYSQL_ASSOC);
       mysql_free_result($new);

       // if date is non zero then add in a serving as well, drinking it now.
       if ( $date != "0000-00-00" )
       {
	    $beer_id = $row['beer_id'];

	    $query = "INSERT INTO BeerServings (beer_id, Name2, Review, Date, Location, List, Serving $cellar3) VALUES ('$beer_id','$beername','$thoughts', '$date', '$location', '$list', '$serving' $cellar4 )";
	    $new = mysql_query($query) or die('Insert Error, insert query failed');
       }

    ?>
<div id="test" data-role="page">
    <div id="Status" title="Status" class="panel">
        <h2>Add New Beer</h2>
        <ul data-role="listview">
          <li>New Beer <?php echo $beername; ?> added</li>
          <li><?php echo $query ?></li>
          <li><?php echo $deepcellar ?></li>
        </ul>
    </div>
</div>
    <?php
       mysql_free_result($new);
}

include 'database/closedb.php';
?>