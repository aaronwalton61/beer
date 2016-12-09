<?php 
// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: login.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
         "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<!-- <html manifest="manifest.php" xmlns="http://www.w3.org/1999/xhtml"> -->
<head>
  <meta charset="utf-8" />
  <title>My Beerlist</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
  <link rel="apple-touch-icon" href="apple-touch-icon.png"/>  <!-- Icon for apple shortcut -->
  <link href="http://beer.aaronwalton.org/apple-touch-icon.png" rel="icon" type="image/x-icon"/>
  <meta name="apple-touch-fullscreen" content="YES" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black" />

<!--  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
  <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
-->

<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
  
<!--
	<link rel="stylesheet" href="css/jquery.swipeButton.css" />
	<script src="js/jquery.swipeButton.js"></script>
-->

	<link rel="stylesheet" href="css/swipe.css" />
	<script src="js/swipe.js"></script>
  
  <script type="text/javascript" src="showhint.js"></script>

</head>

<body>

<?php 
include 'common.php';

// Load up the DB config and open it up.
//**************************************
include 'database/config.php';
include 'database/opendb.php';

// This makes a page for alphabetic index of beers
// Not used
function AlphaIndexedBeerPage()
{
    //echo "<ul id='Index' title='Beers Index'>";
    //echo "<li><a href='#0'>0</a></li>";
    //$index='A'; 
    //
    //do 
    //echo "<li><a href='#{$index}'>{$index}</a></li>";
    //}
    //while ($index++ < 'Z')
    //echo "</ul>";
}

static $servingtype = null;
static $location = null;
static $list = null;

static $cellar = null; // number of beers in cellar
static $deelcellar = null;  //number of beers in deep cellar
static $drank = null; //total number of different beers drank

// Get all the lists of items like serving types, Locations, and BeerLists
//************************************************************************
function GetLists()
{
    global $servingtype, $location, $list;

    $query = "SELECT * FROM `BeerServingTypes`";
    $servingtype = mysql_query($query);

    $query = "SELECT * FROM `BeerLocations`";
    $location = mysql_query($query);

    $query = "SELECT * FROM `BeerLists`";
    $list = mysql_query($query);
}

//---------***************----------**********
// Query of ALL beers in cellar to drink
//---------***************----------**********
function GetCellar()
{
    global $cellar;
    
    $query  = "SELECT * FROM Beer WHERE Beer.cellared > 0 AND Beer.ExtendedCellar < 1 ORDER BY Beer.CellarDate";
    $result = mysql_query($query);
    $cellar = mysql_num_rows($result);

    $last = ' ';

?>
<div data-role="page" id="Cellar" class="ui-body ui-body-a">
    <div data-role="header">
        <a href="#About" data-icon="info">About</a>
        <h1>Cellar - <?php echo $cellar; ?></h1>
        <a href="#addit" data-icon="plus">Add</a>
    </div>
<?php
     echo "<ul data-role='listview' data-filter='true' id='Cellar' title='Cellar - {$cellar}' class='panel'>";

    while($row = mysql_fetch_array($result, MYSQL_ASSOC))
    {
       $color = "Black";

    //   $last = grouprows( $row['Name'][0], $last );

       $icon = icons( $row['Characteristics']." ".$row['CellarServing'] );

       if ( $row['photo_id'] != "1" )
         $icon = $icon . "<img title='Photo' src='images/Photo.png'>";

       if ( $row['BeerAdvocate'] != "" && $row['BeerAdvocate'] != null )
         $icon = $icon . "<img title='BA' src='images/BeerAdvocate.gif'>";

       //  Line with Beer
       echo "<li><a href='view.php?beer=".htmlentities($row['beer_id'], ENT_QUOTES)."'><font color={$color}>{$row['Name']}</font><span class='ui-li-aside'>{$icon}</span><p> {$row['cellared']} {$row['CellarServing']} cellared on {$row['CellarDate']}</p></a></li>";
    }
    echo "</ul>";
?>
  <footer data-role="footer" data-position="fixed" data-id="myfooter">
     <nav data-role="navbar" data-iconpos="left">
        <ul>
           <li><a href="#Beers">All</a></li>
           <li><a href="#Cellar" class="ui-btn-active ui-btn-persist"><?php echo $cellar; ?></a></li>
           <li><a href="#Deep">Deep</a></li>
           <li><a href="#Last100">100</a></li>
           <li><a href="lists.php" data-icon="bars">Lists</a></li>
       </lu></nav></footer>
</div>
<?php
    mysql_free_result($result);
}

