<?php

 /* contants and functions for use in the Play Test Repository
  */

include_once './res/lib.php';

//CONSTANTS

define('EDIT_WINDOW', '1 hour'); //window to edit after email sent set here
define('POST_WINDOW', '3 months'); //window durring which will be posted

//FUNCITONS

function ptr_can_edit($con, $id){
    /* Returns if the given ID is valid and can be edited.
     * ID must be in database, and must have Edit Until time in future.
     */
    $statement = $con->prepare('SELECT edit_until FROM pt_repo WHERE id = ?;');
    $statement->bind_param('i', $id);
    $statement->execute();
    $statement->bind_result($edit_until);
    if($statement->fetch()){
        if(time() < strtotime($edit_until)){
            return True;
        }
        echo('<!--Expired '.date('Y-m-d H:i:s', strtotime($edit_until)).', is '.date('Y-m-d H:i:s').'-->');
        return False;
    }
    throw new Exception('No entry has the ID '.$id);
}


function ptr_mail($email, $id){
    /* Sends an email to the user with the given ID,
     * with instructions and link to full form.
     * Assumes that they have been added to the database.
     * Returns the success of the operation.
     */

    echo('<!--MAIL OUTPUT:'); //coment out all debug echo'd by phpmailer
    $subject = 'VGDC Play Test Repo Submission';
    $msg_top = 'Hello!<br/><br/>Thank you for your interest in submitting to VGDC\'s Play Test Repository. Follow the bollow link to submit your game. Note that this link will expire in one hour.<br/><br/>'; //the message, before the link
    $msg_bottom = '<br/><br/>-The VGDC Team'; //the message, after the link
    $url_part = '108.88.231.121'; //TODO: MIGRATE THIS TO THE NEW SERVER

    $url_whole = 'http://'.$url_part.'/vgdc-uci/pt_repo.php?p=submit&id='.$id;

    $mail = smtp_connect(); 
    $mail->addAddress($email);
    $mail->Subject = $subject;
    $mail->Body = $msg_top.'<a href = "'.$url_whole.'">'.$url_whole.'</a>'.$msg_bottom;
    $mail->IsHTML(true);
    $success = $mail->send();
    if(!$success){
        echo('<!--MAIL ERROR: '.$mail->ErrorInfo.'-->');
    }
    echo('-->');
    return $success;
}

function ptr_init($con, $email){
    /* Sets up the given email to be edited.
     * Adds it if it does not exist.
     * Sets edit_until to EDIT_WINDOW.
     * Returns the new ID
     */
    $user = explode('@',$email);
    $id = ptr_create_rand_id($user[0]);
    //$email = $user[0].'@'.$user[1]; //unexplode
    $until = date('Y-m-d H:i:s ', strtotime('now + '.EDIT_WINDOW));

    //TODO: carry over previously submitted game data
    //TODO: rewrite using set

    //delete any previous entry from that user
    $del_statement = $con->prepare('DELETE FROM pt_repo WHERE email = ?');
    $del_statement->bind_param('s',$email);
    $del_statement->execute();
    $del_statement->close();

    //add the new entry
    $in_statement = $con->prepare('INSERT INTO pt_repo (id, edit_until, email) VALUES (?,?,?);');     
    $in_statement->bind_param('sss', $id, $until, $email);
    $in_statement->execute();
    $in_statement->close();

    return $id;
}

function ptr_legal_email($email){
    /* Returns true if the given email is a UCI email,
     * and should be allowed to use the playtest repo
     */
    $domain = explode('@',$email);
    return $domain[1] == 'uci.edu';
}

function ptr_create_rand_id($email){
    /*creates a random id for the given email and returns it
     */
    return $email.rand(0,2147483647);
}


function ptr_submit($con, $id, $post_until, $name, $download, $feedback, $about){
    /* Submits the given game to the database.
     * Assumes the hash id has been initialized.
     */

    $statement = $con->prepare('UPDATE pt_repo SET post_until = ?, name = ?, download = ?, feedback = ?, about = ? WHERE id = ?;');
    $statement->bind_param('ssssss', $post_until, $name, $download, $feedback, $about, $id);
    $statement->execute();
    $statement->close();
}

?>
