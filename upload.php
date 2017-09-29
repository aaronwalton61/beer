<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Upload Photo and Assign to Beer in MySQL</title>
		<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/redmond/jquery-ui.css">	
        <link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
		<script type="text/javascript">
		$(function() {
		
			$('#abbrev').val("");
			
			$("#state").autocomplete({
				source: "beers.php",
				minLength: 2,
				select: function(event, ui) {
					$('#state_id').val(ui.item.id);
					$('#abbrev').val(ui.item.abbrev);
				}
			});
			
			$("#state_abbrev").autocomplete({
				source: "states_abbrev.php",
				minLength: 2
			});
		});
		
		</script>
	</head>
<body>

<div class="container">
<form action="<?php echo $PHP_SELF;?>"  method="post" enctype="multipart/form-data">
<fieldset>
<legend>Upload Beer photo and attach to Beer MySQL Record</legend>
<p>Start by typing the Name of a Beer</p>
<p class="ui-widget"><label for="state">Beer: </label>
	<input type="text" id="state"  name="state" /></p>
<p>	<input name="userfile" type="file" id="userfile"> </p>
<p><input type="submit" name="upload" value="Upload" /></p>
</fieldset>
</form>

<?php
if (isset($_POST['upload'])) {
echo "<p>";
	while (list($key,$value) = each($_POST)){
	echo "<strong>" . $key . "</strong> = ".$value."<br />";
	}
echo "</p>";
}

if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0)
{
$fileName = $_FILES['userfile']['name'];
$tmpName  = $_FILES['userfile']['tmp_name'];
$fileSize = $_FILES['userfile']['size'];
$fileType = $_FILES['userfile']['type'];
$beername = str_replace("'", "''", $_POST['state']);
$id = 1;

$fp      = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));
$content = addslashes($content);
fclose($fp);

if(!get_magic_quotes_gpc())
{
    $fileName = addslashes($fileName);
}

include 'database/config.php';
include 'database/opendb.php';

$query = "INSERT INTO `BeerImages` (id, Name, Beer, type, Size, Content ) VALUES ( '', '$fileName', '$beername', '$fileType', '$fileSize', '$content')";

$conn->query($query) or die('Error, query failed'); 
echo "<p>";
echo "<br>File $fileName uploaded<br>";

$query = "SELECT * FROM BeerImages WHERE Name='{$fileName}'";
$result = $conn->query($query) or die('Error, query failed getting photo_id'); 
$row = $result->fetch_assoc();
echo "<br>File id = ".$row['id']."<br>";
$result->free();
$query = "UPDATE Beer SET photo_id='{$row['id']}' WHERE Name = '{$beername}'";
echo $query."<br><br>";
$conn->query($query) or die('Error, query failed, UPDATE photo_id');

echo " Done!";
echo "</p>";
include 'database/closedb.php';
} 

?>
</div>
</body>
</html>