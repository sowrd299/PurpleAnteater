<?php
/* This page is for browsing and playing uploaded games.
 * it is a bit unique from the architecture of earlier pages;
 * here I am playing with a fare more modulure approach: combining the browing and playing indo a single document
 * that and switch between the two based on Get arguments given.
 * This new approach hopefully will be more organized and more convetional to other LAMP websites.
 */
include_once 'res/web_game.php';
include_once 'res/list_web_games.php';
include_once 'res/lib.php';
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/games.css">
    <title>Video Game Development Club</title>
</head>

<body>
    <?php include 'res/bar.php'?>

    <div style="margin-left:10%; margin-top:5%; color:#ffffff;"></div>

    <div class="wrapper">
        
        <div class="header-text"><strong>Games</strong></div>

        <div class="content">

<?php
$con = sql_connect();
//GAME PAGE
if(isset($_GET['game'])){
    $id = $_GET['game'];
    //get the folder of the game by ID from the database
    $stmt = $con->prepare('SELECT g.folder, g.title, g.about FROM game_uploads g WHERE g.id = ?;');
    $stmt->bind_param('s',$id);
    $stmt->execute();
    $stmt->bind_result($folder, $title, $about);
    //actually embed the game
    if($stmt->fetch()){
        $stmt->close(); //this needs to be here so we can reuse the con to make querries to get related games
        embed_game($title, $folder, $about,
                function() use ($about, $con, $id){ //this function is used to display related games
                    return disp_searched_games($con, $about, 5, $id); });
    }else{ //if the game id is not in the database:
        $stmt->close();
        echo('<p>The game you are looking for does not seem to exist...</p>');
    }
    //clean up 
//GAMES HOME PAGE
}else{
    //a littel blurb
    echo('<p>Welcome to our games page! This is where you can sample the many, awesome games that our members have made.</p>');
    //the search bar
    //TODO: put this in a better place
    echo('<form action="?" method="get">
          <h1 class="game_title"><strong>SEARCH GAMES!</strong></h1>
          <br/>
          <input type="text" name="search"/>
          <input type="submit" value="Search"/>
          </form>');
    //SEARCH RESULTS
    if(isset($_GET['search'])){ //if the user is searching for something
        echo('<h3>Search Results for "'.$_GET['search'].'":</h3>');
        begin_games();
        if(!disp_searched_games($con,$_GET['search'])){
            //if the search didn't find anything
            echo('<p><i>No results found.</p>');
        }
        end_games();
    }
}
//a page-break, to keep things organized:
?>

        </div>
        <div class="content">

<?php
//list recent games on the bottom of the page
begin_games();
echo('<h3 class="game_title"><strong>NEW GAMES!</strong></h3>');
disp_recent_games($con,5);
end_games();
$con->close();
?>

        </div>
    </div>

</body>
</html>