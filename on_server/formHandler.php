<?php
/* This file is updateData.php
   It is called from GWC1.php via a form (POST action)
   It saves the data into a file and then returns to GWC1.php
*/

#show all errors and warnings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';

# get the data from the POST form
# sanitize data
$data = clean_input($_POST['command']);
$data = strtoupper($data);
$data = onlyAlphaNumeric($data);
#debug:
#echo "data=".$data;

$file = fopen($cmdfile, 'w');
fwrite($file, $data);
fclose($file);

# now redirect back to GWC1.php
#header("Location: GWC1.php");
header("Location: {$_SERVER['HTTP_REFERER']}");
die("something is wrong");


//This condenses multiple white spaces down to a single space (I think)
function removeWhiteSpace($text)
{
    $text = preg_replace('/[\t\n\r\0\x0B]/', '', $text);
    $text = preg_replace('/([\s])\1+/', ' ', $text);
    $text = trim($text);
    return $text;
}

function clean_input($data) {
   //$data = addslashes(htmlspecialchars(trim($data))); NO!!
   //$data = filter_var ($data, FILTER_SANITIZE_STRING);
   $data = trim(strip_tags(addslashes($data)));
   return $data;
}

function onlyAlphaNumeric($data){
   $result = preg_replace("/[^a-zA-Z0-9 ]+/", "", $data);
   return $result;
}
?>

