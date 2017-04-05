
<!-- Yesterday TEMPLATE -->

<?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');

?>


<!-- YESTERDAY'S AVERAGE CONDITIONS -->
<h3>Yesterday's Average Conditions</h3>
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
<h3>Yesterday's Hourly Average Temperature</h3>

<?php
$chartFileName = 'chartTemperatureHourly.png';

// Create the graph
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$graph->SetScale('intlin',0,0,0,24);
$graph->SetMargin(50,10,10,0);

// LEGEND
$graph->legend->SetPos(0.02, 0.08, 'right', 'bottom');
$graph->legend->SetShadow('gray@0.2',2);
$graph->legend->SetFont(FF_ARIAL, FS_NORMAL, 10);

// AXES
$graph->xaxis->SetTitle('Time Of Day', 'middle');
$graph->yaxis->SetTitle('Degrees Fahrenheit', 'middle');
$graph->yaxis->SetTitleMargin(30);

//Create the linear plot -- INDOOR
$lineplot=new LinePlot($values['chartTemperatureIn-hourly']);
$lineplot->SetColor('red');
$lineplot->SetStyle('solid');
$lineplot->SetLegend('Indoor');

// Add the plot to the graph
$graph->Add($lineplot);

//Create the linear plot -- OUTDOOR
$lineplot=new LinePlot($values['chartTemperatureOut-hourly']);
$lineplot->SetColor('green');
$lineplot->SetStyle('solid');
$lineplot->SetLegend('Outdoor');

// Add the plot to the graph
$graph->Add($lineplot);

//Create the linear plot -- CRAWL SPACE
$lineplot=new LinePlot($values['chartTemperatureCrawl-hourly']);
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
<h3>Yesterday's Hourly Average Humidity</h3>

<?php
$chartFileName = 'chartHumidityHourly.png';

// Create the graph
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$graph->SetScale('intlin',0,0,0,24);
$graph->SetMargin(50,10,10,0);

// LEGEND
$graph->legend->SetPos(0.02, 0.08, 'right', 'bottom');
$graph->legend->SetShadow('gray@0.2',2);
$graph->legend->SetFont(FF_ARIAL, FS_NORMAL, 10);

// AXES
$graph->xaxis->SetTitle('Time Of Day', 'middle');
$graph->yaxis->SetTitle('Percent', 'middle');
$graph->yaxis->SetTitleMargin(30);

//Create the linear plot -- INDOOR
$lineplot=new LinePlot($values['chartHumidityIn-hourly']);
$lineplot->SetColor('red');
$lineplot->SetStyle('solid');
$lineplot->SetLegend('Indoor');

// Add the plot to the graph
$graph->Add($lineplot);

//Create the linear plot -- OUTDOOR
$lineplot=new LinePlot($values['chartHumidityOut-hourly']);
$lineplot->SetColor('green');
$lineplot->SetStyle('solid');
$lineplot->SetLegend('Outdoor');

// Add the plot to the graph
$graph->Add($lineplot);

//Create the linear plot -- CRAWL SPACE
$lineplot=new LinePlot($values['chartHumidityCrawl-hourly']);
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
<h3>Yesterday's Hourly Average Pressure</h3>

<?php
$chartFileName = 'chartPressureHourly.png';

// Create the graph
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$graph->SetScale('intlin',0,0,0,24);
$graph->SetMargin(55,10,10,50);

// AXES
$graph->xaxis->SetTitle('Time Of Day', 'middle');
$graph->yaxis->SetTitle('Inches', 'middle');
$graph->yaxis->SetTitleMargin(45);

//Create the linear plot -- INDOOR
$lineplot=new LinePlot($values['chartPressure-hourly']);
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
