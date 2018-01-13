<?php

/*
 * Contains various useful functions to be used throughout the websie.
 */

echo('<!--TEST: Lib Included -->');

//CONSTANTS

define('NUM_MEETINGS', 10); //the number of general meetings in the quarter

//FUNCTIONS

function int_to_day($i){
    
    /* Returns the string representation of the day whose index is give
       Where 0 is Sunday, 1 is Monday...
     */

    return date('l',strtotime('Sunday + '.$i.' Days'));
}

function get_locations($con){
    
    /* Returns a list of:
        [ loc_id => location, ... ]
       for each location the club has at its disposal
    */

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

function sql_connect(){

    /* Returns a set-up connection to the SQL server
     */
      
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

function smtp_connect(){

    /* Returns a set-up SMTP (email) connection.
     */

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
    foreach(array('./','href="',"include '","include_once '") as $pattern){
        if(substr($path, -1) != '/') $path = $path.'/'; //add an extra slash when needed
        $text = str_replace($pattern, $pattern.$path, $text);
    }
    return $text;
}

?>
