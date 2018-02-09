<?php

//VARIOUS UPLOAD-RELATED ERROR MESSAGES ARE IMPLEMENTED THROUGHOUT THIS FILE

include_once '../res/lib.php'; //get $GAMES_FOLDER

/* Records that a game was uploaded and to what folder in the database
 * automatically generates an ID, and assumes the 
 * returns the ID
 */
function record_game_upload($con, $title, $folder, $about){
    //do some cleaning
    //Only YOU can prevent Cross Site Scripting
    //(p.s., if you are working on the site, and you don't know what that is, you probably should look it up)
    $title = filter_var ( $title, FILTER_SANITIZE_STRING);
    $about = filter_var ( $about, FILTER_SANITIZE_STRING);

    //setup the sql statement
    $stmt = $con->prepare('INSERT INTO game_uploads (id, title, folder, date, about) VALUES (?, ?, ?, CURDATE(), ?)');
    $stmt->bind_param('ssss', $id, $title, $folder, $about);

    //clean the ID down to something syntatical exceptable
    $id = substr(preg_replace("/[^A-Za-z0-9]/", '', $title),0,64); //get the ID, as the first 64 aphanumeric chars
                                                                   //(its needs to be alphanumeric and len <= 64, and human readable is a plus)
    
    //wrap-up and clean-up
    $stmt->execute();
    $stmt->close();

    return $id;
}


/* Uploads a game file. Takes the title of the game, and its about page.
 * and if it is okay to replace previous uploads with that name
 * returns the ID
 */
function save_game($con, $title, $game, $about, $path, $replace_ok = false){

    $extension = strtolower(pathinfo($game['name'],PATHINFO_EXTENSION));

    //check file size, so we don't get bombed.... as easily
    if($game['size'] > 50000000){
        echo('<p>The game is too large. Please contact the Webmaster.</p>');
        return;
    }

    //check valid upload
    if($extension != 'zip'){
        echo('<p>Game must be zipped to preserve file structure. Please zip it and try again.</p>');
        return;
    }

    $zip = new ZipArchive;
    if($zip->open($game['tmp_name'])){

        //gets the name of the root folder from the begining of the path to the first item in the zip
        $folder = strstr($zip->getNameIndex(0),'/',true); 

        echo('<!--Found game folder: '.$folder.'-->');
        $full_path = $path.'/'.$folder; //the path to the game folder after it is extracted

        //verify some facts about the file structure, to make sure it is actually a game
        //TODO: verify a more grueling list of facts
        if($zip->locateName($folder.'/index.html') === false){
            echo('<p>This does not appear to be a WebGL game, or it is zipped impropperly. Please compile for WebGL.</p>');
            echo('<p>Also note that the entire game should be within one folder with the zip.</p>');
            return;
        }

        //handle a folder name colision
        /* NOTE: this doesn't work yet
        $subfolder = ''; //a suphix to distinguish the file
        for($i = 0; file_exists($full_path); $i++){
            $subfolder = $i; //try increasing number appended to the folder until we have a unique one
        }
        $folder = $subfolder.$folder
        */

        //extract and save the game
        if($zip->extractTo($path)){ //preform the extraction
            echo('<p>'.$title.' has been uploaded.</p>');
            return record_game_upload($con, $title, $folder, $about); //record it in the database
        }
        $zip->close();
    }

    echo('<p>There was an error saving the file</p>');
}

/* Alters the title into a standardized and computer-friendly format
 * Puts into all capatalized words, no spaces or other space-delimiting characters
 * ALSO SUPER DUPER 100% TOTALLY DEPRICATED!!!!!!!!!!
 */
function format_game_title($title){
    return str_replace(' ','',ucwords(str_replace('_',' ',str_replace('-',' ',$title))));
}

//the main body
if($_SESSION['loading']){
    //get some stuff (from lib) ready to go
    $con = sql_connect();
    $path = '../'.$GAMES_FOLDER; //use ../ to escape /admin/
    //go actually do the things
    if($id = save_game($con, $_POST['title'], $_FILES['gameFile'],
            $_POST['about'], $path, isset($_POST['replace']))){ //'replace' is set iff the box was checked
        echo('<a href="../games?game='.$id.'>Check out your game here!</a>');
    }else{
        include 'game_uploads_cp.php'; //if it fails, include the form again
    }
    //cleanup
    $con->close();
}
?>
