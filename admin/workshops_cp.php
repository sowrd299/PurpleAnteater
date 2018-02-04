<!--Test! Woskshop Control Panel Included!-->
<?php

/*
WORKSHOP FORMAT:
            [
             'title' =>,
             'day' =>, //string of int representation, e.g. '1'
             'from' =>,
             'to' =>,
             'happening' =>,
             'location' =>, //integer location id
             'hosts' => //list of host's officer id's
             'joints' => //list of other involved dept id's
            ]
*/
include_once '../res/lib.php';

function disp_workshop_form($name, $workshop, $locations, $hosts, $other_depts){
    /* Echos out a from stub for editing a single workshop.
    name is a code-only unique identifier for the workshop
    location is a list of all locations where the workshop may be held
    hosts is a list of officers who could host it
    other depts is a list of depts that coould also be involved
    */
    echo('
    <div class = "workshop"> 
        Title:<input name="'.$name.'_title" type="text" value="'.$workshop['title'].'" size="35"/><br>
        Day:<select name="'.$name.'_day">');
        for($i = 0; $i < 7; $i++){
            echo('<option value="'.$i.'" '.($i==$workshop['day']? 'selected' : '').'>'.int_to_day($i).'</div></option>');
        }
        echo('
        </select><br>
        <input name="'.$name.'_orig_from" type="hidden" value="'.$workshop['from'].'"/> <!--need this as part of SQL Index-->
        From:<input name="'.$name.'_from" type="text" value="'.$workshop['from'].'"/><br>
        To:<input name="'.$name.'_to" type="text" value="'.$workshop['to'].'"/><br>
        Location:<select name="'.$name.'_location">');
        foreach($locations as $id => $location){
            echo('<option value="'.$id.'" '.($id==$workshop['location']? 'selected' : '').'>'.$location.'</option>');
        }
        echo('
        </select><br>
        Happening:<select name="'.$name.'_happening">');
        $options = [ '0' => 'Not This Week (save it though)',
                     '1' => 'Yup',
                     'delete' => 'Nope! Delete it!'];
        foreach($options as $v => $t){
            echo('<option value="'.$v.'" '.($v==$workshop['happening']? 'selected' : '').'>'.$t.'</option>');
        }
        echo('
        </select>
    </div>
    ');
}

function disp_workshops_cp($dept_id, $con){
    //setup
    $locations = get_locations($con); //this has to come first to avoid concurancy in the db connections
    $hosts = //TODO
    $other_depts = //TODO
    $name = 0;
    $stmt = $con->prepare('SELECT w.name, w.start_time, w.end_time, w.weekday, w.location , w.happeningThisWeek FROM workshops w WHERE w.department = ?');
    $stmt->bind_param('i', $dept_id);
    $stmt->execute();
    $stmt->bind_result($title, $from, $to, $day, $location, $happening);
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
            'happening' => $happening,
            'location' => $location,
            'hosts' => [], 
            'joints' => [],
            ];
        echo('<br>');
        disp_workshop_form($name, $ws, $locations, $hosts, $other_depts);
        $name++;
    }
    //print a form for a new workshop
    disp_workshop_form($name, ['title' => 'New Workshop',
                               'from' => '13:00:00',
                               'to' => '14:00:00',
                               'day' => '1',
                               'happening' => 'delete',
                               'location' => 0,
                               'hosts' => [],
                               'joints' => []], $locations);
    //cleanup
    echo('<input name="count" type="hidden" value="'.($name+1).'"/>');
    echo('<br><input type="submit" value="Submit"/>');
    echo('</form>');
    $stmt->close();
}

//main
if($_SESSION['loading']){
    $con = sql_connect();
    //dept select
    //TODO: make this section a reusable, freestanding file
    $depts = get_departments($con);
    echo('
    <form method="get" action="?">
    <input type="hidden" name="p" value="workshops_cp">
    <select name="dept">
    ');
    foreach($depts as $dept_id => $dept_name){
        echo('<option value="'.$dept_id.'"'.($dept_id == $_GET['dept']? 'selected' : '').'>'.$dept_name.'</option>');
    }
    echo('
    <input type="submit" value="Go"/>
    </form>
    ');
    //the control panel itself
    if(isset($_GET['dept'])){
        echo('
        <p style="color : #AA0000">Times must be in 24 hour time, and include seconds!
        (because SQL is picky and writing parsers is hard.)
        </p>
        ');
        disp_workshops_cp($_GET['dept'], $con);
    }
}
/**/
?>