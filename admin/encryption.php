<?php

function pw_sql_encrypt($password){
    include_once 'encryption.php';
    $r = openssl_encrypt($password, 'aes-256-gcm', 'dxT&=_+jXA[q;~/*Uusb}52Y)&z\2YjTCTZ;6RB,', 0, '141214121412');
    $r = preg_replace('/[^A-Za-z0-9\-]/', 'a', $r); //this line possibly allows wrong PW's success, but also avoids a bug that prevents login at all
    return $r;
}

?>
