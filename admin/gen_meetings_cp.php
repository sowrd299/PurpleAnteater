<?php

/* Displays a Control Panel to set up the general meetings for the quarter
 */

include_once '../res/lib.php';

function disp_gen_meetings_cp($count){
    /* count: number of weekly general meetings in the quarter
     */

    echo('<form method="post" action="/vgdc-uci/admin/home.php?p=gen_meetings_set">');
    echo('Date of First Meeting (yyyy-mm-dd): <input type="text" name="start_date"><br>');
    for( $i = 0; $i < $count; $i++ ){
        $value = 'General Meeting';
        switch($i){ //DEFAULT VALUES BY WEEK
                    //in the event that the default setup changes, this should be updated
            case 0:
                $value = 'Project Presentations*';
                break;
            case 1:
                $value = 'Team Assignments**';
                break;
            case 2:
                $value = 'In-Person Team Setup*';
                break;
            case 4:
                $value = 'Game Night';
                break;
            case 6:
                $value = 'Playtesting';
                break;
            case 8:
                $value = 'Playtesting';
                break;
            case 9:
                $value = 'Game Night';
                break;
        }
        echo('Week '.($i+1).' Topic: <input type="text" name="topic'.$i.'" value="'.$value.'"><br>');
    }
    echo('<input type="submit" name="Update" value="Apply">');
    echo('</form>');
}

if($_SESSION['loading']){ //this is prequires the user to go through secutiry measures, and prevents using the page directly
    disp_gen_meetings_cp(NUM_MEETINGS);
}

?>
