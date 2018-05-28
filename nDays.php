
<?php
//EnviroMon nDays Page

require 'includes/db.php';          //database access
require 'includes/template.php';    //template handler
require 'includes/tictoc.php';      //timing functions
require 'includes/sensors.php';     //provides $sensorT, $locationT, $sensorH, $locationH, $sensorP, $locationP

$timeVal  = mktime(0, 0, 0, date("m"), date("d"), date("Y")); //0:00:00 today
$nDays = filter_input(INPUT_GET, 'n', FILTER_VALIDATE_INT); //number of days to display
$startTime = $timeVal - $nDays*24*60*60; //0:00:00 of starting day
$startday = date("Y-m-d", $startTime);

$values['nDays'] = $nDays;
$values['startTime'] = $startTime;

tic(); //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

//###################################################
//N-DAYS AVERAGE TEMPERATURE AND HUMIDITY
$dN=[];
$tN=[];
$hN=[];

//initialize sums
for($sensorN=0; $sensorN<count($sensorT); $sensorN++)
{
    $dN[$sensorN] = 0;
    $tN[$sensorN] = 0;
    $hN[$sensorN] = 0;
}

for($sensorN=0; $sensorN<count($sensorT); $sensorN++)
{
    $j = $sensorT[$sensorN];
    $dN[$sensorN] = date("Y-m-d",$startTime);
    
    for($k=0; $k<$nDays; $k++)
    {
        $dayStart = $startTime + $k*24*60*60; //0:00:00 on dayN
        $qYear = date("Y", $dayStart);
        $qMonth = date("m", $dayStart);
        $qDay = date("d", $dayStart);
        
        $sql = 
	"SELECT AVG(temperature) AS ndayTemp, AVG(humidity) AS ndayHumid " .
	"FROM data WHERE sensor=$j
		AND year ='" . $qYear . "' 
		AND month ='" . $qMonth . "' 
		AND day ='" . $qDay . "'"; 

        $result = $db->query($sql);
        $value = $result->fetch_array(MYSQL_ASSOC);
        
        $tN[$sensorN] += $value['ndayTemp']; //sum daily average temperature
        $hN[$sensorN] += $value['ndayHumid']; //sum daily average humidity
    }
}

//calculate n-day average for each sensor
for($sensorN=0; $sensorN<count($sensorT); $sensorN++)
{
    $tN[$sensorN] /= $nDays;
    $hN[$sensorN] /= $nDays;
}
        
//pass to the template
$values['yesterdayTimes'] = $dN;
$values['yesterdayTemps'] = $tN;
$values['yesterdayHumids'] = $hN;
$values['location'] = $locationT;


//###################################################
//TEMPERATURE CHART- HOURLY AVERAGE for nDays
$tN = [];
for($sensorN=0; $sensorN<count($sensorT); $sensorN++)
{
    $v1 = [];
    $j = $sensorT[$sensorN];
    
    for($k=0; $k<$nDays; $k++)
    {
        $dayStart = $startTime + $k*24*60*60; //0:00:00 on dayN
        $qYear = date("Y", $dayStart);
        $qMonth = date("m", $dayStart);
        $qDay = date("d", $dayStart);
        
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
                $v1[] = $value['avgValue'];
        }
    }
    $tN[] = $v1;
}

$values['chartTemperature-hourly'] = $tN; //pass to the template
$values['locationT'] = $locationT;


//###################################################
//HUMIDITY CHART - HOURLY AVERAGE for nDays
$hN = [];
for($sensorN=0; $sensorN<count($sensorH); $sensorN++)
{
    $v1 = [];
    $j = $sensorH[$sensorN];

    for($k=0; $k<$nDays; $k++)
    {
        $dayStart = $startTime + $k*24*60*60; //0:00:00 on dayN
        $qYear = date("Y", $dayStart);
        $qMonth = date("m", $dayStart);
        $qDay = date("d", $dayStart);
        
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
                $v1[] = $value['avgValue'];
        }
    }
    $hN[] = $v1;
}

$values['chartHumidity-hourly'] = $hN; //pass to the template
$values['locationH'] = $locationH;


//###################################################
//PRESSURE CHART - HOURLY AVERAGE for nDays
$pN = [];
for($sensorN=0; $sensorN<count($sensorP); $sensorN++)
{
    $v1 = [];
    $j = $sensorP[$sensorN];
    
    for($k=0; $k<$nDays; $k++)
    {
        $dayStart = $startTime + $k*24*60*60; //0:00:00 on dayN
        $qYear = date("Y", $dayStart);
        $qMonth = date("m", $dayStart);
        $qDay = date("d", $dayStart);
        
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
    }
    $pN[] = $v1;
}
$values['chartPressure-hourly'] = $pN; //pass to the template
$values['locationP'] = $locationP;


//###################################################
//PASS VALUES TO TEMPLATE FOR DISPLAY
//new instance of template handler for INDEX template
$tpl = new Template('nDays');

//pass these variables to our template
$tpl->vars = array(
	'values' => $values
);

//compile and print template
$tpl->render();

toc(); //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

?>
