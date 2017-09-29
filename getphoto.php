<?php
if(isset($_GET['id'])) 
{
// if id is set then get the file with the id from database

include 'database/config.php';
include 'database/opendb.php'; 
$id    = $_GET['id'];
$query = "SELECT name, type, size, content " .
         "FROM `BeerImages` WHERE id = '$id'";

$result = $conn->query($query) or die('Error, query failed');
list($name, $type, $size, $content) =  $result->fetch_array();

header("Content-length: $size");
header("Content-type: $type");
header("Content-Disposition: attachment; filename=$name");
echo $content;
mysql_free_result($result);
include 'database/closedb.php'; 
exit;
}
?>