<?php include 'res/web_game.php'?>

<!DOCTYPE html>
<html>
<head>
    <!-- this is a test of sftp -->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Video Game Development Club</title>
</head>

<body>
    <?php include 'res/bar.php'?>

<?php
if(isset($_GET['game'])){ //if there is a request for a game
    //TODO: clean the 
    embed_game($_GET['game']);
}
?>

</body>
</html>