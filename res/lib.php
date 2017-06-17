<?php

/*
 * Contains various useful functions to be used throughout the websie.
 */

echo('<!--TEST: Lib Included -->');

//CONSTANTS

define('NUM_MEETINGS', 10); //the number of general meetings in the quarter

//FUNCTIONS

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

?>
