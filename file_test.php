<?php

/**
Just testing PHP's file commands
*/

$filename = "test.txt";
$data = "Now is the time for all good men to come to the aid of their country";

$fp = fopen($filename, 'w'); 
print_r($fp);
fwrite($fp, $data); 
fclose($fp);


$fp = fopen($filename, 'r'); 
$contents = fread($fp, filesize($filename));
fclose($fp);

echo $contents;
echo "<br><br>";

unlink($filename);

if($srcName = "test1.jpg")
	$srcName = "test2.jpg";
else
	$srcName = "test1.jpg";

$srcName = "test1.jpg";
$dstName = "copy.jpg";

$fp = fopen($dstName, 'w');
echo "fopen = " . $fp . "<br>";

//$success = fclose($fp);
//echo "fclose = " . $success . "<br>";

$success = unlink($dstName);
echo "unlink = " . $success . "<br>";

echo "copy( " . $srcName . ", " . $dstName . " )<br><br>";
$success = copy( $srcName, $dstName );
if(!$success) echo "file copy FAIL<br>";

echo "<img src='" . $dstName . "'>";


?>
