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
$servingid = $_GET['serving'];

if ($beerid != "")
{
$query  = "SELECT * FROM Beer WHERE beer_id='{$beerid}'";
$result = mysql_query($query);
$count = mysql_num_rows($result);

$row = mysql_fetch_array($result, MYSQL_ASSOC);

mysql_free_result($result);
?>
<div data-role="page" id="View">
<div data-role="panel" id="mypanel" data-position="right" data-display="overlay">
    <!-- panel content goes here -->
    <img src="getphoto.php?id=<?php echo $row['photo_id']; ?>" width=250 />
</div><!-- /panel -->
    <div data-role="header">
        <a href="#About" data-icon="info">About</a>
        <h1>View Beer</h1>
        <a href="#addit" data-icon="plus">Add</a>
    </div>
    <div data-role="content">
<ul data-role='listview' data-split-icon='info' data-split-theme='a' data-inset='true' id='viewit' title='View Beer'>
         <li><a href="edit.php?beer=<?php echo $beerid;?>"><?php echo $row['Name'];?><span class='ui-li-aside'><img src="images/BeerAdvocate.gif"></span></a><a href="<?php echo $row['BeerAdvocate'];?>" target="_new">Beer Advocate</a></li>
    <li><a href="#mypanel">Photo (id=<?php echo $row['photo_id']; ?>)</a></li>
    <!--     <li><a href="showphoto.php?id=<?php echo $row['photo_id']; ?>">Photo (id=<?php echo $row['photo_id']; ?>)</a></li>. -->
<?php if ( $row['cellared'] > 0 ) { ?>
    <li data-role="listdivider">Cellar</li>
         <li data-icon="plus"><a href="addserv.php?beer=<?php echo $beerid;?>&cellar=yes"><?php echo $row['cellared']." beer(s) cellared ".$row['CellarDate']; ?></a><a href="addserv.php?beer=<?php echo $beerid;?>">Add Serving</a></li>
<?php } ?>
    <li data-icon="plus"><a href="addserv.php?beer=<?php echo $beerid;?>">Add Serving</a></li>
<?php
$query = "SELECT * FROM BeerServings WHERE beer_id='{$beerid}' ORDER BY Date DESC";
$result = mysql_query($query);
$count = mysql_num_rows($result);

    echo "<div data-role='collapsible' data-theme='b' data-content-theme='c'><h2>Beer Servings</h2><ul id='swipelist' data-role='listview' data-split-icon='gear' data-split-theme='a' data-inset='true'>";
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
    {
         switch ( $row['Serving'] )
         {
           case "Bottle":
             $servingicon = "bottle.png";
             break;

           default:
             $servingicon = "what.png";
             break;
         }

         switch ( $row['List'] )
         {
           case "Taco Mac I":
             $icon = "TM1.png' width=20";
             break;
           case "Taco Mac II":
             $icon = "TM2.png' width=20";
             break;
           case "TM Johns Creek":
             $icon = "TM3.png' width=20";
             break;
           case "Taco Mac River":
             $icon = "tm-r.png' width=20";
             break;
           case "Summits":
             $icon = "summits.png' width=20";
             break;
           case "McCrays":
             $icon = "mccray.png' width=20";
             break;
           case "Mellow Mushroom":
             $icon = "shroom.png' width=30";
             break;
            case "WOB":
             $icon = "wob.jpg' width=50";
             break;
          default:
             switch ( $row['Location'] )
             {
               case "Hooters":
                 $icon = "hooters.png' width=20";
                 break;
               case "Tilted Kilt":
                 $icon = "tiltedkilt.png' width=20";
                 break;
               case "Home":
                 $icon = "house.png'";
                 break;
               case "Beerfest":
                 $icon = "beerfest.png'";
                 break;
               case "Taco Mac":
                 $icon = "tm-r.png' width=20";
                 break;
               case "McCray":
                 $icon = "mccray.png' width=20";
                 break;
               case "Mellow Mushroom":
                 $icon = "shroom.png' width=30";
                 break;
               case "WOB":
                 $icon = "wob.jpg' width=50";
                 break;
              default:
                  $icon = "what.png'";
                  break;
             }
             break;
         }
         $html_icon = "<img src='images\\".$icon.">";
         if ( $row['Date'] == '0000-00-00' )
             echo "<li><a href='edit.php?serving={$row['id']}'>".$row['Date']." ".$row['Serving']." ".$row['Vintage']."<span class='ui-li-aside'> ".$html_icon."</span></a></li>";
         else
             echo "<li><a href='view.php?serving={$row['id']}'>".$row['Date']." ".$row['Serving']." ".$row['Vintage']."<span class='ui-li-aside'> ".$html_icon."</span></a><a href='edit.php?serving={$row['id']}'>Edit Serving</a></li>";
    }
    echo "</ul></div>";
mysql_free_result($result);
?>
<fieldset class="ui-grid-a">

</fieldset>
    <li data-role="listdivider">Notes</li>
         <li><textarea name="notes" readonly="readonly"><?php echo $row['Notes'];?></textarea></li>
</ul>
</div>
</div>
<?php
}
else 
{
$query  = "SELECT * FROM BeerServings WHERE id='{$servingid}'";
$result = mysql_query($query);
$count = mysql_num_rows($result);

$row = mysql_fetch_array($result, MYSQL_ASSOC);
mysql_free_result($result);

         switch ( $row['List'] )
         {
           case "Taco Mac I":
             $icon = "TM1.png' width=20";
             break;
           case "Taco Mac II":
             $icon = "TM2.png' width=20";
             break;
           case "TM Johns Creek":
             $icon = "TM3.png' width=20";
             break;
           case "Taco Mac River":
             $icon = "tm-r.png' width=20";
             break;
           case "Summits":
             $icon = "summits.png' width=20";
             break;
           case "McCray":
             $icon = "mccray.png' width=20";
             break;
           case "Mellow Mushroom":
             $icon = "shroom.png' width=30";
             break;
           case "WOB":
             $icon = "wob.jpg' width=50";
             break;
           default:
             switch ( $row['Location'] )
             {
               case "Hooters":
                 $icon = "hooters.png' width=20";
                 break;
               case "Tilted Kilt":
                 $icon = "tiltedkilt.png' width=20";
                 break;
               case "Home":
                 $icon = "house.png'";
                 break;
               case "Beerfest":
                 $icon = "beerfest.png'";
                 break;
               case "Taco Mac":
                 $icon = "tm-r.png' width=20";
                 break;
               case "McCray":
                 $icon = "mccray.png' width=20";
                 break;
               case "Mellow Mushroom":
                 $icon = "shroom.png' width=30";
                 break;
               case "WOB":
                 $icon = "wob.jpg' width=50";
                 break;
              default:
                  $icon = "what.png'";
                  break;
             }
             break;
         }
         $html_icon = "<img src='images\\".$icon.">";

?>
<div data-role="page" id="View" class="">
    <div data-role="header">
        <a href="#About" data-icon="info">About</a>
        <h1>View Serving</h1>
        <a href="#addit" data-icon="plus">Add</a>
    </div>
<ul id='viewserv' title='View Serving' data-role='listview'>
    <li data-role="listdivider">Date & Serving</li>
         <li><?php echo $row['Name2']." ".$row['Date']." ".$row['Serving'];?></li>
    <li data-role="listdivider">Location & List</li>
         <li><?php echo $row['List']." // ".$row['Location']; ?><span class='ui-li-aside'><?php echo $html_icon;?></span></li>
    <li data-role="listdivider">Notes</li>
         <li><textarea name="review" readonly="readonly"><?php echo $row['Review'];?></textarea></li>
    <a href="edit.php?serving=<?php echo $row['id']?>" data-role="button">Edit Serving</a>
</ul>
</div>
<?php
}

include 'database/closedb.php';
?>