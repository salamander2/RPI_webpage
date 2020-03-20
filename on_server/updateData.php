<?php

#show all errors and warnings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';

$data=$_GET['DATA'];
$data = filter_var ($data, FILTER_SANITIZE_STRING);

$myfile = fopen($datafile, "w") or die("Unable to open file!");
fwrite($myfile, $data );
fclose($myfile);

echo '.';
?>
