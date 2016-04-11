
<!--- EnviroMon Yesterday Page --->

<?php

require 'includes/db.php';	//database access
require 'includes/template.php';	//template handler

$d4 = array(4);
$t4 = array(4);
$h4 = array(4);
$sensor = array(1,2,4,5);
$location = array('indoor', 'indoor', 'outdoor', 'indoor');

$timeVal  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
$yesterday = date("Y-m-d", $timeVal);
$thisMonth = date("m", $timeVal);
$thisYear = date("Y", $timeVal);


//###################################################
//YESTERDAY AVERAGE TEMPERATURE AND HUMIDITY X 4
for($i=0; $i<4; $i++)
{
	$j = $sensor[$i];
	$sql = 
	"SELECT AVG(temperature) AS yesterdayTemp, AVG(humidity) AS yesterdayHumid " .
	"FROM data WHERE sensor=$j AND DATE(stamp)='" . $yesterday . "'";

	$result = $db->query($sql);

/*	echo '<pre>';
	echo 'print_r($result)'; echo "<br>";
	print_r($result); echo "<br>";
	echo '</pre><hr>';
*/
	$t = array();
	while ( $row = $result->fetch_array(MYSQL_ASSOC) ) 
	{
		$d = $yesterday;
		$t = $row['yesterdayTemp'];
		$h = $row['yesterdayHumid'];
	}

	$d4[$i] = $d;
	$t4[$i] = $t;
	$h4[$i] = $h;
}

$values['yesterdayTimes'] = $d4;
$values['yesterdayTemps'] = $t4;
$values['yesterdayHumids'] = $h4;
$values['location'] = $location;




/*$sql = 
"SELECT AVG(temperature) AS yesterdayTemp, AVG(humidity) AS yesterdayHumid " .
"FROM data WHERE sensor=1 AND DATE(stamp)='" . $yesterday . "'";

$result = $db->query($sql);
$value = $result->fetch_array(MYSQL_ASSOC);

$values['yesterdayDate'] = $yesterday;
$values['yesterdayTemp'] = $value['yesterdayTemp'];
$values['yesterdayHumid'] = $value['yesterdayHumid'];
*/

//###################################################
//TEMPERATURE CHART SENSOR 1 (indoor) - HOURLY AVERAGE
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
//TEMPERATURE CHART SENSOR 4 (outdoor) - HOURLY AVERAGE
$t1 = array();
for($i=0; $i<24; $i++)
{
	$sql =
		"SELECT AVG(temperature) AS avgTemp " .
		"FROM data WHERE sensor=4 AND date(stamp) ='" . $yesterday . "' AND hour(stamp) ='" . $i . "'";

	$result = $db->query($sql);
	$value = $result->fetch_array(MYSQL_ASSOC);
	$t1[] = $value['avgTemp'];
}

$values['chartTemperature4-hourly'] = $t1;


//###################################################
//HUMIDITY CHART SENSOR 1 (indoor) - HOURLY AVERAGE
$t1 = array();
for($i=0; $i<24; $i++)
{
	$sql =
		"SELECT AVG(humidity) AS avgValue " .
		"FROM data WHERE sensor=1 AND date(stamp) ='" . $yesterday . "' AND hour(stamp) ='" . $i . "'";

	$result = $db->query($sql);
	$value = $result->fetch_array(MYSQL_ASSOC);
	$t1[] = $value['avgValue'];
}

$values['chartHumidity1-hourly'] = $t1;


//###################################################
//HUMIDITY CHART SENSOR 4 (outdoor) - HOURLY AVERAGE
$t1 = array();
for($i=0; $i<24; $i++)
{
	$sql =
		"SELECT AVG(humidity) AS avgValue " .
		"FROM data WHERE sensor=4 AND date(stamp) ='" . $yesterday . "' AND hour(stamp) ='" . $i . "'";

	$result = $db->query($sql);
	$value = $result->fetch_array(MYSQL_ASSOC);
	$t1[] = $value['avgValue'];
}

$values['chartHumidity4-hourly'] = $t1;


//###################################################
//PASS VALUES TO TEMPLATE FOR DISPLAY
//new instance of template handler for INDEX template
$tpl = new Template('yesterday');

//pass these variables to our template
$tpl->vars = array(
	'values' => $values
);

//compile and print template
$tpl->render();

?>
