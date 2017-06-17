<?php

include_once '../res/lib.php';

function set_gen_meetings($con, $count){

    //clear old values
    $statement = $con->prepare('DELETE FROM gen_meetings;');
    $statement->execute();

    //initialize variables
    $week = 0;
    $topic = 'Place Holder Topic (from gen_meetings_set.php)';
    $date = strtotime($_POST['start_date']);

    //prepare the statement
    $statement = $con->prepare('INSERT INTO gen_meetings (week, topic, date) VALUES (?,?,?);');
    $statement->bind_param('iss', $week, $topic, $date);

    //add the rows
    for( $i = 0; $i < $count; $i++){
        $week = $i+1;
        $topic = $_POST['topic'.$i];
        $date = date('Y-m-d', strtotime($_POST['start_date'].' + '.$i.' weeks'));
        $statement->execute();
        echo('<!-- '.$week.' '.$topic.' '.$date.' -->');
    }

}

$con = sql_connect();
set_gen_meetings($con, NUM_MEETINGS);
$con->close();
echo('<p>Datebase Updated</p>');
include_once '../res/gen_meetings.php';

?>
