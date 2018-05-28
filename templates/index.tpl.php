
<!-- Today TEMPLATE -->

<?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');
?>


<!-- CURRENT CONDITIONS -->
<h3>Current Conditions</h3>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Date</th>
			<th>Location</th>
			<th>Temperature</th>
			<th>Humidity</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
                $num = count($values['currentTimes']);
		for($i=0; $i<$num; $i++)
		{
			echo('<tr>');
			echo('<td>' . $values['currentTimes'][$i] . '</td>');
			echo('<td>' . $values['location'][$i] . '</td>');
			echo('<td>' . number_format(floatval($values['currentTemps'][$i]),1) . '</td>');
			echo('<td>' . number_format(floatval($values['currentHumids'][$i]),1) . '</td>');
			echo('</tr>');
		}
		?>
	</tbody>
</table>


<!-- TEMPERATURE CHART - HOURLY -->
<h3>Today's Hourly Average Temperature</h3>

<?php
try {
$lineColor = array('red', 'green', 'blue', 'black', 'red', 'green', 'blue', 'black', 'red', 'green', 'blue', 'black', 'red', 'green', 'blue', 'black');
$chartFileName = 'chartTemperatureHourly.png';

// Create the graph
$graph = new Graph(1023,480,$chartFileName,100,$aInline=false);
$graph->SetScale('intlin',0,0,0,23);
$graph->SetMargin(50,10,10,0);

// LEGEND
$graph->legend->SetPos(0.02, 0.08, 'right', 'bottom');
$graph->legend->SetShadow('gray@0.2',2);
$graph->legend->SetFont(FF_ARIAL, FS_NORMAL, 10);

// AXES
$graph->xaxis->SetTitle('Time Of Day', 'middle');
$graph->yaxis->SetTitle('Degrees Fahrenheit', 'middle');
$graph->yaxis->SetTitleMargin(30);

$numSensors = count($values['locationT']);
for($i=0; $i<$numSensors; $i++)
{ 
    //Create the linear plot
    $lineplot=new LinePlot($values['chartTemperature-hourly'][$i]);

    // Add the plot to the graph
    $graph->Add($lineplot);
    $lineplot->SetLineWeight(4);
    $lineplot->SetColor($lineColor[$i]);
    $lineplot->SetStyle('solid');
    $lineplot->SetLegend($values['locationT'][$i]);
}

// Display the graph
@unlink($chartFileName);
$graph->Stroke($chartFileName);
echo '<img src="' . $chartFileName . '">';
} 
catch(Exception $e){
    echo $e->getMessage();
}
?>


<!-- HUMIDITY CHART - HOURLY -->
<h3>Today's Hourly Average Humidity</h3>

<?php
try {
$chartFileName = 'chartHumidityHourly.png';

// Create the graph
$graph = new Graph(1023,480,$chartFileName,100,$aInline=false);
$graph->SetScale('intlin',0,0,0,23);
$graph->SetMargin(50,10,10,0);

// LEGEND
$graph->legend->SetPos(0.02, 0.08, 'right', 'bottom');
$graph->legend->SetShadow('gray@0.2',2);
$graph->legend->SetFont(FF_ARIAL, FS_NORMAL, 10);

// AXES
$graph->xaxis->SetTitle('Time Of Day', 'middle');
$graph->yaxis->SetTitle('Percent', 'middle');
$graph->yaxis->SetTitleMargin(30);

$numSensors = count($values['chartHumidity-hourly']);
for($i=0; $i<$numSensors; $i++)
{ 
    //Create the linear plot
    $lineplot=new LinePlot($values['chartHumidity-hourly'][$i]);
    $lineplot->SetLineWeight(4);
    $lineplot->SetColor($lineColor[$i]);
    $lineplot->SetStyle('solid');
    $lineplot->SetLegend($values['locationH'][$i]);

    // Add the plot to the graph
    $graph->Add($lineplot);
}

// Display the graph
@unlink($chartFileName);
$graph->Stroke($chartFileName);
echo '<img src="' . $chartFileName . '">';
} 
catch(Exception $e){
    echo $e->getMessage();
}
?>


<!-- PRESSURE CHART - HOURLY -->
<h3>Today's Hourly Average Barometric Pressure</h3>

<?php
try {
if (array_array_sum($values['chartPressure-hourly']) < 1) 
{
    throw(new Exception($message="No Pressure Data"));
}
    
$chartFileName = 'chartPressureHourly.png';

// Create the graph
$graph = new Graph(1023,480,$chartFileName,100,$aInline=false);
$graph->SetScale('intlin',0,0,0,23);
$graph->SetMargin(55,10,10,50);

// LEGEND
$graph->legend->SetPos(0.02, 0.08, 'right', 'bottom');
$graph->legend->SetShadow('gray@0.2',2);
$graph->legend->SetFont(FF_ARIAL, FS_NORMAL, 10);

// AXES
$graph->xaxis->SetTitle('Time Of Day', 'middle');
$graph->yaxis->SetTitle('Inches', 'middle');
$graph->yaxis->SetTitleMargin(45);

$numSensors = count($values['chartPressure-hourly']);
for($i=0; $i<$numSensors; $i++)
{ 
    //Create the linear plot
    $lineplot=new LinePlot($values['chartPressure-hourly'][$i]);
    $lineplot->SetLineWeight(4);
    $lineplot->SetColor($lineColor[$i]);
    $lineplot->SetStyle('solid');
    $lineplot->SetLegend($values['locationP'][$i]);

    // Add the plot to the graph
    $graph->Add($lineplot);
}

// Display the graph
@unlink($chartFileName);
$graph->Stroke($chartFileName);
echo '<img src="' . $chartFileName . '">';
} 
catch(Exception $e){
    echo $e->getMessage();
}
?>

<!-- some blank space at the bottom -->
<br><br><br>
