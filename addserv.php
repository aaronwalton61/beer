<?php
// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: login.php');
}

include 'database/config.php';
include 'database/opendb.php';

$beerid = $_GET['beer'];
$cellar = $_GET['cellar'];

if ( beerid != "" )
{
    $date = date("Y-m-d");
    $review = "A: \nS: \nT: \nM: \nD:";

    $query = "SELECT * FROM Beer WHERE beer_id='{$beerid}'";
    $new = $conn->query($query) or die('Query Error, query failed');
    $row = $new->fetch_assoc();
    $new->free();

    // Need to change this so it works and doesn't duplicate the single quote
    $name = str_replace("'", "''", $row['Name']);
    $Location = "None";
    $List = "None";
    $Serving = "Draught";
    $query1="";

    if ( $name != "" )
    {
       if ( $cellar == "" || $cellar == NULL )
          $query = "INSERT INTO BeerServings (beer_id, Name2, Review, Date, List, Location, Serving ) VALUES ('{$row['beer_id']}', '{$name}', '$review', '$date', '$List', '$Location', '$Serving' )";
       else
       {
          $Location = "Home";
          $List = "Home";
          $query = "INSERT INTO BeerServings (beer_id, Name2, Review, Date, _CellarDate, Serving, List, Location ) VALUES ('{$row['beer_id']}', '{$name}', '$review', '$date', '{$row['CellarDate']}', '{$row['CellarServing']}', '$List', '$Location' )";
          // I'd like to clear if it is zero (0)
          if ( $row['cellared'] > 0 )
             $query1 = "UPDATE Beer SET cellared = cellared-1 WHERE beer_id='{$row['beer_id']}'";
          else
             $query1="";
       }
    }
    $new = $conn->query($query) or die('Insert Error, insert query failed');
?>
    <div id="Status" data-role="page">
        <h2>Add Serving</h2>
        <ul data-role="viewlist">
        <li data-role="">beer_id</li>
          <li><?php echo $beerid;?></li>
          <li>New Serving <?php echo $row['Name'];?> Serving added</li>
          <li>id <?php echo $row['beer_id'];?></li>
<?php
    $new->free();

    // increment the cellared count
    if ($query1 != "")
    {
        $new = $conn->query($query1) or die('Insert Error, insert query failed');
        $new->free();
?>
        <li class=group>Update Cellar</li>
          <li>New Beer <?php echo $row['Name'];?> Serving added cellared <?php echo $row['cellared'];?></li>
          <li>Query1= <?php echo $query1;?></li>
<?php
    }
?>
   </ul>
</div>
<?php
}

include 'database/closedb.php';
?>