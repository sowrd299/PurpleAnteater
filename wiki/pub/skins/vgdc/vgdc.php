<?php
//INCLUDES BAR, EDITING ALL PATHS TO BE RELATIVE TO NEW LOCATION
include '../res/lib.php';
$text = change_relative('../res/bar.php','../');
eval('?>'.$text);
?>