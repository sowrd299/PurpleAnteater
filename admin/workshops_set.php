<?php

include_once '../res/lib.php';

if($_SESSION['loading']){ //Only run the code if being called by admin/home
    //TODO: this, but without deleting everything
    //NOTE: Current build does not update; simply deletes and re-adds.
    //      Interface supports true updating.
    //stetup
    $con = sql_connect();

    //clean away old workshops
    $del_stmt = $con->prepare('DELETE FROM workshops WHERE department = ?');
    $del_stmt->bind_param('i', $_POST['dept']);
    $del_stmt->execute();
    $del_stmt->close();

    //add back current workshops
    //set up statement
    $stmt = $con->prepare('INSERT INTO workshops (name, department, start_time, end_time, weekday, location, happeningThisWeek)
                           VALUES (?,?,?,?,?,?,?);');
    $stmt->bind_param('sissiii', $title, $_POST['dept'], $start, $end, $day, $loc, $happening);

    //run the insertions
    for($i = 0; $i < $_POST['count']; $i++){
        if( $_POST[$i.'_happening'] != 'delete' ){ //do no insert workshops marked to delete
            //fill out the variables
            //TODO: make this less... repetative
            $title = $_POST[$i.'_title'];
            $start = $_POST[$i.'_from'];
            $end = $_POST[$i.'_to'];
            $day = $_POST[$i.'_day'];
            $loc = $_POST[$i.'_location']; //TESTING!
            $happening = $_POST[$i.'_happening'];
            //Execute!
            $stmt->execute();
        } 
    }

    //clean up
    $stmt->close();
    $con->close();

    //print the webpage
    echo('<span>Updated, workshops are now:</span><br>');
    include '../res/workshops.php';
}

?>