//---------***************----------**********
// Query of ALL beers in cellar to drink Deep Cellar
//---------***************----------**********
function GetDeepCellar()
{
    global $deepcellar;

    $query  = "SELECT * FROM Beer WHERE Beer.cellared > 0 AND Beer.ExtendedCellar > 0 ORDER BY Beer.CellarDate";
    $result = mysql_query($query);
    $deepcellar = mysql_num_rows($result);

    $last = ' ';

?>
<div data-role="page" id="Deep" class="ui-body ui-body-a">
    <div data-role="header">
        <a href="#About" data-icon="info" id="redButton" class="button">About</a>
        <h1>Deep Cellar - <?php echo $deepcellar; ?></h1>
        <a href="#addit" data-icon="plus" id="redButton" class="button">Add</a>
    </div>
    <div role="main" class="ui-content">
<?php
    echo "<ul data-role='listview' data-filter='true' id='DeepCellar' title='DeepCellar - {$deepcellar}' class='panel'>";

    while($row = mysql_fetch_array($result, MYSQL_ASSOC))
    {
       $color = "Black";

    //   $last = grouprows( $row['Name'][0], $last );

       $icon = icons( $row['Characteristics']." ".$row['CellarServing'] );

       if ( $row['photo_id'] != "1" )
         $icon = $icon . "<img title='Photo' src='images/Photo.png'>";

       if ( $row['BeerAdvocate'] != "" && $row['BeerAdvocate'] != null )
         $icon = $icon . "<img title='BA' src='images/BeerAdvocate.gif'>";

       //  Line with Beer
       echo "<li><a href='view.php?beer=".htmlentities($row['beer_id'], ENT_QUOTES)."'><font color={$color}>{$row['Name']}</font><span class='ui-li-aside'>{$icon}</span><p> {$row['cellared']} {$row['CellarServing']} cellared on {$row['CellarDate']}</p></a></li>";
    }
    echo "</ul></div>";
?>
  <footer data-role="footer" data-position="fixed" data-id="myfooter">
     <nav data-role="navbar" data-iconpos="left">
        <ul>
           <li><a href="#Beers">All</a></li>
           <li><a href="#Cellar">Cellar</a></li>
           <li><a href="#Deep" class="ui-btn-active ui-btn-persist"><?php echo $deepcellar; ?></a></li>
           <li><a href="#Last100">100</a></li>
           <li><a href="lists.php" data-icon="bars">Lists</a></li>
       </lu></nav></footer>
</div>
<?php
    mysql_free_result($result);
}

