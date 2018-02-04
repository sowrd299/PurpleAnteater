<?php

/*
 * Contains various useful functions to be used throughout the websie.
 */

echo('<!--TEST: Lib Included -->');

//CONSTANTS

define('NUM_MEETINGS', 10); //the number of general meetings in the quarter
$GAMES_FOLDER = './uploads/games/';

//FUNCTIONS

/* Returns the string representation of the day whose index is give
 *  Where 0 is Sunday, 1 is Monday...
 */
function int_to_day($i){
    return date('l',strtotime('Sunday + '.$i.' Days'));
}

/* The inverse of int_to_day
 * NOTE: hasn't actually been tested
 */
function day_to_int($d){
    return date('w',strtotime($d));
}

/* Flip a 2D array diagnolly
 */
function array_transpose($array) {
    $r = array();
    foreach($array as $k => $v){
        foreach($v as $k1 => $v1){
            if(!isset($r[$k1])) $r[$k1] = array();
            $r[$k1][$k] = $v1;
        }
    }
    return $r;
}

/* A more aggressive tokenizer than explose
 * supports multiple delimeters, and removes whitespace around words
 */
function tokenize($str, $delims){
    foreach($delims as $delim){ //standardize all delimiters
        $str = str_replace($delim, $delims[0], $str);
    }
    $strs = explode($delims[0], $str); //break on delimiters
    return array_map('trim', $strs); //clean off whitespace
}

/* Returns a list of:
 *  [ loc_id => location, ... ]
 * for each location the club has at its disposal
 */
function get_locations($con){

    $loc_stmt = $con->prepare('SELECT l.loc_id, l.name FROM locations l WHERE 1');
    echo('<!--'.$con->error.'-->');
    $loc_stmt->bind_result($loc_id, $loc_name);
    $loc_stmt->execute();
    $locations = array();
    while($loc_stmt->fetch()){
        $locations[$loc_id] = $loc_name;
    }
    $loc_stmt->close();
    return $locations;

}

/* Returns a list of:
 *  [ dept_id => department, ... ]
 * for each department in the club
 */
function get_departments($con){

    $dept_stmt = $con->prepare('SELECT d.dept_id, d.name FROM depts d WHERE 1');
    echo('<!--'.$con->error.'-->');
    $dept_stmt->bind_result($dept_id, $dept_name);
    $dept_stmt->execute();
    $depts = array();
    while($dept_stmt->fetch()){
        $depts[$dept_id] = $dept_name;
    }
    $dept_stmt->close();
    return $depts;

}

/* Returns a set-up connection to the SQL server
 */
function sql_connect(){
      
    $server = "localhost"; //assumes webserver and sql share a db
    $user = "vgdc";
    $pw = "vgdcvgdc1234321";
    $db = "vgdc";

    $con = new mysqli($server, $user, $pw, $db);

    if (mysqli_connect_errno()) { //from http://php.net/manual/en/mysqli.prepare.php
        printf("Connect failed: %s\n", mysqli_connect_error());
        return(Null);
    }

    return($con);

}

/* Returns a set-up SMTP (email) connection.
 */
function smtp_connect(){

    date_default_timezone_set('Etc/UTC');

    require './PHPMailer-master/PHPMailerAutoload.php';

    $server = 'smtp.gmail.com';
    $port = 587; //465
    $secure = 'tsl'; //ssl 
    $debug = 2;
    $user = 'vgdc.uci@gmail.com';
    $name = 'Video Game Development Club at UCI';
    $pw ='videogames2015'; 

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->CharSet = 'UTF-8';

    $mail->Host = gethostbyname($server); 
    $mail->SMTPDebug = $debug;
    $mail->SMTPAuth = true;
    $mail->Port = $port;
    $mail->SMTPSecure = $secure;
    $mail->Username = $user;
    $mail->Password = $pw;

    $mail->setFrom($user,$name);
    $mail->addReplyTo($user,$name);

    return $mail;

}

/* Reformats all paths in a file to be relative to a new folder
 * $path takes the path from the current dir to the dir it was relative to
 * returns the new text
 */
function change_relative($file_path, $path){
    $file = fopen($file_path,'r') or "ERROR";
    if($file == "ERROR"){
        return ""; //fail quietly
    }
    $text = fread($file, filesize($file_path));
    if(substr($path, -1) != '/') $path = $path.'/'; //add an extra slash when needed
    foreach(array('./','href="',"include '","include_once '") as $pattern){ //uses these patterns to find paths. Super robust, I know
        $text = str_replace($pattern, $pattern.$path, $text);
    }
    $text = str_replace($path.'http', 'http', $text); //a super inefficent and ineffective way to unalter non-local paths
    return $text;
}

?>
