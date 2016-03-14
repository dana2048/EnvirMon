
<!-- INDEX TEMPLATE -->

<?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');

?>

<!-- CURRENT CONDITIONS -->
<h2>Current Conditions</h2>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Time</th>
			<th> </th>
			<th>Temperature</th>
			<th>Humidity</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?= $values['currentTimes'][0] ?></td>
			<td> </td>
			<td><?= number_format($values['currentTemps'][0],1) ?></td>
			<td><?= number_format($values['currentHumids'][0],1) ?></td>
		</tr>
		<tr>
			<td><?= $values['currentTimes'][1] ?></td>
			<td> </td>
			<td><?= number_format($values['currentTemps'][1],1) ?></td>
			<td><?= number_format($values['currentHumids'][1],1) ?></td>
		</tr>
		<tr>
			<td><?= $values['currentTimes'][2] ?></td>
			<td> </td>
			<td><?= number_format($values['currentTemps'][2],1) ?></td>
			<td><?= number_format($values['currentHumids'][2],1) ?></td>
		</tr>
		<tr>
			<td><?= $values['currentTimes'][3] ?></td>
			<td> </td>
			<td><?= number_format($values['currentTemps'][3],1) ?></td>
			<td><?= number_format($values['currentHumids'][3],1) ?></td>
		</tr>
	</tbody>
</table>

<!-- TEMPERATURE CHART - HOURLY -->
<h2>Hourly Average Temperature</h2>

<?php
$chartFileName = 'chartTemperatureHourly.png';

// Create the graph. These two calls are always required
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
//$graph->SetScale('textlin');
$graph->SetScale('intlin',0,0,0,23);
$graph->SetMargin(20,10,10,20);

//xData = hour values displayed on X axis
//Create the linear plot -- INDOOR
$lineplot=new LinePlot($values['chartTemperature1-hourly']);
$lineplot->SetColor('red');
$lineplot->SetStyle('solid');

// Add the plot to the graph
$graph->Add($lineplot);

//Create the linear plot -- OUTDOOR
$lineplot=new LinePlot($values['chartTemperature4-hourly']);
$lineplot->SetColor('green');
$lineplot->SetStyle('solid');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke($chartFileName);
echo '<img src="' . $chartFileName . '">';
?>


