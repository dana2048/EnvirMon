
<!--- EnviroMon Index Page --->

<?php

require 'includes/db.php';	//database access
require 'includes/template.php';	//template handler

//echo '$_SERVER[TMP]=' . $_SERVER['TMP'] . '<br>';
//echo 'sys_get_temp_dir =' . sys_get_temp_dir() . '<br>';;

//########## get current temperature and humidity ##########
$sql = 'SELECT * FROM data WHERE sensor=1 LIMIT 1';
$sql = 
'SELECT * FROM ' .
'(SELECT * FROM data WHERE sensor=1 ORDER BY id DESC) data2 ' .
'limit 1;';

$result = $db->query($sql);
$value = $result->fetch_array(MYSQL_ASSOC);

$values['timeStamp'] = $value['stamp'];
$values['currentTemp'] = $value['temperature'];
$values['currentHumid'] = $value['humidity'];

//$values['currentTemp'] = 70;
//$values['currentHumid'] = 45;


/* ##########
$stamp = $values['timeStamp'];

//print_r($stamp) ; echo "<br>";

//get yesterday's date
$sql = 
"SELECT date(date('$stamp')-1) as yesterday;";

$result = $db->query($sql);
$value = $result->fetch_array(MYSQL_ASSOC);

//print_r($value); echo "<br>";

$yesterday = $value['yesterday'];
//echo $yesterday; echo "<br>";
########## */


//########## get average temperature and humidity for yesterday ##########
$today = date("Y-m-d");
$timeVal  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
$yesterday = date("Y-m-d", $timeVal);
$thisMonth = date("m", $timeVal);
$thisYear = date("Y", $timeVal);

$sql = 
"SELECT AVG(temperature) AS yesterdayTemp, AVG(humidity) AS yesterdayHumid " .
"FROM data WHERE sensor=1 AND DATE(stamp)='" . $yesterday . "'";

$result = $db->query($sql);
$value = $result->fetch_array(MYSQL_ASSOC);

$values['yesterdayDate'] = $yesterday;
$values['yesterdayTemp'] = $value['yesterdayTemp'];
$values['yesterdayHumid'] = $value['yesterdayHumid'];

//CHART VALUES
//$a = array(11,3,8,12,5,1,9,13,5,7);
//$values['chart'] = $a;

//###################################################
//TEMPERATURE CHART SENSOR 1
$sql = 
"SELECT temperature " .
"FROM data WHERE sensor=1 AND DATE(stamp)='" . $yesterday . "'";

$result = $db->query($sql);

$t1 = array();
	//echo '<pre>';
	while ( $row = $result->fetch_array(MYSQL_ASSOC) ) 
	{
		$t1[] = $row['temperature'];
			//print_r($row); echo "<br>";
	}

	//echo '</pre><hr>';
$values['chartTemperature1'] = $t1;


//###################################################
//TEMPERATURE CHART SENSOR 1 - HOURLY AVERAGE
$t1 = array();
for($i=0; $i<24; $i++)
{
	$sql =
		"SELECT AVG(temperature) AS avgTemp " .
		"FROM data WHERE sensor=1 AND date(stamp) ='" . $yesterday . "' AND hour(stamp) ='" . $i . "'";

	$result = $db->query($sql);
	$value = $result->fetch_array(MYSQL_ASSOC);
	$t1[] = $value['avgTemp'];
}

$values['chartTemperature1-hourly'] = $t1;

//###################################################
//TEMPERATURE CHART SENSOR 2
$sql = 
"SELECT temperature " .
"FROM data WHERE sensor=2 AND DATE(stamp)='" . $yesterday . "'";

$result = $db->query($sql);

$t2 = array();
	//echo '<pre>';
	while ( $row = $result->fetch_array(MYSQL_ASSOC) ) 
	{
		$t2[] = $row['temperature'];
			//print_r($row); echo "<br>";
	}

	//echo '</pre><hr>';
$values['chartTemperature2'] = $t2;


$t4 = array(4);
$sensor = array(1,2,4,5);
//###################################################
//TEMPERATURE CHART FOUR SENSORS

for($i=0; $i<4; $i++)
{
	$j = $sensor[$i];
	$sql = 
	"SELECT temperature " .
	"FROM data WHERE sensor=$j AND DATE(stamp)='" . $yesterday . "'";

	$result = $db->query($sql);

//	echo '<pre>';
	$t = array();
	while ( $row = $result->fetch_array(MYSQL_ASSOC) ) 
	{
		$t[] = $row['temperature'];
	}

	$t4[$i] = $t;
/*
	echo 'print_r($row)'; echo "<br>";
	print_r($row); echo "<br>";

	echo 'print_r($t)'; echo "<br>";
	print_r($t);

	echo 'print_r($t4[$i])'; echo "<br>";
	print_r($t4[$i]);
	echo '</pre><hr>'; */
}

$values['chartTemperature4'] = $t4;


//###################################################
//MONTH PRESSURE CHART
$sql = 
"SELECT pressure " .
"FROM data WHERE sensor=3 AND YEAR(stamp)='" . $thisYear . "' AND MONTH(stamp)='" . $thisMonth . "'";

$result = $db->query($sql);

$t = array();
	while ( $row = $result->fetch_array(MYSQL_ASSOC) ) 
	{
		$t[] = $row['pressure'];
	}

$values['chartPressure'] = $t;


//###################################################
//MONTH HUMIDITY CHART
$sql = 
"SELECT humidity " .
"FROM data WHERE sensor=1 AND YEAR(stamp)='" . $thisYear . "' AND MONTH(stamp)='" . $thisMonth . "'";

$result = $db->query($sql);

$t = array();
	while ( $row = $result->fetch_array(MYSQL_ASSOC) ) 
	{
		$t[] = $row['humidity'];
	}

$values['chartHumidity'] = $t;


//###################################################
//MONTH TEMPERATURE CHART
$sql = 
"SELECT temperature " .
"FROM data WHERE sensor=1 AND YEAR(stamp)='" . $thisYear . "' AND MONTH(stamp)='" . $thisMonth . "'";

$result = $db->query($sql);

$t = array();
	//echo '<pre>';
	while ( $row = $result->fetch_array(MYSQL_ASSOC) ) 
	{
		$t[] = $row['temperature'];
			//print_r($row); echo "<br>";
	}

	//echo '</pre><hr>';
$values['chartMonthTemperature'] = $t;


//PASS VALUES TO TEMPLATE FOR DISPLAY
//new instance of template handler for INDEX template
$tpl = new Template('index');

//pass these variables to our template
$tpl->vars = array(
	'values' => $values
);

//compile and print template
$tpl->render();

?>
