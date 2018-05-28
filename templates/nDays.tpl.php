
<!-- nDays TEMPLATE -->

<?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');
?>


<!-- YESTERDAY'S AVERAGE CONDITIONS --> 
<h3><?php echo number_format($values['nDays']); ?> Day Average Conditions</h3>
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
                $num = count($values['yesterdayTimes']);
		for($i=0; $i<$num; $i++)
		{
			echo('<tr>');
			echo('<td>' . $values['yesterdayTimes'][$i] . '</td>');
			echo('<td>' . $values['location'][$i] . '</td>');
			echo('<td>' . number_format(floatval($values['yesterdayTemps'][$i]),1) . '</td>');
			echo('<td>' . number_format(floatval($values['yesterdayHumids'][$i]),1) . '</td>');
			echo('</tr>');
		}
		?>
	</tbody>
</table>


<!-- TEMPERATURE CHART - HOURLY -->
<h3><?php echo number_format($values['nDays']); ?> Day Hourly Average Temperature</h3>

<?php
try{
$lineColor = array('red', 'green', 'blue', 'black', 'red', 'green', 'blue', 'black', 'red', 'green', 'blue', 'black', 'red', 'green', 'blue', 'black');
$chartFileName = 'chartTemperatureHourly.png';

$nDays = $values['nDays'];
$startTime = $values['startTime'];

$lTime = $startTime;
$numHours = $nDays*24;
for($i=0; $i<$numHours; $i++)
{
    $hr = $i%24; //x-axis labels 0..23 0..23 0..23
    if($hr == 0)
        $xL[] = date("ymd", $lTime); //at zero hour show YMD
    else
        $xL[] = $hr; //else show hour 1..23
    $lTime += 60*60; //seconds in one hour
}

// Create the graph
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$graph->SetScale('textlin');    //x-axis text, y-axis linear, auto range and scale
//$graph->SetScale('intlin',0,0,0,24); //typeXY, Ymin, Ymax, Xmin, Xmax
//$graph->SetScale('intlin',0,0,0,$numHours); //typeXY, Ymin, Ymax, Xmin, Xmax
$graph->xaxis->SetTickLabels($xL);
$graph->xaxis->SetTextTickInterval(12,0); //interval between ticks, starting tick
$graph->SetMargin(50,10,10,0);

// LEGEND
$graph->legend->SetPos(0.02, 0.08, 'right', 'bottom');
$graph->legend->SetShadow('gray@0.2',2);
$graph->legend->SetFont(FF_ARIAL, FS_NORMAL, 10);

// AXES
$graph->yaxis->SetTitleMargin(30);
//$graph->xaxis->scale->ticks->Set(24*60*60); //set major tick step one per day
//$graph->xaxis->HideTicks(true, false); //hide minor tick marks, don't hide major tick marks
$graph->xaxis->SetTitle('Time Of Day', 'middle');
$graph->yaxis->SetTitle('Degrees Fahrenheit', 'middle');

// GRID
$graph->xgrid->Show();

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
<h3><?php echo number_format($values['nDays']); ?> Day Hourly Average Humidity</h3>

<?php
try{
$chartFileName = 'chartHumidityHourly.png';

// Create the graph
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$graph->SetScale('textlin');    //x-axis text, y-axis linear, auto range and scale
$graph->xaxis->SetTickLabels($xL);
$graph->xaxis->SetTextTickInterval(12,0); //interval between ticks, starting tick
$graph->SetMargin(50,10,10,0);

// LEGEND
$graph->legend->SetPos(0.02, 0.08, 'right', 'bottom');
$graph->legend->SetShadow('gray@0.2',2);
$graph->legend->SetFont(FF_ARIAL, FS_NORMAL, 10);

// AXES
$graph->yaxis->SetTitleMargin(30);
$graph->xaxis->SetTitle('Time Of Day', 'middle');
$graph->yaxis->SetTitle('Percent', 'middle');

// GRID
$graph->xgrid->Show();

$numSensors = count($values['locationH']);
for($i=0; $i<$numSensors; $i++)
{ 
    //Create the linear plot
    $lineplot=new LinePlot($values['chartHumidity-hourly'][$i]);

    // Add the plot to the graph
    $graph->Add($lineplot);
    $lineplot->SetLineWeight(4);
    $lineplot->SetColor($lineColor[$i]);
    $lineplot->SetStyle('solid');
    $lineplot->SetLegend($values['locationH'][$i]);
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
<h3><?php echo number_format($values['nDays']); ?> Day Hourly Average Barometric Pressure</h3>

<?php
try{
$chartFileName = 'chartPressureHourly.png';

// Create the graph
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$graph->SetScale('textlin');    //x-axis text, y-axis linear, auto range and scale
$graph->xaxis->SetTickLabels($xL);
$graph->xaxis->SetTextTickInterval(12,0); //interval between ticks, starting tick
$graph->SetMargin(55,10,10,50);

// LEGEND
$graph->legend->SetPos(0.02, 0.08, 'right', 'bottom');
$graph->legend->SetShadow('gray@0.2',2);
$graph->legend->SetFont(FF_ARIAL, FS_NORMAL, 10);

// AXES
$graph->yaxis->SetTitleMargin(45);
$graph->xaxis->SetTitle('Time Of Day', 'middle');
$graph->yaxis->SetTitle('Inches (Hg)', 'middle');

// GRID
$graph->xgrid->Show();

$numSensors = count($values['locationP']);
for($i=0; $i<$numSensors; $i++)
{ 
    //Create the linear plot
    $lineplot=new LinePlot($values['chartPressure-hourly'][$i]);

    // Add the plot to the graph
    $graph->Add($lineplot);
    $lineplot->SetLineWeight(4);
    $lineplot->SetColor($lineColor[$i]);
    $lineplot->SetStyle('solid');
    $lineplot->SetLegend($values['locationP'][$i]);
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
