<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <title>VGDC Website Admin</title>

</head>

<body>

<h1>VGDC Website Admin Control Panel</h1>

<?php

include_once '../res/lib.php';
session_start();

//the security level tied to all admin functions
//ALL NEW ADMIN PAGES MUST BE ADDED HERE
//TODO: make this more secure
$protection_levels = [ 'gen_meetings_cp' => 9, 
                       'gen_meetings_set' => 9,
                       'change_password' => 7,
                       'change_password_set' => 7,
                       'game_uploads_cp' => 4,
                       'game_uploads_set' => 4,
                       'workshops_cp' => 3,
                       'workshops_set' => 3,
                       'wiki_newpage_cp' => 1,
                       'wiki_newpage_set' => 1,
                       'log_out' => 0 ];

$_SESSION['loading'] = True; //allow pages to function
                             //all admnin must check that this flag is high before doing anthing, as a security measure

//log-in processing
include 'login_set.php';

//load exact page
if(array_key_exists('user', $_SESSION)){

    echo('<h3>using page as '.$_SESSION['user'].'</h3>');

    if(array_key_exists('p', $_GET)){
        echo('<!--page "'.$_GET['p'].'" load started-->');
        include $_GET['p'].'.php';
        echo('<!--page load successful-->');
    }


}else{
    //if not logged in, load login page
    include 'login.php';

}

//list available pages
echo('<div class="admin_funcs">');
echo("<br><br><h3>Other Functions (be advised that not all bellow links do interesting things)</h3>");
if(array_key_exists('level', $_SESSION)){ //if you are loged in, list the pages you may use
    foreach($protection_levels as $page => $level) {
        if($level <= $_SESSION['level'] && substr($page, -4) != '_set'){ //ignore pages above security level and set pages
            $title = ucwords(str_replace('_', ' ', str_replace('_cp', '', $page))); //clean up the page names for pleb non-webofficers
            echo('<br><a href="?p='.$page.'">'.$title.'</a>');
        }
    }
}
//always list the mainpage and the officer wiki
echo('<br><a href="../home.php">Main Page</a>');
echo('<br><a href="../wiki/pmwiki.php?n=Officers.Officers">Officer Wiki</a>');
echo('</div>');

$_SESSION['loading'] = False; //prevent pages from loading out of sequence

?>

</body>

</html>
