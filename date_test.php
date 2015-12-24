
<!--- Date Testing --->

<?php

require 'includes/db.php';	//database access

$today = date("Y-m-d");
$timeVal  = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));	//now minus 1 day
$yesterday = date("Y-m-d", $timeVal);
$thisMonth = date("m", $timeVal);
$thisYear = date("Y", $timeVal);

echo '<pre>';
echo '$yesterday = ';
print_r($yesterday); echo "<br>";
echo '</pre><hr>';


$sql = 
"SELECT AVG(temperature) AS yesterdayTemp, AVG(humidity) AS yesterdayHumid " .
"FROM data WHERE sensor=1 AND DATE(stamp)='" . $yesterday . "'";

$result = $db->query($sql);
$value = $result->fetch_array(MYSQL_ASSOC);

$values['yesterdayDate'] = $yesterday;
$values['yesterdayTemp'] = $value['yesterdayTemp'];
$values['yesterdayHumid'] = $value['yesterdayHumid'];

echo '<pre>';
echo '$value[\'yesterdayTemp\'] = ';
print_r($value['yesterdayTemp']); echo "<br>";
echo '</pre><hr>';

/*----------
$date = new DateTime($yesterday);
print_r($date->format('Y-m-d H:i:s')); echo "<br>";

$date1 = new DateTime();
print_r($date1->format('Y-m-d H:i:s')); echo "<br>";

$dateString = $date1->format('Y-m-d') . ' 00:00:00';
print_r($dateString); echo "<br>";

$date = DateTime::CreateFromFormat('Y-m-d H:i:s', $date1->format('Y-m-d') . ' 00:00:00');
print_r($date->format('Y-m-d H:i:s')); echo "<br>";
----------*/

$date = DateTime::CreateFromFormat('Y-m-d|', (new DateTime())->format('Y-m-d'));
print_r($date->format('Y-m-d H:i:s')); echo "<br>";

$date2 = $date->sub(new DateInterval('P1D'));
print_r($date2->format('Y-m-d H:i:s')); echo "<br>";

$hour = new DateInterval('PT1H');
print_r($hour->format('%Y-%M-%D %H:%I:%S')); echo "<br>";

echo '<pre>';
$temperature = array();
for($i=0; $i<24; $i++)
{
	print_r($date->format('Y-m-d H:i:s')); echo "<br>";

	$sql =
		"SELECT AVG(temperature) AS avgTemp " .
		"FROM data WHERE sensor=1 AND date(stamp) ='" . $yesterday . "' AND hour(stamp) ='" . $i . "'";

	$result = $db->query($sql);
	$value = $result->fetch_array(MYSQL_ASSOC);

	$avgTemp = $value['avgTemp'];
	$temperature[] = $avgTemp;
	print_r($temperature); echo "<br>";

	$date->add($hour);
}
echo '</pre><hr>';


?>