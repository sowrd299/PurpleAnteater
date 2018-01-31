<?php

include_once '../res/lib.php'; //get $GAMES_FOLDER

/* Uploads a game file. Takes the title of the game,
 * and if it is okay to replace previous uploads with that name
 */
function save_game($title, $game, $replace_ok = false){
    global $GAMES_FOLDER;

    $path = '../'.$GAMES_FOLDER; //use ../ to escape /admin/R
    $full_path = $path.'/'.$title; //the path to the game folder after it is extracted
    $extension = strtolower(pathinfo($game['name'],PATHINFO_EXTENSION));

    //check valid upload
    if($extension != 'zip'){
        echo('<p>Game must be zipped to preserve file structure. Please zip it and try again.</p>');
        return;
    }

    //check file size, so we don't get bombed.... as easily
    if($game['size'] > 500000){
        echo('<p>The game is too large. Please contact the Webmaster.</p>');
        return;
    }

    //handle repeat uploads
    if(!$replace_ok && file_exists($full_path)){
        //TODO: more robust error handling
        echo('<p>"'.$title.'" already exists, please try again.</p>');
        return;
    }


    $zip = new ZipArchive;
    if($zip->open($game['tmp_name'])){

        //verify some facts about the file structure, to make sure it is actually a game
        if($zip->locateName($title.'/index.html') === false){
            echo('<p>This does not appear to be a WebGL game, or it is zipped impropperly. Please compile for WebGL with the title "'.$title.'".</p>');
            return;
        }

        //extract and save the game
        if($zip->extractTo($path)){
            echo('<p>'.$title.' has been uploaded.</p>');
            return true;
        }
        $zip->close();
    }

    echo('<p>There was an error saving the file</p>');
}

/* Alters the title into a standardized and computer-friendly format
 * Puts into all capatalized words, no spaces or other space-delimiting characters
 */
function format_game_title($title){
    return str_replace(' ','',ucwords(str_replace('_',' ',str_replace('-',' ',$title))));
}

//the main body
if($_SESSION['loading']){
    $title = format_game_title($_POST['title']);
    if(!save_game($title, $_FILES['gameFile'], isset($_POST['replace']))){ //'replace' is set iff it was checked
        include 'game_uploads_cp.php'; //if it fails, include the form again
    } 
}
?>