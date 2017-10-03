<?php

//ends the sessions and wipes loging data
session_unset();
session_destroy();
echo('<p>You have logged out</p>');
/*
<h3>Logged Out</h3>
<a href="home.php">Back to Admin Control Pannel</a><br>
<a href="../home.ph">Back to main website</a><br>
*/

?>

