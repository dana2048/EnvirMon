
<!-- Yesterday TEMPLATE -->

<?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');

function timeFormat($time)
{
	$rVal = date("m/d H:i", $time);
	return $rVal;
}
?>


<!-- YESTERDAY'S AVERAGE CONDITIONS -->
<h3>7-day Average Conditions</h3>
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
		//$i=0; //indoor
		for($i=0; $i<4; $i++)
		{
			echo('<tr>');
			echo('<td>' . $values['yesterdayTimes'][$i] . '</td>');
			echo('<td>' . $values['location'][$i] . '</td>');
			echo('<td>' . number_format($values['yesterdayTemps'][$i],1) . '</td>');
			echo('<td>' . number_format($values['yesterdayHumids'][$i],1) . '</td>');
			echo('</tr>');
			//$i=2; //outdoor
		}
		?>
	</tbody>
</table>


<!-- TEMPERATURE CHART - HOURLY -->
<h3>7-day Hourly Average Temperature</h3>

<?php
$chartFileName = 'chartTemperatureHourly.png';

$startTime = $values['temperatureIn-hourly']['time'][0];	//UNIX timestamp
$startTime = date("Y-m-d", $startTime);	//get just the date
$startTime = strtotime($startTime);	//back to UNIX timestamp at 00:00:00
$endTime = $values['temperatureIn-hourly']['time'][167];
$endTime = strtotime("+7 days", $startTime);	//seven days from startTime
//$endTime = date("Y-m-d", $endTime);
//PrintR('$startTime', $startTime);
//PrintR('$endTime', $endTime);

// Create the graph
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
//$graph->SetScale('intlin',0,0,0,168);	//////////////KONST::numSamples);
$graph->SetScale('intint',0,0,$startTime,$endTime);
$graph->SetMargin(50,10,10,0);

// LEGEND
$graph->legend->SetPos(0.02, 0.08, 'right', 'bottom');
$graph->legend->SetShadow('gray@0.2',2);
$graph->legend->SetFont(FF_ARIAL, FS_NORMAL, 10);

// AXES
$totalTime = $endTime - $startTime;	//number of seconds in 7 days
$totalTime = 7*24*60*60; 
$tickTime = $totalTime/7;	//tick every day
$tickTime = 24*60*60;
//PrintR('$totalTime', $totalTime);
//PrintR('$tickTime', $tickTime);
$graph->xaxis->scale->ticks->Set($tickTime); //set major tick step one per day
$graph->xaxis->HideTicks(true, false); //hide minor tick marks, don't hide major tick marks
$graph->xaxis->HideLastTickLabel(true);
//$graph->xaxis->SetTextLabelInterval(12);
$graph->xaxis->SetLabelFormatCallback('timeFormat');
$graph->xaxis->SetTitle('Date', 'middle');
$graph->yaxis->SetTitle('Degrees Fahrenheit', 'middle');
$graph->yaxis->SetTitleMargin(30);

// GRID
$graph->xgrid->Show();

//Create the linear plot -- INDOOR
$lineplot=new LinePlot($values['temperatureIn-hourly']['value'],$values['temperatureIn-hourly']['time']);
$lineplot->SetColor('red');
$lineplot->SetStyle('solid');
$lineplot->SetLegend('Indoor');
//PrintR('$lineplot->numpoints', $lineplot->numpoints);

// Add the plot to the graph
$graph->Add($lineplot);

//Create the linear plot -- OUTDOOR
$lineplot=new LinePlot($values['temperatureOut-hourly']['value'],$values['temperatureOut-hourly']['time']);
$lineplot->SetColor('green');
$lineplot->SetStyle('solid');
$lineplot->SetLegend('Outdoor');

// Add the plot to the graph
$graph->Add($lineplot);

//Create the linear plot -- CRAWL SPACE
$lineplot=new LinePlot($values['temperatureCrawl-hourly']['value'],$values['temperatureCrawl-hourly']['time']);
$lineplot->SetColor('blue');
$lineplot->SetStyle('solid');
$lineplot->SetLegend('Crawl Space');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke($chartFileName);
echo '<img src="' . $chartFileName . '">';
?>


<!-- HUMIDITY CHART - HOURLY -->
<h3>7-day Hourly Average Humidity</h3>

<?php
$chartFileName = 'chartHumidityHourly.png';

$startTime = $values['humidityIn-hourly']['time'][0];	//UNIX timestamp
$startTime = date("Y-m-d", $startTime);	//get just the date
$startTime = strtotime($startTime);	//back to UNIX timestamp at 00:00:00
$endTime = $values['humidityIn-hourly']['time'][167];
$endTime = strtotime("+7 days", $startTime);	//seven days from startTime
//$endTime = date("Y-m-d", $endTime);
//PrintR('$startTime', $startTime);
//PrintR('$endTime', $endTime);

