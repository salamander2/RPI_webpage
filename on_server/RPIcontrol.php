<?php
/* This file is GWC1.php
   It displays a page that has the contents of a status file.
   It also has a form where you can type in some text and have is saved to a file on the server.
*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';
$error_message = '';

$prevCMD="";	//set to defaut value
$file = fopen($cmdfile, "r"); //don't worry if you can't open it.
#$file = fopen($cmdfile, "r") or die("Unable to open file $cmdfile !");
$prevCMD = fgets($file);
fclose($file);

$RPIdata="";
if (file_exists($datafile)) {
    $file = fopen($datafile, "r");
    $RPIdata = fgets($file);
    fclose($file);
} else {
    $error_message='Data file missing';
}

#parse data. I'm assuming that the data will be letters: RGBY
$R=0; $G=0; $B=0; $Y=0;
if (strpos($RPIdata,'R') !== false) $R=1;
if (strpos($RPIdata,'G') !== false) $G=1;
if (strpos($RPIdata,'B') !== false) $B=1;
if (strpos($RPIdata,'Y') !== false) $Y=1;

 if ($error_message != "") $error_message = "<div class=\"error\">" . $error_message . "</div>";
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="refresh" content="5">
<title>Display and update data</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

<style>
button, input {
  border-radius:4px;
  padding:4px;
  margin:0 0.5em;
}
input {
  background-color:#FFA;
}
.box {
  border:1px solid black;
  border-radius:5px;
  padding:10px;
  display:inline-block;
  background-color: #ACF;
}
.small {
  font-size: 70%;
  font-family:sans-serif;
  font-style:italic;
}
.error {
  color:red;
  font-weight:bold;
  padding:6px;
  border:4px double orange;
  background:#555;
  display:inline;
}
.btn {
  margin:5px;
  padding:5px;
  border:1px solid gray;
  border-radius:5px;
  background-color:#CCC;
}
.btn.on {
  background-color:#FF8;
  box-shadow:5px 5px 8px #888;
}
</style>
</head>

<body>
	
<h2>Command Status of Raspberry PI</h2>
<?php echo $error_message; ?>

<h3>Current command : 
  <input name="status" readonly type="text" value="<?php echo $prevCMD; ?>">  </h3>


<div class="box">
<form method="post" action="formHandler.php">
    <p>Enter Command: <span class="small">(the previous command will be displayed)</span></p>
    <input name="command" type="text" size="25" maxlength="25" autofocus xxxplaceholder="<?php echo $prevCMD; ?>"> 
    <button type="submit" name="submit">Submit</button>
</form>
<p class="small">The command will be automatically uppercased before being saved.<br>
Only one line of text will be saved.<br>
Only A-Z 0-9 and spaces are allowed.</p>
</div>
<p style="font-family:Arial;font-weight:bold;color:red";>WARNING: If the shutdown command remains in place, <br>then the Raspberry Pi will shutdown as soon as it connects to this webpage.</p>
<p></p>
<hr>

<div>
<h3>Status of <s>LEDs</s> Switches on PI</h3>

<span class="btn <?php if($R==1) echo 'on';?>">R</span>
<span class="btn <?php if($B==1) echo 'on';?>">B</span>
<span class="btn <?php if($G==1) echo 'on';?>">G</span>
<span class="btn <?php if($Y==1) echo 'on';?>">Y</span>

</div>
<p></p>
<hr>
<h3>Buttons to Control LEDS</h3>
<p>Note, this is just an extension of the command above. You could just type in 'RGB' to turn on those LEDS.</p>
</body>
</html>

