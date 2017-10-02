<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <title>Video Game Development Club</title>
</head>

<body>
    <?php include 'res/bar.php';?>
    <div class = "title_img">
    <img src="img/vgdc_logo.png" width="50%"  style = "margin-left: 25%; margin-right: 25%;margin-top: 5%;margin-bottom: 5%;">
    </div>


    <div class = "intro">
        <p>The Video Game Development Club (VGDC) here at UC Irvine devotes to building our members technical expertise, creating successful portfolios, and establishing a professional network with other game developers that give our members an edge when seeking to enter the game industry.</p>
    </div>


    <div class = "wrapper">

        <div class = "about">
            <img src="img/Controller.gif">
            <h3>WHO</h3>
            <p>The Video Game Development Club (VGDC) is made up of students, alumni, and industry professionals who are looking to give the students of UC Irvine a leg up in a competitive marketplace.</p>
        </div>

   
        <div class = "about">
        <img src="img/Peter.gif">       
            <h3>WHAT</h3>
            <p>The primary objective of the Game Development Club at UCI is to provide students with tangible products they can then present in their portfolios and demo reels when applying for jobs post-graduation.</p>
        </div>


        <div class = "about" style = "float = right;">
        <img src="img/Mouse.gif">
            <h3>HOW</h3>
            <p>There is no official process or fee - simply attend as many or as few of our events as you'd like, and you're a member! If you'd like to keep up to date, join our Facebook group and/or subscribe to our newsletter.</p>
        </div>

    </div>

    <div class = "announcement">
        <img src="img/VGDC 2017.jpg" class = "group_photo">
        <div class = "announce_text">
            <h3>GENERAL ANNOUNCEMENTS</h3>
            <?php include 'res/announcements.php';?>
        </div>
    </div>  

    <div>
    	<div class = "wrapper">
    	<h3><center>GET IN TOUCH</center></h3>
        <p><center>Email us at <b>vgdc.uci@gmail.com</b></center></p>
        <p><center>Submit any finished project you made to us at <b>vgdc.uci.submission@gmail.com</b></center></p>
        <div class=content>
        <center>
            <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
            <div id="mc_0mbed_signup">
                <form action="//uci.us6.list-manage.com/subscribe/post?u=8b3da0f5e9544de8bd07adff6&amp;id=b5b4f0c795" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                    <div id="mc_embed_signup_scroll">
                        <h2>SUBSCRIBE TO OUR MAILING LIST</h2>
                        <div class="mc-field-group">
                            <label for="mce-EMAIL">Email Address  <span class="asterisk" style="color: red;">*</span> </label>
                            <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
                        </div>
                        <div class="mc-field-group">
                            <br><label for="mce-FNAME">First Name </label>
                            <input type="text" value="" name="FNAME" class="" id="mce-FNAME">
                        </div>
                        <div class="mc-field-group">
                            <br><label for="mce-LNAME">Last Name </label>
                            <input type="text" value="" name="LNAME" class="" id="mce-LNAME">
                        </div>
                        <div id="mce-responses" class="clear">
                            <div class="response" id="mce-error-response" style="display:none"></div>
                            <div class="response" id="mce-success-response" style="display:none"></div>
                        </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_8b3da0f5e9544de8bd07adff6_b5b4f0c795" tabindex="-1" value=""></div>
                        <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                    </div>
                    <div class="indicates-required" style="color: red;"><span class="asterisk">*</span> indicates required</div>
            </form>
        </center>
        </div>
    	</div>
    </div>
    <div>   
        <?php include 'res/foot.php';?>    
    </div>
</body>
</html> 
