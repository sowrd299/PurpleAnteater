<!DOCTYPE html>
<html>
<head>

    <title>VGDC Website Admin</title>
    <style>
        body{
            background-color : #000000;
            color : #ffffff;
        }
    </style>

</head>

<body>

<h1>VGDC Website Admin Control Panel</h1>

<?php

include_once '../res/lib.php';
session_start();

//the security level tied to all admin functions
//TODO: make this more secure
$protection_levels = [ 'gen_meetings_cp' => 9, 
                       'gen_meetings_set' => 9,
                       'change_password' => 7,
                       'change_password_set' => 7,
                       'log_out' => 0 ];

$_SESSION['loading'] = True; //allow pages to function
                             //allow admnin must check that this flag is high before doing anthing, as a security measure

//log-in processing
if(array_key_exists('user', $_POST)){
    include_once 'encryption.php';
    $con = sql_connect();
    $stmt = $con->prepare('SELECT username, level FROM admin_login WHERE username = ? and password = ?');
    echo("<!-- MySQL Login Fetch Error: ".$con->error."-->");
    $stmt->bind_param('ss', $_POST['user'], pw_sql_encrypt($_POST['password']));
    $stmt->execute();
    $stmt->bind_result($_SESSION['user'], $_SESSION['level']);
    if(!$stmt->fetch()){
        echo('<p style="color : #AA0000;">Login Failed</p>');
        unset($_SESSION['user']);
        unset($_SESSION['level']);
    }
    $stmt->close();
}

//load exact page
if(array_key_exists('user', $_SESSION)){

    echo('<h3>using page as '.$_SESSION['user'].'</h3>');

    if(array_key_exists('p', $_GET)){
        include $_GET['p'].'.php';
    }

}else{
    //if not logged in, load login page
    include 'login.php';

}

//list available pages
echo("<br><br><h3>Other Functions (be advised that not all bellow links do interesting things)</h3>");
if(array_key_exists('level', $_SESSION)){ //if you are loged in, list the pages you may use
    foreach($protection_levels as $page => $level) {
        if($level <= $_SESSION['level']){
            echo('<br><a href="?p='.$page.'">'.$page.'</a>');
        }
    }
}
echo('<br><a href="../home.php">Main Page</a>');

$_SESSION['loading'] = False; //prevent pages from loading out of sequence

?>

</body>

</html>