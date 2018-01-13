<?php if (!defined('PmWiki')) exit();
$WikiTitle = "Video Game Development Club";
$PageLogoUrl = "http://www.clubs.uci.edu/vgdc/img/vgdc_logo.png";

$Skin = "vgdc";

# Uncomment these if needed
#$ScriptUrl = 'http://example.com/pmwiki/pmwiki.php';
#$PubDirUrl = 'http://example.com/pmwiki/pub';

//Authentication Stuff
include_once '../admin/wiki_pws.php';

//this line suppresses the origional password prompt, meaning the password must be entered via wiki_pws
$AuthPromptFmt = array(&$PageStartFmt, 
                  '<p>You cannot access this feature without logging in as an officer.</p>
                  <br/><a href="../admin/home.php">Officer Login</a>',
                  &$PageEndFmt);

//Uploads Stuff
$EnableUpload = 1;
$UploadMaxSize = 1000000;

# Uncomment and change these if needed
# putenv("TZ=EST5EDT"); # if you run PHP 5.0 or older
# date_default_timezone_set('America/New_York'); # if you run PHP 5.1 or newer

$TimeFmt = '%B %d, %Y, at %I:%M %p PST';

//SourceBlock syntax highlighting
include_once("$FarmD/cookbook/sourceblock.php");