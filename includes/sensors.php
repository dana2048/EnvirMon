<?php

//provides $sensorT, $locationT, $sensorH, $locationH, $sensorP, $locationP, $sensorL, $locationL
//loads content from 'sensor' table in 'monitor' database

//Get array of temperature sensor numbers
$sql = "SELECT number FROM sensor WHERE LOCATE('T', type)";
$result = $db->query($sql);
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

//Get array of luminance sensor numbers
$sql = "SELECT number FROM sensor WHERE LOCATE('L', type) AND active=1";
$result = $db->query($sql);
while($row = $result->fetch_array(MYSQL_ASSOC))
{
    $sensorL[] = $row['number'];
}

//Get array of luminance sensor names
$sql = "SELECT name from sensor WHERE LOCATE('L', type) AND active=1";
$result = $db->query($sql);
while($row = $result->fetch_array(MYSQL_ASSOC))
{
    $locationL[] = $row['name'];
}

?>