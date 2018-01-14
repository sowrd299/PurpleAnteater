<?php
if($_SESSION['loading'] && isset($_POST['name']) && isset($_POST['group'])){

    include_once 'wiki_pagemaker.php';

    //PmWiki will automatically make our page for us if we make a link/redirect to it
    $n = create_page_name($_POST['group'], $_POST['name']);
    header('Location: http://clubs.uci.edu/vgdc/wiki/pmwiki.php?n='.$n.'?action=edit');
    die();

}
?>