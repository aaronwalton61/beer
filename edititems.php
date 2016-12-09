<?php
// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: login.php');
}

include 'database/config.php';
include 'database/opendb.php';

$table = $_GET['table'];
?>
<ul id="table" title="View Table">
<li class=group>Table <input type="text" id="beer" onkeyup="showHint(this.value)" /></li>
<?php

$query  = "SELECT * FROM {$table}";

$result = mysql_query($query);
$count = mysql_num_rows($result);

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
    echo "<li>".$row['Name']."</li>";
}


include 'database/closedb.php';
?>
</ul>
    <form id="addit" class="dialog" action="additem.php" method="POST" title="Add Item">
        <fieldset>
            <div class="row form">
            <label><?php echo $table ?>:</label>
            <input id="beer" type="text" name="beer" value=""/>
            </div>
         </fieldset>
            <a class="button" type="submit">Add</a>
            <div class="spinner"></div>
    </form>
