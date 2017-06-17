<h1 style="margin: 10%; align: center; width: 100%; color: #ffffff">Play Test Repository Submission</h1>

<div class="wrapper">
<div class="content">
<?php //MAIN CODE

include_once './res/lib.php';
include_once './pt_repo/res/lib.php';

$con = sql_connect();
        
if(isset($_GET['id'])){
    // 3) full submission form
    try{
        if(ptr_can_edit($con, $_GET['id'])){ 
            //not expired
            echo('<p>Warning: Submitting this form will overwrite any previous submissions.</p>');
            include './pt_repo/res/submit_form.php';
        }else{
            //request has expired
            echo('<p>Your submission request has expired.</p>');
            echo('<a href="./pt_repo.php?p=submit">Click  here to request again.</a>');
        }
    }catch(Exception $e){
        echo('<!--SQL ERROR: '.$e->getMessage().'-->');
        echo('<p>There has been an error retrieving data.</p>');
    }
}elseif(isset($_POST['email'])){
    // 2) send email
    $id = ptr_init($con, $_POST['email']);
    if(ptr_mail($_POST['email'],$id)){
        echo('<p>We have emailed you further instructions.</p>');
    }else{
        echo('<p>There was an error with our system. We will fix it as soon as possible.</p>');
    }
}elseif(isset($_POST['name'])){
    // 4) process complete
    ptr_submit($con, $_POST['id'], $_POST['post_until'], $_POST['name'], $_POST['download'], $_POST['feedback'], $_POST['about']);
    echo('<p>Thank you. Your submission has been recorded.</p>');
}else{
    // 1) get email address
    echo('<p>Please provide your UCI email address to verify that you are a student. We will email you further submission instructions.</p>');
    echo('<p>Warning: this action will overwrite any previous submissions you have made to the Play Test Repository.</p>'); //TODO: remove this warning when it isn't needed any more
    include './pt_repo/res/email_form.php';
}

$con->close();
    
?>
</div>
</div>
