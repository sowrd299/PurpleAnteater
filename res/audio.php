<?php

/*
 * Presents the audio resources
 */

include_once 'lib.php';

function disp_audio($con)
{
	$stmt = $con->prepare("SELECT img, title, link, description FROM audio ORDER BY id ASC"); 
    $stmt->execute(); 

    $stmt->bind_result($img, $title, $link, $description);

    while($stmt->fetch())
	{
		echo('<div class="content-box">');
		echo(' <img class="audio-screenshot" src='.$img.'style="margin-right:3%" />');
		echo('<div class="content-box-text">');
		echo('<h1><a href='.$link.'>'.$title.'</a></h1>');
		echo($description);
		echo('</div></div>');
	}

	$stmt->close();
}

$con = sql_connect();
disp_audio($con);
$con->close();
	
?>