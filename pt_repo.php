<?php

/* a wrapper for Play Test Repository pages.
 * allows them to use the standarized root relative paths.
 */

?>

<!DOCTYPE HTML>

<html>

<head>
    <link rel="stylesheet" href="./css/main.css" type="text/css">
</head>

<body>
<?php

include './res/bar.php';

//load the correct page:
if(!isset($_GET['p']) || $_GET['p'] == 'about'){
    include './pt_repo/about.php';
}else{
    if($_GET['p'] == 'submit'){ //submit
        include './pt_repo/submit.php';
    }elseif($_GET['p'] == 'test'){
        include './pt_repo/test.php';
    }
}

include './res/foot.php';

?>

</body>

</html>

