<?php
/* Call this function to add a game into a webpage
 * $game takes the name of the game (by the folder it is in within uploads/games/)
 * The HTML of the game is game element is edited here
 * currently set to max width and max height (100% height actually causes scrolling)
 */
function embed_game($game){
    echo('<iframe src="./uploads/games/'.$game.'/index.html" style="width:100%;height:97vh"/>');
}
?>