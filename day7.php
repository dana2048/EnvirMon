
<!--- EnviroMon Yesterday Page --->

<?php

require 'includes/db.php';	//database access
require 'includes/template.php';	//template handler

function PrintR($title, $variable)
{
	echo "<br>";
	echo $title;
	echo '-- ';
	print_r($variable); 
	echo "<br>";
	echo "<br>";
}

function PrintArray($title, $val)
{
	echo "<br>";
	echo $title;
	echo "-- <br>";
	$num = count($val);
	for($i=0; $i<$num; $i++)
	{
		echo(sprintf("%03d",$i) . " " . date("Y-m-d H:i",$val[$i]) . "<br>");
	}
	echo "<br>";
	echo "<br>";
}

class KONST
{
	const numDays = 7;
	const numSamples = KONST::numDays*24;
}

$indoorSensIndex = 1;
$outdoorSensIndex = 2;
$crawlSensIndex = 3;
$pressSensIndex = 4;

$d4 = array(0,0,0,0);
$t4 = array(0,0,0,0);
$h4 = array(0,0,0,0);
$sensor = array(1,5,4,6,3);
$location = array('indoor DHT22', 'indoor AM2302', 'outdoor AM2302', 'crawl space');

$numDays = 7;
$numSamples = $numDays*24;

$timeVal  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
$yesterday = date("Y-m-d", $timeVal);
$qYear = date("Y", $timeVal);
$qMonth = date("m", $timeVal);
$qDay = date("d", $timeVal);

$startTime  = mktime(0, 0, 0, date("m")  , date("d")-7, date("Y"));
//PrintR('$startTime', date("Y-m-d", $startTime));

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
//7-day AVERAGE TEMPERATURE AND HUMIDITY X 4

$numDays = 7;
$timeVal  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
$today = date("Y-m-d", $timeVal);

$oneDay = new DateInterval('P1D');
$dateVal = new DateTime($today);

for($iDay=0; $iDay<$numDays; $iDay++)
{
	$dateVal->sub($oneDay);
	//PrintR('$dateVal',$dateVal);
	$yearVal  = $dateVal->format("Y");	//date("Y", $dateVal);
	$monthVal = $dateVal->format("m");	//date("m", $dateVal);
	$dayVal   = $dateVal->format("d");	//date("d", $dateVal);

	for($sensorIdx=0; $sensorIdx<4; $sensorIdx++)
	{
		$sensorID = $sensor[$sensorIdx];
		$sql = 
		"SELECT AVG(temperature) AS avgTemp, AVG(humidity) AS avgHumid " .
		"FROM data WHERE sensor=$sensorID
			AND year ='" . $yearVal . "' 
			AND month ='" . $monthVal . "' 
			AND day ='" . $dayVal . "'";

		$result = $db->query($sql);

		while ( $row = $result->fetch_array(MYSQL_ASSOC) ) 
		{
			$d = $dateVal->format("Y-m-d");
			$t = $row['avgTemp'];
			$h = $row['avgHumid'];
		}

		//summation
		$d4[$sensorIdx] = $d;	//will end up with the beginning date of the $numDays period
		$t4[$sensorIdx] += $t;
		$h4[$sensorIdx] += $h;
	}
}

for($sensorIdx=0; $sensorIdx<4; $sensorIdx++)
{
	//average
	$t4[$sensorIdx] /= $numDays;
	$h4[$sensorIdx] /= $numDays;
}

$values['yesterdayTimes'] = $d4;
$values['yesterdayTemps'] = $t4;
$values['yesterdayHumids'] = $h4;
$values['location'] = $location;


//###########################################################
//TEMPERATURE CHART INDOOR - HOURLY AVERAGE FOR $numDays DAYS
function HourlyAverage($db, $sens, $startTime, $numDays, $fieldName)
{
	// $s1 = array();
	$t1 = array();
	for($k=0; $k<$numDays; $k++)
	{
		$aTime = $startTime + $k * 24*60*60;
		$aDay = date("Y-m-d", $aTime);
		$xYear = date("Y", $aTime);
		$xMonth = date("m", $aTime);
		$xDay = date("d", $aTime);


//$t1 = array();
		for($hour=0; $hour<24; $hour++)
		{
			$sql =
				"SELECT AVG($fieldName) AS avgValue, UNIX_TIMESTAMP(stamp) AS tStamp " .
//				"FROM data WHERE sensor=$sens AND date(stamp) ='" . $day . "' AND hour(stamp) ='" . $hour . "'";
				"FROM data WHERE sensor=$sens 
					AND year ='" . $xYear . "' 
					AND month ='" . $xMonth . "' 
					AND day ='" . $xDay . "' 
					AND hour ='" . $hour . "'";

//PrintR('$sql', $sql);
			$result = $db->query($sql);
			$value = $result->fetch_array(MYSQL_ASSOC);
			$t1['time'][] = $value['tStamp'];
			$t1['value'][] = $value['avgValue'];
		}
	}
//PrintR("t1['time']", $t1['time']);

	return $t1;
}

$values['temperatureIn-hourly'] = HourlyAverage($db, $sensor[$indoorSensIndex], $startTime, KONST::numDays, 'temperature');

//###################################################
//TEMPERATURE CHART OUTDOOR - HOURLY AVERAGE
$values['temperatureOut-hourly'] = HourlyAverage($db, $sensor[$outdoorSensIndex], $startTime, KONST::numDays, 'temperature');


//###################################################
//TEMPERATURE CHART CRAWL SPACE - HOURLY AVERAGE
$values['temperatureCrawl-hourly'] = HourlyAverage($db, $sensor[$crawlSensIndex], $startTime, KONST::numDays, 'temperature');


//###################################################
//HUMIDITY CHART INDOOR - HOURLY AVERAGE
$values['humidityIn-hourly'] = HourlyAverage($db, $sensor[$indoorSensIndex], $startTime, KONST::numDays, 'humidity');


//###################################################
//HUMIDITY CHART OUTDOOR - HOURLY AVERAGE
$values['humidityOut-hourly'] = HourlyAverage($db, $sensor[$outdoorSensIndex], $startTime, KONST::numDays, 'humidity');


//###################################################
//HUMIDITY CHART CRAWL SPACE - HOURLY AVERAGE
$values['humidityCrawl-hourly'] = HourlyAverage($db, $sensor[$crawlSensIndex], $startTime, KONST::numDays, 'humidity');


//###################################################
//PRESSURE CHART - HOURLY AVERAGE
/*$t1 = array();
$j = $sensor[$pressSensIndex];
for($i=0; $i<24; $i++)
{
	$sql =
		"SELECT AVG(pressure) AS avgValue " .
		"FROM data WHERE sensor=$j 
			AND year ='" . $qYear . "' 
			AND month ='" . $qMonth . "' 
			AND day ='" . $qDay . "' 
			AND hour ='" . $i . "'";

	$result = $db->query($sql);
	$value = $result->fetch_array(MYSQL_ASSOC);
	$t1[] = $value['avgValue'];
}

$values['chartPressure-hourly'] = $t1;
*/

$values['pressure-hourly'] = HourlyAverage($db, $sensor[$pressSensIndex], $startTime, KONST::numDays, 'pressure');


//###################################################
//PASS VALUES TO TEMPLATE FOR DISPLAY
//new instance of template handler for INDEX template
$tpl = new Template('day7');

//pass these variables to our template
$tpl->vars = array(
	'values' => $values
);

//compile and print template
$tpl->render();

toc(); //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

?>
