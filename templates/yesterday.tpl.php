
<!-- Yesterday TEMPLATE -->

<?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');

?>


<!-- YESTERDAY'S AVERAGE CONDITIONS -->
<h2>Yesterday's Average Conditions</h2>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Date</th>
			<th></th>
			<th>Temperature</th>
			<th>Humidity</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?= $values['yesterdayDate'] ?></td>
			<td></td>
			<td><?= number_format($values['yesterdayTemp'],1) ?></td>
			<td><?= number_format($values['yesterdayHumid'],1) ?></td>
		</tr>
	</tbody>
</table>


<!-- TEMPERATURE CHART - HOURLY -->
<h2>Yesterday's Temperature Chart</h2>

<?php
$chartFileName = 'chartTemperatureHourly.png';

// Create the graph. These two calls are always required
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$graph->SetScale('intlin',0,0,0,23);
$graph->SetMargin(30,10,10,20);

//Create the linear plot
$lineplot=new LinePlot($values['chartTemperature1-hourly']);
$lineplot->SetColor('darkgreen');
$lineplot->SetStyle('solid');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke($chartFileName);
echo '<img src="' . $chartFileName . '">';
?>


<!-- TEMPERATURE CHART X 4 -->
<h2>Yesterday's Temperature Chart x 4</h2>

<?php
$chartFileName = 'chartTemperature4.png';

// Create the graph. These two calls are always required
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$graph->SetScale('intlin',0,0,0,0);
$graph->SetMargin(30,10,10,20);

$t4 = $values['chartTemperature4'];

for($i=0; $i<4; $i++)
{
	//Create the linear plot
	$lineplot=new LinePlot($t4[$i]);
	$lineplot->SetColor('darkgreen');
	$lineplot->SetStyle('dashed');

	// Add the plot to the graph
	$graph->Add($lineplot);
}

// Display the graph
$graph->Stroke($chartFileName);
echo '<img src="' . $chartFileName . '">';
?>
