
<?php
//EnviroMon nDays Page

require 'includes/db.php';          //database access
require 'includes/template.php';    //template handler
require 'includes/tictoc.php';      //timing functions
require 'includes/sensors.php';     //provides $sensorL, $locationT, $sensorH, $locationH, $sensorP, $locationP

$timeVal  = mktime(0, 0, 0, date("m"), date("d"), date("Y")); //0:00:00 today
$nDays = filter_input(INPUT_GET, 'n', FILTER_VALIDATE_INT); //number of days to display
$startTime = $timeVal;  // - $nDays*24*60*60; //0:00:00 of starting day
$startday = date("Y-m-d", $startTime);

$values['nDays'] = $nDays;
$values['startTime'] = $startTime;

$numSensors = count($sensorL);
$numSensors = 4;
$firstSensor = 0;

tic(); //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

//###################################################
//N-DAYS AVERAGE TEMPERATURE AND HUMIDITY
$dateN=[];
$valueN=[];

//initialize sums
for($sensorN=$firstSensor; $sensorN<$numSensors; $sensorN++)
{
    $dateN[$sensorN] = 0;
    $valueN[$sensorN] = 0;
}

for($sensorN=$firstSensor; $sensorN<$numSensors; $sensorN++)
{
    $j = $sensorL[$sensorN];
    $dateN[$sensorN] = date("Y-m-d",$startTime);
    
    for($k=0; $k<$nDays; $k++)
    {
        $dayStart = $startTime + $k*24*60*60; //0:00:00 on dayN
        $qYear = date("Y", $dayStart);
        $qMonth = date("m", $dayStart);
        $qDay = date("d", $dayStart);
        
        $sql = 
	"SELECT AVG(luminance) AS avgValue " .
	"FROM data WHERE sensor=$j
		AND year ='" . $qYear . "' 
		AND month ='" . $qMonth . "' 
		AND day ='" . $qDay . "'"; 

        $result = $db->query($sql);
        $value = $result->fetch_array(MYSQL_ASSOC);
        
        $valueN[$sensorN] += $value['avgValue']; //sum daily average luminance
    }
}

//calculate n-day average for each sensor
for($sensorN=$firstSensor; $sensorN<$numSensors; $sensorN++)
{
    $valueN[$sensorN] /= $nDays;
}
        
//pass to the template
$values['nDayTimes'] = $dateN;
$values['nDayAverage'] = $valueN;
$values['location'] = $locationL;

function Chart_($firstSensor, $numSensors, $valName, $locName)
{
    global $db, $sensorL, $locationL, $nDays, $startTime, $values;
//###################################################
//CHART- HOURLY AVERAGE for nDays
$valN = [];
$locN = [];
for($sensorN=0; $sensorN<$numSensors; $sensorN++)
{
   $val = [];
   $j = $sensorL[$sensorN+$firstSensor];
    
    for($k=0; $k<$nDays; $k++)
    {
        $dayStart = $startTime + $k*24*60*60; //0:00:00 on dayN
        $qYear = date("Y", $dayStart);
        $qMonth = date("m", $dayStart);
        $qDay = date("d", $dayStart);
        
        for($i=0; $i<24; $i++)
        {
                $sql =
                        "SELECT AVG(luminance) AS avgValue " .
                        "FROM data WHERE sensor=$j 
                                AND year ='" . $qYear . "' 
                                AND month ='" . $qMonth . "' 
                                AND day ='" . $qDay . "' 
                                AND hour ='" . $i . "'";

                $result = $db->query($sql);
                $value = $result->fetch_array(MYSQL_ASSOC);
                $val[] = $value['avgValue'];
        }
    }
    $valN[] = $val;
    $locN[] = $locationL[$sensorN+$firstSensor];
}
$values[$valName] = $valN; //pass to the template
$values[$locName] = $locN;
} //function Chart_

Chart_(0,4,'chartLuminance-hourly','locationL');
Chart_(4,2,'chartLuminance1-hourly','locationL1');


//###################################################
//PASS VALUES TO TEMPLATE FOR DISPLAY
//new instance of template handler for INDEX template
$tpl = new Template('nDays_1');

//pass these variables to our template
$tpl->vars = array(
	'values' => $values
);

//compile and print template
$tpl->render();

toc(); //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

?>
