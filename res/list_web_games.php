<?php

/* Contains code for constructing a list of web games
 * architecture is based on architecture used in workshops.php
 */

/* Displays a single game that could be played
 * NOTE: if you update how games are displayed, you will need to update this HTML
 */
function disp_game_link($name, $id){
    echo('<a href="./games.php?game='.$id.'" class="game_link">'.$name.'</a>');
}

/* To be called before a list of games
 */
function begin_games(){
    echo('<div class="game_list">');
}

/* To be called after a list of games
 */
function end_games(){
    echo('</div>');
}

/* Displays a number of the most recently uploaded games
 */
function disp_recent_games($con, $number){
    //setup and run a SQL select querry
    $stmt = $con->prepare('SELECT g.title, g.id FROM game_uploads g ORDER BY g.date DESC LIMIT ?;');
    echo('<!--SQL Error: '.$con->error.'-->');
    $stmt->bind_param('i', $number);
    $stmt->execute();
    $stmt->bind_result($title,$id);
    //display the results
    while($stmt->fetch()){
        disp_game_link($title, $id);
    }
    //cleanup
    $stmt->close();
}

/* Searchs the database for games related to the given terms and displays them
 * Returns whether or not any where found
 * Optionally allows you to change the number of items dsiplayed
 * and to excluse a single item by its ID
 */
function disp_searched_games($con, $terms, $number = 30, $exclude = ''){
    $found = false; //tracks if we found anything
    //set up the search
    $stmt = $con->prepare('SELECT g.title, g.id
                           FROM game_uploads g 
                           WHERE (NOT g.id = ?) AND
                           MATCH(title, about, folder)
                           AGAINST (?
                           IN NATURAL LANGUAGE MODE WITH QUERY EXPANSION)
                           LIMIT ?;');
                           //this is a "fulltext" search 
                           //the table must have a full text index on the used fields
    echo('<!--SQL Error: '.$con->error.'-->');
    $stmt->bind_param('ssi', $exclude, $terms, $number);
    $stmt->execute();
    $stmt->bind_result($title,$id);
    //display the results
    while($stmt->fetch()){
        $found = true;
        disp_game_link($title, $id);
    }
    //cleanup
    $stmt->close();
    return $found;
}

?>