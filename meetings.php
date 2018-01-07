<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <title>Video Game Development Club</title>
</head>

<body>
    <?php include 'res/bar.php';?>
    <div style="margin-left:10%; margin-top:10%; color:#ffffff;"></div>
	<div>
        <div class="wrapper" style = "overflow = auto;"> 
        	<div class="header-text"><strong>Meetings and Workshops</strong></div>
            <div> <!-- Just to clean up formating -->
            <div class="meetings">
                <h3>GENERAL MEETINGS</h3> 
                <!--
                <p>Every <b>Wednesday at 7:00 p.m.</b> in <b>Social Science Lab 228</b></p> 
                <p>Every <b>Tuesday at 8:30 p.m.</b> in <b>Social Science Lecture Hall 100</b></p> 
                -->
		<p>Meeting Time and Place TBA</b></p>

                <div class = "left">
                    <!-- NOTE: Update BOTH bellow URL's for each new classroom -->
		<!--
                	<a href="http://www.classrooms.uci.edu/GAC/SSLH100.html"><img style="max-width:100%;" src="http://www.classrooms.uci.edu/gac/mapgrids/SSLH.png"></a>
		-->
                </div>

                <div class = "left">
                	<?php include 'res/gen_meetings.php';?>
	                <div style="margin-top: 8px;">
	                    <span>**Mandatory</span>
	                    <span>*Highly Recomended</span>
	                </div>
            	</div>
           	</div>

            <div class="meetings">
                <h3>WORKSHOPS</h3>
                <!--
                <p>All workshops are held in the <a  href="./lab.php">Game Lab</a> unless otherwise stated. We expect to begin holding workshops in a new space in ICS2 later this quarter.</p>
                -->
                <?php include 'res/workshops.php';?>
            </div>
            </div>
        </div>     
    </div>

    <div>   
        <?php include 'res/foot.php';?>    
    </div>
</body>
</html> 
