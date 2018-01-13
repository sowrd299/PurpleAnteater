<?php

/* This is a module containing all functions needed for 
    "question/suggestion box" functionality */

/* this creates a sumbission form
    prompt: the seed text
    action: the webpage to go to on sumbit; default same page
*/
function disp_qb_cp($con, $prompt="", $action = '?'){
    echo('<form method="post" action="'.$action.'">');
    echo('<textarea name="question">'.$prompt.'</textarea>');
    echo('<input type="submit" value="Submit">');
    echo('</form>');
}

/* this processes a newly submitted question
    table: the table in the DB to use
    timer: the time, in minutes that must pass between submissions
*/
function qb_set($table, $timer, $con){
    if(isset($_POST['question']) &&
            time() - $_SESSION['qb_timer'] > $timer * 60){
        $stmt = $con->con->prepare('INSERT INTO '.$table.' (question) VALUES (?);');
        $stmt->bind_param('s',$_POST['question']);
        $stmt->execute();
        $stmt->close();
    }
}

function disp_qb_contents($table, $con){
    
}

?>