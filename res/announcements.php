<?php

/*
 * Presents the general announcements
 */

include_once 'lib.php';

function disp_announcement($con)
{
	$stmt = $con->prepare('SELECT message, date FROM announcements ORDER BY date ASC'); 
    $stmt->execute(); 


	$stmt->bind_result($message, $date);

	while($stmt->fetch())
	{
		echo('<p><strong>'.$date.'</strong></p>');
		echo('<p>'.$message.'</p>');
	}

	$stmt->close();
}

$con = sql_connect();
disp_announcement($con);
$con->close();
	
?>