//---------***************----------**********
//Query of all Beers DRANK
//---------***************----------**********
function GetAllBeerDrank()
{
    global $drank;
    
/*    $query  = "SELECT DISTINCT Beer.Name, Beer.beer_id, Beer.photo_id, Beer.BeerAdvocate FROM Beer INNER JOIN BeerServings ON Beer.beer_id = BeerServings.beer_id WHERE BeerServings.Date NOT LIKE '0000-00-00' ORDER BY Beer.Name";*/
    $query  = "SELECT Beer.Name, Beer.beer_id, Beer.photo_id, Beer.BeerAdvocate FROM Beer";
    $result = mysql_query($query);
    $drank = mysql_num_rows($result);

    //
    // Begin of all Drank Beers list, should we only do this if need be? it is long.
    $last = ' ';

?>
<div data-role="page" id="Beers" class="ui-body ui-body-a">
    <div data-role="header">
        <a href="#About" data-icon="info">About</a>
        <h1>All Beers - <?php echo $drank; ?></h1>
        <a href="#addit" data-icon="plus">Add</a>
    </div>
    <div role="main" class="ui-content">
<?php
    echo "<ul data-role='listview' data-filter='true' data-filter-reveal='true' id='Beers' data-autodividers='false' data-inset='true'>";
    while($row = mysql_fetch_array($result, MYSQL_ASSOC))
    {
       $color = wherecolor($row['Date'], $row['Location']." ".$row['Serving']." ".$row['List']);

    //   $last = grouprows( $row['Name'][0], $last );

       $icon = icons( $row['Characteristics']." ".$row['Serving'] );

       if ( $row['photo_id'] != "1" )
         $icon = $icon . "<img title='Photo' src='images/Photo.png'>";

       if ( $row['BeerAdvocate'] != "" && $row['BeerAdvocate'] != null )
         $icon = $icon . "<img title='BA' src='images/BeerAdvocate.gif'>";

       // Each list item for all the beers
       echo "<li><a href='view.php?beer=".htmlentities($row['beer_id'], ENT_QUOTES)."'>{$row['Name']}<span class='ui-li-aside'>{$icon}</span></a></li>";
    } 
    echo "</ul></div>";
?>
  <footer data-role="footer" data-position="fixed" data-id="myfooter">
     <nav data-role="navbar" data-iconpos="left">
        <ul>
           <li><a href="#Beers" class="ui-btn-active ui-btn-persist">All Beers- <?php echo $drank; ?></a></li>
           <li><a href="#Cellar">Cellar</a></li>
           <li><a href="#Deep">Deep</a></li>
           <li><a href="#Last100">100</a></li>
           <li><a href="lists.php" data-icon="bars">Lists</a></li>
       </lu></nav></footer>
</div>
<?php
    mysql_free_result($result);
}

//---------***************----------**********
// Query of Last 100 beers Drank, update
//---------***************----------**********
function GetLast100()
{
    $query  = "SELECT * FROM Beer INNER JOIN BeerServings ON Beer.beer_id = BeerServings.beer_id ORDER BY BeerServings.Date Desc Limit 100";
    $result = mysql_query($query);

?>
<div data-role="page" id="Last100" class="">
    <div data-role="header">
        <a href="#About" data-icon="info">About</a>
        <h1>Last100</h1>
        <a href="#addit" data-icon="plus">Add</a>
    </div>
    <div role="main" class="ui-content">
<?php
    echo "<ul data-role='listview' id='swipelist' class='touch' data-icon='false' data-split-icon='delete'>";
    while($row = mysql_fetch_array($result, MYSQL_ASSOC))
    {
       $color = wherecolor($row['Date'], $row['Location']." ".$row['Serving']." ".$row['List']);

    //   $last = grouprows( $row['Name'][0], $last );

       $icon = icons( $row['Characteristics']." ".$row['Serving'] );

       if ( $row['photo_id'] != "1" )
         $icon = $icon . "<img title='No Photo' src='images/Photo.png'>";

       if ( $row['BeerAdvocate'] != "" && $row['BeerAdvocate'] != null )
         $icon = $icon . "<img title='BA' src='images/BeerAdvocate.gif'>";

       // Each list item for all the beers
       echo "<li serving='{$row['id']}'><a href='view.php?beer=".htmlentities($row['beer_id'], ENT_QUOTES)."'><font color={$color}>{$row['Name']}</font><span class='ui-li-aside'>{$icon}</span><p> {$row['Serving']} on {$row['Date']} at {$row['Location']} for {$row['List']}</p></a><a href='#' class='delete'>Delete</a></li>";
    } 
    echo "</ul></div>";
?>
  <footer data-role="footer" data-position="fixed" data-id="myfooter">
     <nav data-role="navbar" data-iconpos="left">
        <ul>
           <li><a href="#Beers">All</a></li>
           <li><a href="#Cellar">Cellar</a></li>
           <li><a href="#Deep">Deep</a></li>
           <li><a href="#Last100" class="ui-btn-active ui-btn-persist">100</a></li>
           <li><a href="lists.php" data-icon="bars">Lists</a></li>
       </lu></nav></footer>
       
    <div id="confirm" class="ui-content" data-role="popup" data-theme="a">
        <p id="question">Are you sure you want to delete:</p>
        <div class="ui-grid-a">
            <div class="ui-block-a">
                <a id="yes" class="ui-btn ui-corner-all ui-mini ui-btn-a" data-rel="back">Yes</a>
            </div>
            <div class="ui-block-b">
                <a id="cancel" class="ui-btn ui-corner-all ui-mini ui-btn-a" data-rel="back">Cancel</a>
            </div>
        </div>
    </div><!-- /popup -->

</div>
<?php
    mysql_free_result($result);
}

