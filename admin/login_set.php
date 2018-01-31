<?php
if($_SESSION['loading'] && array_key_exists('user', $_POST)){
    include_once 'encryption.php';
    $con = sql_connect();
    $stmt = $con->prepare('SELECT username, level, wiki_password FROM admin_login WHERE username = ? and password = ?');
    echo('<!-- MySQL Login Fetch Error: '.$con->error.'-->');
    $pw = pw_sql_encrypt($_POST['password']);
    $stmt->bind_param('ss', $_POST['user'], $pw);
    $stmt->bind_param('ss', $_POST['user'], $_POST['password']); //comment this line in for direct PW use (no incryption)
    $stmt->execute();
    $stmt->bind_result($_SESSION['user'], $_SESSION['level'], $wikipw);
    if($stmt->fetch()){ //side effects of login success 
        include_once 'wiki_pws.php';
        wiki_login($wikipw);
    }else{ //handle login failure
        echo('<p style="color : #AA0000;">Login Failed</p>');
        unset($_SESSION['user']);
        unset($_SESSION['level']);
    } 
    $stmt->close();
    $con->close();
}
?>
