
<!--- EnviroMon Monthly Page --->

<?php

require 'includes/db.php';          //database access
require 'includes/template.php';    //template handler
require 'includes/tictoc.php';      //timing functions
require 'includes/sensors.php';     //provides $sensorT, $locationT, $sensorH, $locationH, $sensorP, $locationP

$d4 = array(4);
$t4 = array(4);
$h4 = array(4);

$timeVal  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
$thisMonth = date("m", $timeVal);
$thisYear = date("Y", $timeVal);
$daysInMonth = intval(date('t'));

tic(); //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

//###################################################
//TEMPERATURE CHART - ONE MONTH DAILY AVERAGE
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

//###########################################
//TEMPERATURE CHART - ONE MONTH DAILY AVERAGE
$tN = [];
for($sensorN=0; $sensorN<count($sensorT); $sensorN++)
{
    $tN[] = DailyAverage($db, $sensorT[$sensorN], $thisYear, $thisMonth, $daysInMonth, 'temperature');
}

$values['temperatureMonth'] = $tN; //pass to the template
$values['locationT'] = $locationT;


//#########################################
//HUMIDITY CHART  - ONE MONTH DAILY AVERAGE
$hN = [];
for($sensorN=0; $sensorN<count($sensorH); $sensorN++)
{
    $hN[] = DailyAverage($db, $sensorH[$sensorN], $thisYear, $thisMonth, $daysInMonth, 'humidity');
}

$values['humidityMonth'] = $hN; //pass to the template
$values['locationH'] = $locationH;


//########################################
//PRESSURE CHART - ONE MONTH DAILY AVERAGE
$pN = [];
for($sensorN=0; $sensorN<count($sensorP); $sensorN++)
{
    $pN[] = DailyAverage($db, $sensorP[$sensorN], $thisYear, $thisMonth, $daysInMonth, 'pressure');
}

$values['pressureMonth'] = $pN; //pass to the template
$values['locationP'] = $locationP;


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
