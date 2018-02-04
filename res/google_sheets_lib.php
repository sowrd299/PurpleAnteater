<?php

include_once 'res/lib.php';

/* Contains functions for working with Google Sheets
 * ...well actually for working with CSV's, but that's mostly just the medium we use to interface with google sheets
 */

 /* URL's of important Google Sheets
  * retrieve them by:
  *     Opening the sheet in Google Sheets
  *     File->Publish to web...
  *     select CSV for the format
  *     Publish
  *     Copy the provided URL
  */
//TODO: provide information about what to do with multiple sheets in the same document
//$WORKSHOPS_CSV_URL = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTwhZ8BzyDLEk_mu-iRfWw4JUvp8KlqRan87qCNPUPBuZBAeU6HYFuxAj43ntDjq7yoWBA4FqoKTH6F/pub?output=csv';
//$WORKSHOPS_CSV_URL = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vT0DSqD8Kff8wq_2LEcNwsocBYhQTifNopOQXnC4ZytFcV7XhZBzi-Nqw9KgCe7D8dHDfZoksWLIs74/pub?output=csv';
$WORKSHOPS_CSV_URL = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQtFIX8GGvnxLDyYd2wskobpB_Tiavoj8Y8C9uuSTtxPJ_IMPVE4TQDGnhoeI4t1gpUSg3e5VQDJzVJ/pub?output=csv';


/* Splits a line of CSV code
 */
function explode_csv($delim, $line){
    $r = array(); //all found values
    $current = ''; //the value currently being read
    $quote_mode = false; //if we are inside quotes
    $cd = strlen($delim);
    foreach(str_split($line) as $char){
        if($char == '"') $quote_mode = !$quote_mode; //on every quote, toggle quote-mode
        else{
            $current .= $char;
            if(!$quote_mode && substr($current,-$cd) == $delim){ //when get to the end of a value
                array_push($r, substr($current,0, strlen($current)-$cd));
                $current = '';
            }
        }
    }
    array_push($r, $current);
    return $r;
}

/* Converts a day of the week to standard internal representation
 */
function parse_day($day){
    return ['day' => day_to_int($day)];
}

/* Parses a representation of time to an actual time
 * mostly a helper function for parse_times
 * on failures returns null
 */
function parse_time($time, $earliest = '10:00 AM'){
    //breakup the time into hour, minute, am/pm
    //as soon as someone gets cheacky and says "10:00:01" or "1 in the afternoon", this breaks, just by the way
    if(!preg_match( '/^(\d?\d)([:.,;]\d\d)* *(([pP]|[aA])\.?[mM]?\.?)?$/', $time, $matches)) return;
    $hour = $matches[1];
    $minute = isset($matches[2]) && strlen($matches[2]) > 0? substr($matches[2],1) : '00'; //trim off the ;, provide default minutes if none given
    $am_or_pm = ''; //default for none given and none needed (24h)
    if(isset($matches[3])){ //if given, us it
        $am_or_pm = $matches[3];
    }elseif($hour <= 12){ //if missing and 12h time, guess am/pm based on earliest
        $am_or_pm = strtotime($hour.':'.$minute.'am') < strtotime($earliest)? 'pm' : 'am';
    }
    //echo($hour.':'.$minute.$am_or_pm); //TESTING
    //format to SQL standard and return
    return date('H:i:s', strtotime($hour.':'.$minute.$am_or_pm));
}

/* Converts a text to the standard start and end time used intenrally
 * assumes start and end times will be deliniated;
 * assumes no workshops will begin or end before the designated eealiest time
 *      and will not start or end more then twelve hours after that time
 * if only one time given, assumes will last given default durration
 * returns ['start time'=>null, 'endtime=>'now + $defualt_duration'] on failure
 */
function parse_times($time, $delim = ['-','to','until'], $earliest = '10:00 AM', $defualt_duration = '1 hour'){
    //break apart each sporate time used
    $times = tokenize($time, $delim);
    //parse each time
    $parsed_times = array_map(function($time) use ($earliest) { return parse_time($time, $earliest); }, $times);
    //package the return values
    return [ 'start time' => $parsed_times[0],
             'end time' => isset($parsed_times[1])? $parsed_times[1] : date('H:i:s',strtotime($parsed_times[0].'+'.$defualt_duration)) ];
}

