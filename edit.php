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

$query = "SELECT * FROM `BeerServingTypes`";
$servingtype = $conn->query($query);

if ( $beerid != "" || $servingid != "" )
{
if ($beerid != "")
{
    //Query of Beer to Edit
    $query  = "SELECT * FROM Beer WHERE beer_id='{$beerid}'";
    $result = $conn->query($query);
    $count = $result->num_rows;

    $row = $result->fetch_assoc();
?>
<div data-role="dialog" id="edit" class="ui-body ui-body-a">
    <div data-role="header">
        <h1>Edit Beer</h1>
    </div>
    <div data-role="content">
    <form id="edit" title="Edit Beer" action="modify.php" method="POST">
        <button type="submit" data-theme="e">Modify</button>
        <input id="beerid" type=hidden name="beerid" value="<? echo $row['beer_id']; ?>" />
            <div data-role="fieldcontain">
                <label for="name">Beer:</label>
                <input id="name" type="text" name="name" value="<?php echo $row['Name']?>" data-clear-bin="true" />
            </div>
            <div data-role="fieldcontain">
              <label for="url">URL:</label>
              <input id="url" type="url" name="url" value="<?php echo $row['BeerAdvocate']; ?>" data-clear-bin="true" />
            </div>
            <div data-role="fieldcontain">
              <label for="character">Character:</label>
              <input id="character" type="text" name="character" value="<?php echo $row['Characteristics']; ?>" />
            </div>
            <div data-role="fieldcontain">
              <label for="cellar">Cellar:</label>
                <input id="cellar" type="number"  pattern="[0-9]*" name="cellar" value="<?php echo $row['cellared']; ?>" />
            </div>
            <div data-role="fieldcontain">
              <label for="cellardate">Date:</label>
                <input id="cellardate" type="date" name="cellardate" value="<?php echo $row['CellarDate']; ?>" />
            </div>
            <div data-role="fieldcontain">
              <label for="serving">Serving:</label>
	<select name="serving" id="serving" title="Serving Type" size="1" data-mini="true">
      <option value=''>None</option>
	<?php
	while($row1 = $servingtype->fetch_assoc())
	{ 
	   if  ($row['CellarServing'] == $row1['Name'])
	       $sel=" Selected";
	   else $sel="";
	   echo "<option value='".$row1['Name']."'".$sel.">".$row1['Name']."</option>";
	}
	?>
	</select></div>
            <div data-role="fieldcontain">
              <label for="photo">Photo:</label>
                <input id="photo" type="number" name="photo" value="<?php echo $row['photo_id']; ?>" />
            </div>
        <div data-role="fieldcontain">
            <label>Deep Cellar</label>
                 <select id="deep" name="deep" data-role="slider" data-mini="true">
                 <?php if ($row['ExtendedCellar'] == "0") $sel=" Selected"; else $sel=""; ?>
                    <option value="0" <?php echo $sel; ?> >No</option>
                 <?php if ($row['ExtendedCellar'] == "1") $sel=" Selected"; else $sel=""; ?>
                    <option value="1" <?php echo $sel; ?> >Yes</option>
                 </select>
        </div>
            <div data-role="fieldcontain">
            	<label for="notes">Notes:</label>
            	<textarea id="notes" name="notes"><?php echo $row['Notes']; ?></textarea>
            </div>
            <div data-role="fieldcontain">
                <a href="delete.php?beer=<?php echo $beerid;?>" data-role="button" data-icon="delete" data-inline="true" data-theme="e" data-mini="true">Delete Beer</a>
            </div>
    </form>
<?php
}
else
{
$query  = "SELECT * FROM BeerServings WHERE id='{$servingid}'";
$result = $conn->query($query);
$count = $result->num_rows;

$row = $result->fetch_assoc();

$query = "SELECT * FROM `BeerLocations`";
$location = $conn->query($query);

$query = "SELECT * FROM `BeerLists`";
$list = $conn->query($query);
?>
<div data-role="dialog" id="editserve" class="ui-body ui-body-a">
    <div data-role="header">
        <h1>Edit Serving</h1>
    </div>
    <div data-role="content">
    <form id="editserve" title="Edit Serving" action="modify.php" method="POST">
            <button type="submit" data-theme="b">Modify</button>
            <input id="serve" type=hidden name="serve" value="<? echo $row['id']; ?>" >
            <div data-role="fieldcontain">
                <label for="name">Name:</label>
    		<input id="name" type=text name="name" value="<? echo $row['Name2']; ?>" >
            </div>
            <div data-role="fieldcontain">
                <label for="date">Date:</label>
                <input id="date" type="date" name="date" value="<?php echo $row['Date']; ?>" >
            </div>
            <div data-role="fieldcontain">
            	<label for="thoughts">Notes:</label>
            	<textarea id="thoughts" name="thoughts"><?php echo $row['Review']; ?></textarea>
            </div>
            <div data-role="fieldcontain">
                <label for="name">Vintage:</label>
    		<input id="vintage" type=text name="vintage" value="<? echo $row['Vintage']; ?>" >
            </div>
      <fieldset data-role="controlgroup" data-type="horizontal">
          <legend>Beer Serving, List & Location:</legend>
              <label for="serving">Serving:</label>
	<select name="serving" id="serving" title="Serving Type" size="1" data-mini="true">
	<?php
	while($row1 = $servingtype->fetch_assoc())
	{ 
	   if  ($row['Serving'] == $row1['Name'])
	       $sel=" Selected";
	   else $sel="";
	   echo "<option value='".$row1['Name']."'".$sel.">".$row1['Name']."</option>";
	}
	?>
	</select>
              <label for="list">List:</label>
              <select name="list" id="list" title="Beer List" size="1" data-mini="true">
	      <?php
	      while($row1 = $list->fetch_assoc())
	         { 
	   if  ($row['List'] == $row1['Name'])
	       $sel=" Selected";
	   else $sel="";
	            echo "<option value='".$row1['Name']."'".$sel.">".$row1['Name']."</option>";
	         }
	      ?>
	      </select>
              <label for="location">Location:</label>
	      <select name="location" id="location" title="Location" size="1" data-mini="true">
	      <?php
	      while($row1 = $location->fetch_assoc())
                { 
	   if  ($row['Location'] == $row1['Name'])
	       $sel=" Selected";
	   else $sel="";
	           echo "<option value='".$row1['Name']."'".$sel.">".$row1['Name']."</option>";
	        }
              ?>
	      </select>
     </fieldset>
        <div data-role="fieldcontain">
            <div class="row">
                 <li><a href="delete.php?serving=<?php echo $servingid;?>" data-role="button" data-inline="true" data-icon="delete" data-theme="e" data-mini="true">Delete Serving</a></li>
               </ul>
            </div>
    </form>
<?php
    }
}
$servingtype->free();
$result->free();

include 'database/closedb.php';
?>
</div></div>