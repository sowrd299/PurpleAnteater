<?php

/*
 * Presents the lab hours info
 */

include_once 'lib.php';

/*
 * Gets the color code for the department
 */
function get_color($con, $dept_name)
{
    //consider moving to lib.php
	//Known error: cannot execute until close stmt in disp_lab
    $clr_stmt = $con->prepare("SELECT color FROM depts WHERE name = ?");
    //echo("<!-- MySQL Color Fetch Error: ".$con->error."-->");
    $clr_stmt->bind_param("s", $dept_name);
    $clr_stmt->bind_result($color);
    $clr_stmt->execute();
    $clr_stmt->fetch();
    echo('<!--'.$dept_name.' '.$color.'-->');
    return $color;
}

function disp_lab($con)
{
	$stmt = $con->prepare("SELECT Time, Monday, Tuesday, Wednesday, Thursday, Friday, id_number FROM lab_hours ORDER BY id_number ASC"); 
    $stmt->execute(); 

	$stmt->bind_result($time, $Monday, $Tuesday, $Wednesday, $Thursday, $Friday, $id);

	echo('<table>');

	echo('<tr><th>Time</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th></tr>');
    
    $schedule = [];
	while($stmt->fetch())
	{
        array_push($schedule, [ 'time' => $time,
                                'Mon' => $Monday,
                                'Tues' => $Tuesday,
                                'Weds' => $Wednesday,
                                'Thurs' => $Thursday,
                                'Fri' => $Friday] );
    }

    foreach( $schedule as $s)
	{
		echo('<tr>');
        echo('<td>'.$s['time'].'</td>');
        foreach( [$s['Mon'], $s['Tues'], $s['Weds'], $s['Thurs'], $s['Fri']] as $dept ){
            echo('<td style = "color : '.get_color($con, $dept).'">'.$dept.'</td>');
        }
		echo('</tr>');
	}
    echo('</table>');

}

$con = sql_connect();
disp_lab($con);
$con->close();
?>
