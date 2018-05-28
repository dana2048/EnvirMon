
<!--- EnviroMon Today Page --->

<?php

require 'includes/db.php';          //database access
require 'includes/template.php';    //template handler

$d4 = array(4);
$t4 = array(4);
$h4 = array(4);

$timeVal  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
$today = date("Y-m-d", $timeVal);
$qYear = date("Y", $timeVal);
$qMonth = date("m", $timeVal);
$qDay = date("d", $timeVal);

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

function PrintR($title, $variable)
{
	echo "<br>";
	echo $title;
	echo '-- ';
	print_r($variable); 
	echo "<br>";
	echo "<br>";
}

tic(); //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

//Get array of temperature sensor numbers
$sql = "SELECT number FROM sensor WHERE LOCATE('T', type)";
$result = $db->query($sql);
if( $result == "" )
{
	echo "<br>There was a problem reading the 'sensor' table";
	exit;
}

while($row = $result->fetch_array(MYSQL_ASSOC))
{
    $sensorT[] = $row['number'];
}

//Get array of temperature sensor names
$sql = "SELECT name from sensor WHERE LOCATE('T', type)";
$result = $db->query($sql);
while($row = $result->fetch_array(MYSQL_ASSOC))
{
    $locationT[] = $row['name'];
}

//Get array of humidity sensor numbers
$sql = "SELECT number FROM sensor WHERE LOCATE('H', type)";
$result = $db->query($sql);
while($row = $result->fetch_array(MYSQL_ASSOC))
{
    $sensorH[] = $row['number'];
}

//Get array of humidity sensor names
$sql = "SELECT name from sensor WHERE LOCATE('H', type)";
$result = $db->query($sql);
while($row = $result->fetch_array(MYSQL_ASSOC))
{
    $locationH[] = $row['name'];
}

//Get array of pressure sensor numbers
$sql = "SELECT number FROM sensor WHERE LOCATE('P', type)";
$result = $db->query($sql);
while($row = $result->fetch_array(MYSQL_ASSOC))
{
    $sensorP[] = $row['number'];
}

//Get array of pressure sensor names
$sql = "SELECT name from sensor WHERE LOCATE('P', type)";
$result = $db->query($sql);
while($row = $result->fetch_array(MYSQL_ASSOC))
{
    $locationP[] = $row['name'];
}

//How many sensors are there for reporting
//$numSensors = count($sensorT);


//###################################################
//CURRENT TEMPERATURE AND HUMIDITY
for($i=0; $i<count($sensorT); $i++)
{
	$j = $sensorT[$i];

	$sql = 
	"SELECT stamp, temperature " .
	"FROM data WHERE sensor=$j
                AND temperature != 'NULL'
		AND year = $qYear
		AND month = $qMonth
		AND day = $qDay
 		ORDER BY id DESC LIMIT 1";

	$resultT = $db->query($sql);

	$sql = 
	"SELECT stamp, humidity " .
	"FROM data WHERE sensor=$j
                AND humidity != 'NULL'
		AND year = $qYear
		AND month = $qMonth
		AND day = $qDay
 		ORDER BY id DESC LIMIT 1";

	$resultH = $db->query($sql);

	$d = 0;
	$t = array();
	$h = array();

	//get the last Temperature value
	while ( $row = $resultT->fetch_array(MYSQL_ASSOC) ) 
	{
		$d = $row['stamp'];
		$t = $row['temperature'];
		//$h = $row['humidity'];
	}

	//get the last Humidity value
	while ( $row = $resultH->fetch_array(MYSQL_ASSOC) ) 
	{
		$d = $row['stamp'];
		//$t = $row['temperature'];
		$h = $row['humidity'];
	}

	$d4[$i] = $d;
	$t4[$i] = $t;
	$h4[$i] = $h;
}

if( array_sum($t4) < 1 && array_sum($h4) < 1 )
{
    echo '<br>No data was found for date ' . $today;
    exit;
}

//pass to the template
$values['currentTimes'] = $d4;
$values['currentTemps'] = $t4;
$values['currentHumids'] = $h4;
$values['location'] = $locationT;

//###################################################
//$numValues = count($values);
//$numValues2 = count($values['currentTemps']);

//###################################################
//NEW- Temperature Chart Data will be created for $numSensors sensors
// create array $tN[a][b] where a is numSensors and b is 24 values (hourly average)

$tN = [];
for($sensorN=0; $sensorN<count($sensorT); $sensorN++)
{
    $t1 = [];
    $j = $sensorT[$sensorN];
    for($i=0; $i<25; $i++)
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
//NEW- Humidity Chart Data will be created for $numSensors sensors
// create array $tN[a][b] where a is numSensors and b is 24 values (hourly average)

$hN = [];
for($sensorN=0; $sensorN<count($sensorH); $sensorN++)
{
    $h1 = [];
    $j = $sensorH[$sensorN];
    for($i=0; $i<25; $i++)
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
    for($i=0; $i<25; $i++)
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
$tpl = new Template('index');

//pass these variables to our template
$tpl->vars = array(
	'values' => $values
);

//compile and print template
$tpl->render();

toc(); //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

//--------------------------------------------------------------------------------
function array_array_sum($a)
{
    $rVal = 0;
    
    foreach ($a as $a1) 
    {
        $b = array_sum($a1);
        $rVal = $rVal + $b;
    }

    return $rVal;
}

?>
