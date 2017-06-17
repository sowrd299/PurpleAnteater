<?php //always wrap PHP code in these

function get_text($text){ //all variables, including parameters, must start with $
    //blocks are marked with braces
    if($text == 'webmaster'){ //if must include parenthesis
        //strings may use single or double quotes; our website's convention is single quotes in php, double in HTML 
        return 'Hi Webmaster!'; //each line of code must end in a brace or a semicolon
    }elseif($text == 'webofficer'){
        return 'Hi Officer!';
    }else{
        return 'Good bye';
    }
}

//just like python, loose code ('the script') will run by default
$text = get_text( $_GET['name'] ); //use $_GET['param_name'] to access get parameters, and $_POST to access post parametes
echo('<!DOCTYPE HTML>');
echo('<html><body>');
echo('<h1>Welcome to my PHP Webpage!</h1>');
echo('<p>'.$text.'</p>');
echo('</body></html>');


?>
