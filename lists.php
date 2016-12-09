<?php
// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: index.php');
}

// Load up the DB config and open it up.
//**************************************
include 'database/config.php';
include 'database/opendb.php';

$query = "SELECT * FROM `BeerLists`";
$list = mysql_query($query);
?>
<div data-role="page" id="Cellar" class="">
    <div data-role="header">
        <a href="#About" data-icon="info">About</a>
        <h1>Lists</h1>
        <a href="#addit" data-icon="plus">Add</a>
    </div>
    <ul data-role="listview" id="Lists" title="List Totals" class="panel">
<?php
while($row = mysql_fetch_array($list, MYSQL_ASSOC))
{ 
	if ($row['Name'] != "None" && $row['Name'] != "Home")
	{
		$query  = "SELECT Beer.Name, Beer.beer_id FROM Beer INNER JOIN BeerServings ON Beer.beer_id = BeerServings.beer_id WHERE BeerServings.Date NOT LIKE '0000-00-00' AND BeerServings.List='".$row['Name']."'";
		$result = mysql_query($query);
		$total = mysql_num_rows($result);
?>
<li><a href="getlist.php?list=<?php echo $row['Name']?>"><img src="images\<?php echo $row['Graphic'];?>"><h2>&nbsp;<?php echo $row['Name']; ?></h2><span class="ui-li-count"><?php echo $total; ?></span></a></li>
<?php
		mysql_free_result($result);

	}
}
mysql_free_result($list);

?>
</ul>
  <footer data-role="footer" data-position="fixed" data-id="myfooter">
     <nav data-role="navbar" data-iconpos="left">
        <ul>
           <li><a href="#Beers">All Beers</a></li>
           <li><a href="#Cellar">Cellar</a></li>
           <li><a href="#Deep">Deep Cellar</a></li>
           <li><a href="#Last100">Last100</a></li>
           <li><a href="lists.php" data-icon="bars" class="ui-btn-active ui-btn-persist">Lists</a></li>
       </lu></nav></footer>
</div>
<?php
include 'database/closedb.php';
?>