<?php
/* The code in this file is meant to mediate between Admin CP authenitcation
 * and PmWiki authentication.
 * This should be include in both PHP files (home.php and config.php respectively)
 * sense both need access to the passwords hard coded here.
 * This file sets up the passwords for PmWiki automatically when included
 * and logs the user in and out of PmWiki using those passwords from anywhere with the included functions.
 * Because of this system, the passwords themselves are for internal use only (why they are so uggly).
 */ 

//pw's should be stored in the DB by their name, not their value
$wiki_pws = ['admin' => '=5_+DVeY~\&+m%@D5dLk~@-=`D9]eQT"',
             'officer' => 'LcqX*pwaPu7j%8w<B#HMYf@)8n7zSG,'];

//bellow is for the wiki itself
//included here for convinience
if(defined('PmWiki')){
    $DefaultPasswords['admin'] = pmcrypt($wiki_pws['admin']);
    $DefaultPasswords['attr'] = '@lock'; //should prevent anyone not a Webmaster from playing with passwords
    $DefaultPasswords['edit'] = pmcrypt($wiki_pws['officer']); //only officers may edit the wiki
    $DefaultPasswords['upload'] = pmcrypt($wiki_pws['officer']); 
}

//login to the wiki with the password of the given name
function wiki_login($pw){
    global $wiki_pws;
    //echo('<!--attempting wiki login with '.substr($pw,0,2).'... -->'); //TESTING
    $wiki_pw = base64_encode($wiki_pws[$pw]);
    if($wiki_pw){
        //$_SESSION['authpw'] = $_SESSION['authpw'] + [base64_encode($wiki_pw) => 1];
        $_SESSION['authpw'] = array_merge(isset($_SESSION['authpw'])? $_SESSION['authpw'] : [],
                                          [$wiki_pw => 1]);
    }
}

//clear the cache of being logged into the wiki
function wiki_logout(){
    $_SESSION['authpw'] = array();
}