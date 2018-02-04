<?php
/* Call this function to add a game into a webpage
 * $game takes the name of the game (by the folder it is in within uploads/games/)
 * optionally takes a callback method, used to display related games
 *      the function should take no arguments,
 *      and return if any related games were found
 *      it does NOT need to provide a containing div
 *      if no function is given will ommit the related games section
 */

include_once 'res/lib.php';
include_once 'res/list_web_games.php';

function embed_game($title, $folder, $about, $related_games = ''){
    global $GAMES_FOLDER;
    //the side bar, with info about the game
    echo('<div class="game_info">
              <h1 class="game_title">'.$title.'</h1>
              <h3 class="game_sub_header">About</h3>
              <span>'.$about.'</span>');
    //related games
    if($related_games !== ''){
        echo('<h3 class="game_sub_header">Related Games</h3>');
        begin_games();
        if(!$related_games()){
            echo("<p><i>There don't seem to be many related games</i></p>");
        }
        end_games();
    }
    echo('</div>');
    //the game itself
    echo('<iframe src="'.$GAMES_FOLDER.$folder.'/index.html" class="game"></iframe>');
}
?>