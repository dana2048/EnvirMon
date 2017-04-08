
//###################################################
function PrintR($title, $variable)
{
	echo "<br>";
	echo $title;
	echo '-- ';
	print_r($variable); 
	echo "<br>";
	echo "<br>";
}


//###################################################
//	echo '<pre>';
/*
	echo 'print_r($row)'; echo "<br>";
	print_r($row); echo "<br>";

	echo 'print_r($t)'; echo "<br>";
	print_r($t);

	echo 'print_r($t4[$i])'; echo "<br>";
	print_r($t4[$i]);
	echo '</pre><hr>'; */


//echo '$_SERVER[TMP]=' . $_SERVER['TMP'] . '<br>';
//echo 'sys_get_temp_dir =' . sys_get_temp_dir() . '<br>';;


//###################################################
//CURRENT TEMPERATURE AND HUMIDITY
$sql = 
'SELECT * FROM ' .
'(SELECT * FROM data WHERE sensor=1 ORDER BY id DESC) data2 ' .
'limit 1;';

$result = $db->query($sql);
$value = $result->fetch_array(MYSQL_ASSOC);

$values['currentTemp'] = $value['temperature'];
$values['currentHumid'] = $value['humidity'];
$values['timeStamp'] = $value['stamp'];


	echo '<pre>';
	echo 'print_r($row)'; echo "<br>";
	print_r($row); echo "<br>";
	echo '</pre><hr>';
