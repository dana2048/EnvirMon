
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

//########## get average temperature and humidity for yesterday ##########
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

//get average values
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


//PRESSURE CHART
$sql = 
"SELECT pressure " .
"FROM data WHERE sensor=3 AND YEAR(stamp)='" . $thisYear . "' AND MONTH(stamp)='" . $thisMonth . "'";

$result = $db->query($sql);

$t = array();
	//echo '<pre>';
	while ( $row = $result->fetch_array(MYSQL_ASSOC) ) 
	{
		$t[] = $row['pressure'];
			//print_r($row); echo "<br>";
	}

	//echo '</pre><hr>';
$values['chartPressure'] = $t;

//new instance of template handler for INDEX template
//$tpl = new Template('index');

//pass these variables to our template
//$tpl->vars = array(
//	'values' => $values
//);


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
