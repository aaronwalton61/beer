<?php

$return_arr = array();

include 'database/config.php';
include 'database/opendb.php';

/* If connection to database, run sql statement. */
{
	$fetch = $conn->query("SELECT * FROM Beer where Beer.photo_id = 1 AND Beer.Name like '%" . $_GET['term'] . "%' ORDER BY Name"); 

	/* Retrieve and store in array the results of the query.*/

	while ($row = $fetch->fetch_array(MYSQLI_ASSOC)) {
		$row_array['id'] = $row['id'];
		$row_array['value'] = $row['Name'];
		$row_array['abbrev'] = $row['abbrev'];

        array_push($return_arr,$row_array);
        $fetch->free();
    }

}

/* Free connection resources. */
include 'database/closedb.php';

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

?>