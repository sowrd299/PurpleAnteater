<?php

/*
 * Presents the week's workshops
 */

//echo('<!--TEST: Start 3-->');

include_once 'lib.php';
include_once 'google_sheets_lib.php';

$first = true; //tracks the first workshop displayed on each page; will be reset to high at the start of each list
$today = date('w'); //stash today's date so we don't need to keep recalculating it

/* Displays a single workshop
 */
function disp_workshop($weekday, $departments, $name, $start_time, $end_time, $location, $officers){
    global $first, $today;
    echo('<div style="');
    if($first){
        $first = false;
    }else{
        echo('border-top: 2px solid #000000;');
    }
    if( date('w', strtotime('Sunday + '.$weekday.' Days')) == $today ){
        //today's workshops
        echo('font-weight: bold;');
    }
    //past and future workshops recieve no special formatting
    echo('"><span>'.implode(', ', $departments).': '.$name.'</span></br>');
    echo('<span>'.date('l',strtotime('Sunday + '.$weekday.' Days')).' from '.date('g:i',strtotime($start_time)).' to '.date('g:i',strtotime($end_time)));
    echo(' in '.$location);
    echo('</span>');
    if(len())
    echo('</div>');
}

/* Displays all workshops in a database
 * takes a connection with that database
 */
function disp_sql_workshops($con){
    //TODO: insert error handling
    //set up the prepared statement
    $stmt = $con->prepare("SELECT w.name, d.name, w.start_time, w.end_time, w.weekday, l.name
                           FROM workshops w, depts d, locations l
                           WHERE w.department = d.dept_id and w.location = l.loc_id and w.happeningThisWeek = 1
                           ORDER BY d.name, w.weekday, w.start_time ASC"); 
    $stmt->execute(); 
    $stmt->bind_result($name, $department, $start_time, $end_time, $weekday, $location);
    //print the workshops
    while($stmt->fetch()){
        disp_workshop($weekday, $department, $name, $start_time, $end_time, $location);
    }
    //cleanup
    $stmt->close();
}

/* Display all workshops in an array
 */
function disp_array_workshops($array){
    foreach($array as $row){
        if(array_reduce($row, function($b,$v){ return $b || $v === null; })) continue;
        //NAMES OF COLLUMS IMPLEMENTED HERE
        disp_workshop($row['day'],
                      $row['department'],
                      $row['workshop name'],
                      $row['start time'],
                      $row['end time'],
                      $row['location'], 
                      []); //standin for officer until I write code that can handle the missing case
    }
}

/* To be called before a list of workshops
 */
function begin_workshops(){
    global $first;
    $first = true;
	echo('<div>'); 
}

/* To be called after a list of workshops
 */
function end_workshops(){
    global $first;
    if($first){
        echo("<p><i>There are currently no workshops scheduled for this week.</i></p>");
    }
	echo('</div>');
}

//get the workshops from google sheets
$workshops = csv_to_array($WORKSHOPS_CSV_URL, ',', ['day' => false, 'department' => true, 'officer' => true]);
echo('<!--');
echo(json_encode($workshops)); //TESTING
echo('-->');
//display the workshops
begin_workshops();
disp_array_workshops($workshops);
end_workshops();
	
?>


