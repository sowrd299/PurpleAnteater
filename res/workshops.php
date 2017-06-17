<?php

/*
 * Presents the week's workshops
 */

echo('<!--TEST: Start 3-->');

include_once 'lib.php';

function disp_workshops($con){

    echo('<!--TEST: Start 4-->');

    //TODO: insert error handling

    //set up the prepared statement
    $stmt = $con->prepare("SELECT w.name, d.name, w.start_time, w.end_time, w.weekday FROM workshops w, depts d WHERE w.department = d.dept_id ORDER BY weekday ASC"); 
    $stmt->execute(); 

    //init vars

    echo('<!--TEST: Stament prepared (workshops).-->'); // <testing/>
    $today = date('w');

    //print the meetings
	echo('<div>');

    $stmt->bind_result($name, $department, $start_time, $end_time, $weekday);
    $first = True; 

    while($stmt->fetch()){
        echo('<!--TEST: Today:'.$today.' Workshop:'.date('w', strtotime('Sunday + '.$weekday.' Days')).'/'.$weekday.'-->');
		echo('<div style="');
        if($first){
            $first = False;
        }else{
            echo('border-top: 2px solid #000000;');
        }
        if( date('w', strtotime('Sunday + '.$weekday.' Days')) == $today ){
            //today's workshops
            echo('font-weight: bold;');
        }
        //future meetings recieve not special formatting
		echo('"><span>'.$department.': '.$name.'</span></br>');
        echo('<span>'.date('l',strtotime('Sunday + '.$weekday.' Days')).' from '.date('g:i',strtotime($start_time)).' to '.date('g:i',strtotime($end_time)));
        echo('</span></div>');
	}
	echo('</div>');

    //cleanup
    $stmt->close();
}

$con = sql_connect();
disp_workshops($con);
$con->close();
	
?>


