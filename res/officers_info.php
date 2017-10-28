<?php

/*
 * Presents the officers information
 */

include_once 'lib.php';

function disp_officers($con)
{
	/*
	$depart = [
			0 => 'Administration',
			1 => 'Outreach',
			2 => 'Webmaster',
			10 => 'Programming',
			11 => 'Design',
			12 => 'Art',
			13 => 'Production',
			14 => 'Writing',
			15 => 'Audio',
			20 => 'Lab Officer'];
	*/

	$stmt = $con->prepare("SELECT o.name, d.name, o.img, o.title FROM officers o, depts d WHERE o.department = d.dept_id ORDER BY o.department ASC"); 
    $stmt->execute(); 

	$stmt->bind_result($name, $department, $img, $title);
	$previous = -1;
	while($stmt->fetch())
	{
		if ($previous != $department)
			//echo('<p><div class="header-text"><strong>'.$depart[$department].'</strong></div></p>');
			echo('<p><div class="header-text"><strong>'.$department.'</strong></div></p>');

		echo('<div class="ocontent">');
        echo('<div class="content-box-portrait">');
        echo('<img class="size-medium wp-image-442695" src='.$img. 'alt='.$name. 'width="128" height="128" />');
        echo('</div>');
        echo('<font size="6"><b>' .$title. '</b><br/>'.$name.'</font>');
        echo('</div>');

        $previous = $department;
	}

	echo('</div>');

	$stmt->close();
}


$con = sql_connect();
disp_officers($con);
$con->close();
	
?>