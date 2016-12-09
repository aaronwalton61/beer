<?php
$id    = $_GET['id'];

if(isset($_GET['id'])) 
{
?>
	<div id="photo" title="Photo" data-role="page">
		<img src="getphoto.php?id=<?php print $id; ?>" width=320 />
	</div>
<?
}
?>