// Lets get all the "pages" read out of the database
GetLists();
GetCellar();
GetDeepCellar();
GetAllBeerDrank();
GetLast100();

?>

<!-- <div data-role="page" id="Main" class="">
    <div data-role="header">
        <a href="#About" data-icon="info">About</a>
        <h1>Beers</h1>
        <a href="#addit" data-icon="plus">Add</a>
    </div>
    
  <ul data-role="listview" id="home" data-filter="true" class="panel" title="Beers <?php echo $drank."-".$cellar."-".$deepcellar; ?>" selected="true">
      <li><img src="images\beerelements.png" align="left"><a href="#Cellar"><span>Beers</span><span class="ui-li-count"><?php echo $cellar; ?></span></a></li>
      <li><img src="images\beerelements.png" align="left"><a href="#DeepCellar"><span>Cellared Beers</span><span class="ui-li-count"><?php echo $deepcellar; ?></span></a></li>
      <li><img src="images\99 bottles.png" align="left"><a href="#Last100">Last 100</a></li>
      <li><img src="images\beerelements.png" align="left"><a href="#Beers"><span>All Beers</span><span class="ui-li-count"><?php echo $drank; ?></span></a></li>
  </ul>
  <footer data-role="footer" data-position="fixed">
     <nav data-role="navbar">
        <ul>
           <li><a href="#Beers">All Beers</a></li>
           <li><a href="#Cellar">Cellar</a></li>
           <li><a href="#Deep">Deep Cellar</a></li>
           <li><a href="#Last100">Last100</a></li>
           <li><a href="lists.php" data-icon="bars" data-iconpos="left">Lists</a></li>
       </lu></nav></footer>
</div>  -->

<!-- <div data-role="page" class="">
  <ul id="other" title="Other" class="panel">
      <li class=group>Other</li>
      <li><img src="images\beerelements.png" align="left"><a href="#update">Update</a></li>
      <li><a href="#select_theme">Theme switcher</a></li>
      <li><img src="images\beerelements.png" align="left"><a href="lists.php">Lists</a></li>
      <li><a href="http://beeradvocate.com/user/trade_list/ImusBeer/?show=G" target="_webapp"><img src="images\Ba.png" align="left">Beer Advocate Got List</a></li>
      <li><a href="#about"><img src="images\info.png" align="left" size="50%">About</a></li>
      <li><a href="logout.php"><img src="images\info.png" align="left" size="50%">Logout</a></li>
  </ul>  -->

<div data-role="page" id="About" class="">
    <div id="about" title="About" class="panel">
      <h1>About My Beers</h1>
    </div>
    <div data-role="content">
      <p><img src="http://aaronwalton.org/iui/iui/iui-logo-touch-icon.png"/>&nbsp;<img src="apple-touch-icon.png"/></p>
      <p>Sample Mobile Web App using the jQuery JavaScript Library</p>
      <table><tr><td>Color key:
	<br>&nbsp;&nbsp;<font color=green>Green</font> at Home
	<br>&nbsp;&nbsp;<font color=blue>Blue</font> at Mall
	<br>&nbsp;&nbsp;<font color=yellow>Yellow</font> at Suwanee
	<br>&nbsp;&nbsp;<font color=purple>Purple</font> at Duluth
	<br>&nbsp;&nbsp;<font color=orange>Orange</font> at Bev Super
	<br>&nbsp;&nbsp;<font color=red>Red</font> want it</td>
	<td><img src='images/bottle.png'> Bottle
	<br><img src='images/draught.gif'> Draft
	<br><img src='images/can.png'> Can
	<br><img src='images/cask.png'> Cask/Firkin
	<br><img src='images/tulip.gif'> High Gravity
	<br><img src='images/what.png'> None or ?
	</td></tr></table>
    </div>