// Create the graph
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$graph->SetScale('intint',0,0,$startTime,$endTime);
$graph->SetMargin(50,10,10,0);

// LEGEND
$graph->legend->SetPos(0.02, 0.08, 'right', 'bottom');
$graph->legend->SetShadow('gray@0.2',2);
$graph->legend->SetFont(FF_ARIAL, FS_NORMAL, 10);

// AXES
$totalTime = $endTime - $startTime;	//number of seconds in 7 days
$totalTime = 7*24*60*60; 
$tickTime = $totalTime/7;	//tick every day
$tickTime = 24*60*60;
//PrintR('$totalTime', $totalTime);
//PrintR('$tickTime', $tickTime);
$graph->xaxis->scale->ticks->Set($tickTime); //set major tick step one per day
$graph->xaxis->HideTicks(true, false); //hide minor tick marks, don't hide major tick marks
$graph->xaxis->HideLastTickLabel(true);
//$graph->xaxis->SetTextLabelInterval(12);
$graph->xaxis->SetLabelFormatCallback('timeFormat');
$graph->xaxis->SetTitle('Time Of Day', 'middle');
$graph->yaxis->SetTitle('Percent', 'middle');
$graph->yaxis->SetTitleMargin(30);

// GRID
$graph->xgrid->Show();

//Create the linear plot -- INDOOR
$lineplot=new LinePlot($values['humidityIn-hourly']['value'],$values['humidityIn-hourly']['time']);
$lineplot->SetColor('red');
$lineplot->SetStyle('solid');
$lineplot->SetLegend('Indoor');

// Add the plot to the graph
$graph->Add($lineplot);

//Create the linear plot -- OUTDOOR
$lineplot=new LinePlot($values['humidityOut-hourly']['value'],$values['humidityOut-hourly']['time']);
$lineplot->SetColor('green');
$lineplot->SetStyle('solid');
$lineplot->SetLegend('Outdoor');

// Add the plot to the graph
$graph->Add($lineplot);

//Create the linear plot -- CRAWL SPACE
$lineplot=new LinePlot($values['humidityCrawl-hourly']['value'],$values['humidityCrawl-hourly']['time']);
$lineplot->SetColor('blue');
$lineplot->SetStyle('solid');
$lineplot->SetLegend('Crawl Space');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke($chartFileName);
echo '<img src="' . $chartFileName . '">';
?>


<!-- PRESSURE CHART - HOURLY -->
<h3>7-day Hourly Average Pressure</h3>

<?php
$chartFileName = 'chartPressureHourly.png';

$startTime = $values['pressure-hourly']['time'][0];	//UNIX timestamp
$startTime = date("Y-m-d", $startTime);	//get just the date
$startTime = strtotime($startTime);	//back to UNIX timestamp at 00:00:00
$endTime = $values['pressure-hourly']['time'][167];
$endTime = strtotime("+7 days", $startTime);	//seven days from startTime
// Create the graph
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$yMin = min($values['pressure-hourly']['value']);
$yMax = max($values['pressure-hourly']['value']);
PrintR('$yMax',$yMax);
$yMin = intval($yMin/0.25) * 0.25; //nearest 0.25 inches
$yMax = intval($yMax/0.25) * 0.25 + 0.25; //nearest 0.25 inches
$graph->SetScale('linint',$yMin,$yMax,$startTime,$endTime);
$graph->SetMargin(55,10,10,50);

// AXES
$totalTime = $endTime - $startTime;	//number of seconds in 7 days
$totalTime = 7*24*60*60; 
$tickTime = $totalTime/7;	//tick every day
$tickTime = 24*60*60;
//PrintR('$totalTime', $totalTime);
//PrintR('$tickTime', $tickTime);
$graph->xaxis->scale->ticks->Set($tickTime); //set major tick step one per day
$graph->xaxis->HideTicks(true, false); //hide minor tick marks, don't hide major tick marks
$graph->xaxis->HideLastTickLabel(true);
//$graph->xaxis->SetTextLabelInterval(12);
$graph->xaxis->SetLabelFormatCallback('timeFormat');
$graph->xaxis->SetTitle('Time Of Day', 'middle');

$graph->yaxis->scale->ticks->Set(0.1); // Set major and minor tick
$graph->yaxis->SetTitle('Inches', 'middle');
$graph->yaxis->SetTitleMargin(45);

// GRID
$graph->xgrid->Show();

//Create the linear plot -- PRESSURE
$lineplot=new LinePlot($values['pressure-hourly']['value'],$values['pressure-hourly']['time']);
$lineplot->SetColor('red');
$lineplot->SetStyle('solid');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke($chartFileName);
echo '<img src="' . $chartFileName . '">';
?>

<!-- some blank space at the bottom -->
<br><br><br>
