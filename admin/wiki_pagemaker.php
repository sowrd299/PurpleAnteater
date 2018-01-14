<?php

//a library file for auto-generating wiki pages

$wikid = '../wiki/wiki.d'; //path to the folder for wiki pages
$user = @$_SESSION['user'];
$authordv = ($user? 'website' : $user).'-autogen'; //default author

//determines what the name of a page file should be
function create_page_name($group, $name){
    $group = str_replace(' ', '', ucwords($group));
    $name = str_replace(' ', '', ucwords($name));
    return $group.'.'.$name;
}

//Automatically generates the markup for inside the page file
//if write is true, will also go ahead an write it to disk for you
//agent denotes what software wrote the text (uually what web browser)
//targets should be a list of the properly formated names of the pages it links to
function create_page_text($group, $name, $agent='', $text='', $targets=[], $author='', $write=false){
    global $authordv;
    $ftext = 'version=pmwiki-2.2.106 ordered=1 urlencoded=1\n';
    $ftext .= 'agent='.$agent.'\n';
    $ftext .= 'author='.($author? $author : $authordv).'\n';
    $ftext .= 'charset=ISO-8859-1';
    $ftext .= 'csum=\n';
    $ftext .= 'ctime='.strval(time()).'\n';
    $ftext .= 'host=\n';
    $ftext .= 'name='.create_page_name($group, $name).'\n';
    $ftext .= 'rev=1';
    $ftext .= 'targets='.join(',',$targets).'\n';
    $ftext .= 'text='.$text.'\n';
    if($write){
        if(!write_page($group, $name, $ftext)) return;
    }
    return $ftext;
}

//writes the page file
//text should be fully formated, i.e. by create_page_text
//aborts if the file exists already
function write_page($group, $name, $text){
    global $wikid;
    $path = $wikid.create_page_name($group, $name);
    if(fopen($path, 'r')) return;
    $file = fopen($wikid.create_page_name($group, $name), 'w');
    fwrite($file, $text);
    fclose($file);
    return true;
}