/* Finds and extracts all instances from the given list in the test
 * assumes the instances will be deliniated from the main text by a given deliniator
 * will also remove stray deliniators
 */
function parse_tangled($text, $find, $delim = [':'], $paired_delim = ['(',')'] ){

    //break into tokens (using tokenize)
    //TODO: write the code

    //find the departments
    //TODO: write the 

    //deal with rogue delims
    //TODO: write the code

    //return
}

/* Parses the provideded CSV into a PHP array
 * Each item in the array is an array representing a row in the spreadsheet
 * Each attribute in an inner arrays is "collum_name" => "value"
 * Supports alternate delimeters (e.g., TSV) with $delim
 * Multi-value values will also be converted to arrays (takes delimeters used from $multival_delim or $multival_delim_by_attrs)
 * Use $multivalue_attrs to force multiple values or singletons
 *      set high to force multival, low to force singleton
 *      if multiple values are found in a force singleton collum, will break into multiple rows
 *      if you want the entire value as a singleton, set $multival_delim_by_attr to []
 * Can apply additional parsing to any attribute with map_attr
 *      keys are the attributes to be applied to
 *      values should be the names of function to call, with interface:
 *          (value) -> [attr => value',...]
 * On failure returns an emptry array
 * NOTE: REQUIRES THE FIRST ROW OF THE CSV TO BE HEADERS
 * NOTE: Content may be "cleaned", e.g., parentheticals will be removed
 * NOTE: while this function is technically N^ something stupid, it runs fine because most loops fire only once
 */
function csv_to_array($csv_path, $delim = ',', $multival_attrs = [], $multival_delim_by_attr = [], $multival_delim = [' / ',','], 
                      $map_attr = ['day'=>'parse_day', 'time'=>'parse_times']){

    //open the csv
    $file = fopen($csv_path, 'r'); //while working Google Sheet, allow_url_fopen must be on in php.ini

    $r = array();

    //parse it
    if ($file) { //do not procede if the file didn't open

        //get the line headers from the first row
        $headers = explode_csv($delim, fgets($file));
        foreach($headers as &$header){ //polish the headers
            $deparen = strstr($header, '(', true); //naively removes parentheticals
            if($deparen) $header = $deparen; //deparen will be false if no parenthical was found to remove
            $header = rtrim($header); //remove trailing whitespace
            $header = strtolower($header); //all lower case, for simplicity
        }

        //read in content
        while (($line = fgets($file)) !== false) {
            $row = array_combine( $headers, explode_csv($delim,$line) );
            $new_rows = [array()]; //kept serporate from row incase we break it into multiple rows to preserve singletons


            //processing for each value
            foreach($row as $k => $v){

                //get multi-values
                $mvd = isset($multival_delim_by_attr[$k])? $multival_delim_by_attr[$k] : $multival_delim; //the set of delimeters used in this col
                $vs = tokenize($v,$mvd);
                
                //handle attribute-specific parsing with map_attr
                $final_attrs = array_map(
                        isset($map_attr[$k]) ? $map_attr[$k] : function($v) use ($k) {return [$k => $v];}, //if no parser given, use identity parser
                        $vs);

                //update new_rows
                $new_new_rows = array(); //not updating new_rows directly to prevent a very specific reference-related bug
                if( isset($multival_attrs[$k]) ? $multival_attrs[$k] : count($final_attrs) > 1 ){
                    //handle mutlival
                    foreach($new_rows as $nr){ //add the new attr to the row(s) being read
                        array_push($new_new_rows, array_merge($nr, array_transpose($final_attrs))); //transpose the array to sort the values of the same attr together
                    }
                }else{
                    //handle single val (break into multiple lines)
                    foreach($new_rows as $nr){ //each exisitng new row will need to be broken
                        foreach($final_attrs as $fas){ //for each permutation it is broken into
                            array_push($new_new_rows, array_merge($nr, $fas)); //....create and add that row
                        }
                    }
                }
                $new_rows = $new_new_rows;
            }

            //add the newly read row(s)
            $r = array_merge($r, $new_rows);
        }
    
        //cleanup
        fclose($file);
    }

    return $r;
}
 
?>