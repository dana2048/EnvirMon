
<!--- EnviroMon Yesterday Page --->

<?php

require 'includes/db.php';          //database access
require 'includes/template.php';    //template handler
require 'includes/tictoc.php';      //timing functions
require 'includes/sensors.php';     //provides $sensorT, $locationT, $sensorH, $locationH, $sensorP, $locationP

$timeVal  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")); //0:00:00 yesterday
$yesterday = date("Y-m-d", $timeVal);
$qYear = date("Y", $timeVal);
$qMonth = date("m", $timeVal);
$qDay = date("d", $timeVal);

tic(); //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

//###################################################
//YESTERDAY AVERAGE TEMPERATURE AND HUMIDITY
$d4=[];
$t4=[];
$h4=[];
for($i=0; $i<count($sensorT); $i++)
{
	$j = $sensorT[$i];
        
	$sql = 
	"SELECT AVG(temperature) AS yesterdayTemp, AVG(humidity) AS yesterdayHumid " .
	"FROM data WHERE sensor=$j
		AND year ='" . $qYear . "' 
		AND month ='" . $qMonth . "' 
		AND day ='" . $qDay . "'";

	$result = $db->query($sql);

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

//pass to the template
$values['yesterdayTimes'] = $d4;
$values['yesterdayTemps'] = $t4;
$values['yesterdayHumids'] = $h4;
$values['location'] = $locationT;


//###################################################
//TEMPERATURE CHART- HOURLY AVERAGE
$tN = [];
for($sensorN=0; $sensorN<count($sensorT); $sensorN++)
{
    $t1 = [];
    $j = $sensorT[$sensorN];
    for($i=0; $i<24; $i++)
    {
            $sql =
                    "SELECT AVG(temperature) AS avgValue " .
                    "FROM data WHERE sensor=$j 
                            AND year ='" . $qYear . "' 
                            AND month ='" . $qMonth . "' 
                            AND day ='" . $qDay . "' 
                            AND hour ='" . $i . "'";

            $result = $db->query($sql);
            $value = $result->fetch_array(MYSQL_ASSOC);
            $t1[] = $value['avgValue'];
    }
    $tN[] = $t1;
}

$values['chartTemperature-hourly'] = $tN; //pass to the template
$values['locationT'] = $locationT;


//###################################################
//HUMIDITY CHART - HOURLY AVERAGE
$hN = [];
for($sensorN=0; $sensorN<count($sensorH); $sensorN++)
{
    $h1 = [];
    $j = $sensorH[$sensorN];
    for($i=0; $i<24; $i++)
    {
            $sql =
                    "SELECT AVG(humidity) AS avgValue " .
                    "FROM data WHERE sensor=$j 
                            AND year ='" . $qYear . "' 
                            AND month ='" . $qMonth . "' 
                            AND day ='" . $qDay . "' 
                            AND hour ='" . $i . "'";

            $result = $db->query($sql);
            $value = $result->fetch_array(MYSQL_ASSOC);
            $h1[] = $value['avgValue'];
    }
    $hN[] = $h1;
}

$values['chartHumidity-hourly'] = $hN; //pass to the template
$values['locationH'] = $locationH;


//###################################################
//PRESSURE CHART - HOURLY AVERAGE
$pN = [];
for($sensorN=0; $sensorN<count($sensorP); $sensorN++)
{
    $v1 = array();
    $j = $sensorP[$sensorN];
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
            $v1[] = $value['avgValue'];
    }
    $pN[] = $v1;
}
$values['chartPressure-hourly'] = $pN; //pass to the template
$values['locationP'] = $locationP;


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

toc(); //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

?>
