<link rel="stylesheet" type="text/css" href="css/bar.css"> 

<div class="bar">
    <div class="dropdown">
        <a class="dropdown_button" href="home.php">HOME</a>
    </div>

    <div class="dropdown">
        <a class="dropdown_button" href="meetings.php">MEETINGS/WORKSHOPS</a>
    </div>

    <div class="dropdown">
        <!--I took out href="about.php since most info will be on home page-->
        <a class="dropdown_button">ABOUT</a>
        <div class="dropdown_content">
            <a href="officers.php" class="dropdown_link">Officers</a>
            <a href="lab.php" class="dropdown_link">Lab</a>
        </div>
    </div>
    <!--
    <div class="dropdown">
        <a class="dropdown_button" href="pt_repo.php?p=about">P.T.R.</a>
        <div class="dropdown_content">
            <a href="pt_repo.php?p=about" class="dropdown_link">About</a>
            <a href="pt_repo.php?p=submit" class="dropdown_link">Submit</a>
            <a href="pt_repo.php?p=test" class="dropdown_link">Test</a>
        </div>
    </div>
    -->
    <div class="dropdown">
        <a class="dropdown_button">RESOURCES</a>
        <div class="dropdown_content">
            <a href="art_resources.php" class="dropdown_link">Art</a>
            <a href="audio_resources.php" class="dropdown_link">Audio</a>

        </div>
    </div>

    <?php
    session_start();
    if(array_key_exists('user', $_SESSION)){
        echo('<div class="dropdown"><a class="dropdown_button" href="admin/home.php">ADMIN CP ('.$_SESSION['user'].')</a></div>');
    }
    ?>

</div>

