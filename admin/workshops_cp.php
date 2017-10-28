<!--Test! Woskshop Control Panel Included!-->
<?php

/*
WORKSHOP FORMAT:
             'title' =>,
             'day' =>, //string of int representation, e.g. '1'
             'from' =>,
             'to' =>,
             'happening' => ]
*/
include_once '../res/lib.php';

function disp_workshop_form($name, $workshop){
    echo('
    <div class = "workshop">
        Title:<input name="'.$name.'_title" type="text" value="'.$workshop['title'].'"/><br>
        Day:<select name="'.$name.'_day">');
        for($i = 0; $i < 7; $i++){
            echo('<option value="'.$i.'" '.($i==$workshop['day']? 'selected' : '').'>'.int_to_day($i).'</div></option>');
        }
        echo('
        </select><br>
        <input name="'.$name.'_orig_from" type="hidden" value="'.$workshop['from'].'"/>
        From:<input name="'.$name.'_from" type="text" value="'.$workshop['from'].'"/><br>
        To:<input name="'.$name.'_to" type="text" value="'.$workshop['to'].'"/><br>
        Happening:<select name="'.$name.'_happening">');
        $options = [ '0' => 'Not This Week',
                     '1' => 'Yup',
                     'delete' => 'Nope! Delete it!'];
        foreach($options as $v => $t){
            echo('<option value="'.$v.'" '.($i==$workshop['happening']? 'selected' : '').'>'.$t.'</option>');
        }
        echo('
        </select>
    </div>
    ');
}

function disp_workshops_cp($dept_id, $con){
    //setup
    $name = 0;
    $stmt = $con->prepare('SELECT w.title, w.start_time, w.end_time, w.weekday, w.happeningThisWeek FROM workshops WHERE w.department = ?');
    $stmt->bind_param('i', $dept_id);
    $stmt->execute();
    $stmt->bing_result($title, $from, $to, $day, $happening);
    //set up the form
    echo('
    <form method="post" action="?p=workshops_set">
    <input name="dept" type="hidden" value="'.$dept_id.'"/>
    ');
    //print a form to edit each workshop
    while($stmt->fetch()){
        $ws = [
            'title' => $title,
            'from' => $from,
            'to' => $to,
            'day' => $day,
            'happening' => $happening
            ];
        disp_workshop_form($name, $ws);
        $name++;
    }
    //print a form for a new workshop
    disp_workshop_form($name, ['title' => 'New Workshop',
                               'from' => '13:00',
                               'to' => '14:00',
                               'day' => '1',
                               'happening' => 'delete']);
    //cleanup
    echo('<input type="submit" value="Submit"/>');
    echo('</form>');
    $stmt->close();
}

//main
if($_SESSION['loading']){
    $con = sql_connect();
    //dept select
    //TODO: make this section a reusable, freestanding file
    $stmt = $con->prepare('SELECT d.dept_id, d.name FROM depts');
    $stmt->bind_result($dept_id, $dept_name);
    $stmt->execute();
    echo('
    <form method="get" action="?p=workshops_cp">
    <select name="dept">
    ');
    while($stmt->fetch()){
        echo('<option value="'.$dept_id.'" >'.$dept_name.'</option>');
    }
    echo('
    <input type="submit" value="Go"/>
    </form>
    ');
    $stmt->close();
    //the control panel itself
    if(isset($_GET['dept'])){
        disp_workshops_cp($_GET['dept'], $con);
    }
}
/**/
?>