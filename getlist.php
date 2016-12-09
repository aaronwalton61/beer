<?php
include 'common.php';
// Load up the DB config and open it up.
//**************************************
include 'database/config.php';
include 'database/opendb.php';

$listname =  $_GET['list'];

if ($listname != "" )
{
$query  = "SELECT * FROM BeerServings WHERE List = '{$listname}' ORDER BY Date Desc";
$list = mysql_query($query);
$total = mysql_num_rows($list);
?>
<div data-role="page" id="Cellar" class="">
    <div data-role="header">
        <a href="#About" data-icon="info">About</a>
        <h1><?php echo $listname; ?></h1>
        <a href="#addit" data-icon="plus">Add</a>
    </div>
    <ul data-role="listview" id="Lists" title="List" class="panel">
<?php
while($row = mysql_fetch_array($list, MYSQL_ASSOC))
{
   $color = wherecolor($row['Date'], $row['Location']." ".$row['Serving']." ".$row['List']);

   $icon = icons( $row['Characteristics']." ".$row['Serving'] );

   // Each list item for all the beers
   echo "<li><a href='view.php?beer=".htmlentities($row['beer_id'], ENT_QUOTES)."'><font color={$color}>{$row['Name2']}</font><span class='ui-li-aside'> {$icon}</span><p>{$row['Serving']} on {$row['Date']} at {$row['Location']} for {$row['List']}</p></a></li>";
} 
echo "</ul></div>";
mysql_free_result($list);
}

include 'database/closedb.php';
?>