</div>

<div data-role="dialog" id="addit">
    <div data-role="header">
        <h1>New Beer</h1>
    </div>
    <div data-role="content">
        <form id="addit" title="Add a Beer" class="dialog" action="addit.php" method="POST">
        <button type="submit">Add</button>
            <div data-role="fieldcontain">
            <label for="beer">Beer:</label>
            <input id="beer" type="text" name="beer" placeholder="Name of Beer" value="" data-mini="true" data-clear-bin="true" />
            </div>
            
            <div data-role="fieldcontain">
            <label for="link">Link:</label>
            <input id="link" type="url" name="link" placeholder="BeerAdvocate Link" value="" data-mini="true" data-clear-bin="true" />
            </div>
            
            <div data-role="fieldcontain">
            <label for="char">Character:</label>
            <input id="char" type="text" name="char" placeholder="Hop++ HighGrav Dark" value="" data-mini="true"/>
            </div>
            
            <div data-role="fieldcontain">
            <label for="thoughts">Notes:</label>
                <textarea id="thoughts" name="thoughts"><?php echo "A: \nS: \nT: \nM: \nD:";?></textarea>
            </div>
            
      <fieldset data-role="controlgroup" data-type="horizontal">
          <legend>Beer Serving, List & Location:</legend>
              <label for="serving">Serving:</label>
	      <select name="serving" id="serving" title="Serving Type" placeholder="Serving Type" data-mini="true">
              <?php
              while($row1 = mysql_fetch_array($servingtype, MYSQL_ASSOC))
	        { 
	           echo "<option value='".$row1['Name']."'>".$row1['Name']."</option>";
	        }
	      ?>
	      </select>
              <label for="list">List:</label>
              <select name="list" id="list" title="Beer List" data-mini="true">
	      <?php
	      while($row1 = mysql_fetch_array($list, MYSQL_ASSOC))
	         { 
	            echo "<option value='".$row1['Name']."'>".$row1['Name']."</option>";
	         }
	      ?>
	      </select>
              <label for="location">Location:</label>
	      <select name="location" id="location" title="Location" data-mini="true">
	      <?php
	      while($row1 = mysql_fetch_array($location, MYSQL_ASSOC))
                { 
	           echo "<option value='".$row1['Name']."'>".$row1['Name']."</option>";
	        }
              ?>
	      </select>
    </fieldset>

            <div data-role="fieldcontain">
            <label for="date">Date:</label> 
                <select id="date" name="date" size="1" value="0" data-mini="true">
                    <option value="0">None 0000-00-00</option>
                    <option value="1">Today - New</option>
                </select>
            </div>
            
            <div data-role="fieldcontain">
               <label for="cellar">Cellar:</label>
               <input id="cellar" type="number" name="cellar" placeholder="0" value="" data-mini="true" />
            </div>
            
            <div data-role="fieldcontain">
               <label>Deep Cellar:</label>
                 <select id="deep" name="deep" data-role="slider" data-mini="true">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                 </select>
            </div>
        </form>
    </div>
</div>

<?php
mysql_free_result($servingtype);
mysql_free_result($location);
mysql_free_result($list);
include 'database/closedb.php';
?>
 
<div data-role="dialog" id="update">
    <div data-role="header">
        <h1>Update</h1>
    </div>
    <div data-role="content">
    <form id="update" class="panel" title="Update">
        <ul id="update" title="Update">
            <li><a href="edititems.php?table=BeerLocations">Locations</a></li>
            <li><a href="edititems.php?table=BeerLists">Beer Lists</a></li>
            <li><a href="edititems.php?table=BeerServingTypes">Serving Types</a></li>
        </ul>
        <div class="spinner"></div>
    </form>
    </div>
</div>

</body>
</html> 