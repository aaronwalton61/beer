<?php

$return_arr = array();

include 'database/config.php';
include 'database/opendb.php';
//$dbhost = 'aaronwalton.org';
//$dbuser = 'YOUR_USERNAME';
//$dbpass = 'YOUR_PASSWORD';
//$dbname = 'YOUR_DATABASE_NAME';

//$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
//mysql_select_db($dbname);

/* If connection to database, run sql statement. */
//if ($conn)
{
	$fetch = mysql_query("SELECT * FROM Beer where Beer.photo_id = 1 AND Beer.Name like '%" . $_GET['term'] . "%' ORDER BY Name"); 

	/* Retrieve and store in array the results of the query.*/

	while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
		$row_array['id'] = $row['id'];
		$row_array['value'] = $row['Name'];
		$row_array['abbrev'] = $row['abbrev'];

        array_push($return_arr,$row_array);
        mysql_free_result($fetch);
    }

}

/* Free connection resources. */
include 'database/closedb.php';
//mysql_close($conn);

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

?>