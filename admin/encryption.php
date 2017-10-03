<?php

function pw_sql_encrypt($password){
    include_once 'encryption.php';
    $r = openssl_encrypt($password, 'aes-256-gcm', 'dxT&=_+jXA[q;~/*Uusb}52Y)&z\2YjTCTZ;6RB,', 0, '141214121412');
    return $r;
}

?>
