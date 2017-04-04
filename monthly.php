
<!--- EnviroMon Index Page --->

<?php

require 'includes/db.php';	//database access
require 'includes/template.php';	//template handler

$indoorSensIndex = 1;
$outdoorSensIndex = 2;
$crawlSensIndex = 3;
$pressSensIndex = 4;

$d4 = array(4);
$t4 = array(4);
$h4 = array(4);
$sensor = array(1,5,4,6,3);
$location = array('indoor DHT22', 'indoor AM2302', 'outdoor AM2302', 'crawl space');

$timeVal  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
$thisMonth = date("m", $timeVal);
$thisYear = date("Y", $timeVal);
$daysInMonth = intval(date('t'));

$ticTime = time();
function tic()
{
	global $ticTime;
	$ticTime = time();
	echo "<br>tic";
}

function toc()
{
	global $ticTime;
	$tocTime = time();
	echo "<br>toc ";
	echo $tocTime-$ticTime;
	echo "<br>";
}

tic(); //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

//###################################################
//TEMPERATURE CHART INDOOR - ONE MONTH DAILY AVERAGE
function DailyAverage($db, $sens, $year_, $month_, $numDays, $fieldName)
{
	$t1 = array();
	for($i=0; $i<$numDays; $i++)
	{
		$sql = 
			"SELECT AVG($fieldName) AS avgValue " .
			"FROM data WHERE sensor=$sens 
				AND year ='" . $year_ . "' 
				AND month ='" . $month_ . "' 
				AND day ='" . (string)($i+1) . "'";

		$result = $db->query($sql);
		$value = $result->fetch_array(MYSQL_ASSOC);
		$t1[] = $value['avgValue'];
	}

return $t1;
}

$values['temperatureMonth-in'] = DailyAverage($db, $sensor[$indoorSensIndex], $thisYear, $thisMonth, $daysInMonth, 'temperature');


//###################################################
//TEMPERATURE CHART OUTDOOR - ONE MONTH DAILY AVERAGE
$values['temperatureMonth-out'] = DailyAverage($db, $sensor[$outdoorSensIndex], $thisYear, $thisMonth, $daysInMonth, 'temperature');


//###################################################
//TEMPERATURE CHART CRAWL - ONE MONTH DAILY AVERAGE
$values['temperatureMonth-crawl'] = DailyAverage($db, $sensor[$crawlSensIndex], $thisYear, $thisMonth, $daysInMonth, 'temperature');


//###################################################
//HUMIDITY CHART INDOOR - ONE MONTH DAILY AVERAGE
$values['humidityMonth-in'] = DailyAverage($db, $sensor[$indoorSensIndex], $thisYear, $thisMonth, $daysInMonth, 'humidity');


//###################################################
//HUMIDITY CHART OUTDOOR - ONE MONTH DAILY AVERAGE
$values['humidityMonth-out'] = DailyAverage($db, $sensor[$outdoorSensIndex], $thisYear, $thisMonth, $daysInMonth, 'humidity');


//###################################################
//HUMIDITY CHART CRAWL - ONE MONTH DAILY AVERAGE
$values['humidityMonth-crawl'] = DailyAverage($db, $sensor[$crawlSensIndex], $thisYear, $thisMonth, $daysInMonth, 'humidity');


//###################################################
//PRESSURE CHART - ONE MONTH DAILY AVERAGE
$values['pressureMonth'] = DailyAverage($db, $sensor[$pressSensIndex], $thisYear, $thisMonth, $daysInMonth, 'pressure');


//###################################################
//PASS VALUES TO TEMPLATE FOR DISPLAY
//new instance of template handler
$tpl = new Template('monthly');

//pass these variables to our template
$tpl->vars = array(
	'values' => $values
);

//compile and print template
$tpl->render();

toc(); //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

?>
