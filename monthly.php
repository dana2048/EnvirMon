
<!--- EnviroMon Index Page --->

<?php

require 'includes/db.php';	//database access
require 'includes/template.php';	//template handler

//echo '$_SERVER[TMP]=' . $_SERVER['TMP'] . '<br>';
//echo 'sys_get_temp_dir =' . sys_get_temp_dir() . '<br>';;

$timeVal  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
$yesterday = date("Y-m-d", $timeVal);
$thisMonth = date("m", $timeVal);
$thisYear = date("Y", $timeVal);


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

?>
