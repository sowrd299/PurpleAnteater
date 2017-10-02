<?php

//NOTE: this currently only works with admin/home.php; it will break outside of that context

include_once '../res/lib.php';

function change_password($con, $new_password, $user){
    $stmt = $con->prepare('UPDATE admin_login SET password = ? WHERE username = ?');
    $encoded_password = pw_sql_encrypt($new_password);
    $stmt->bind_param('ss', $encoded_password, $user);
    $stmt->execute();
}

if($_SESSION['loading']){
    $con = sql_connect();
    change_password($con, $_POST['new_password'], $_SESSION['user']);
    $con->close();
}

?>