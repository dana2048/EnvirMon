
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
			<th>Temperature</th>
			<th>Humidity</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?= $values['timeStamp'] ?></td>
			<td><?= number_format($values['currentTemp'],1) ?></td>
			<td><?= number_format($values['currentHumid'],1) ?></td>
		</tr>
	</tbody>
</table>

<!-- YESTERDAY'S AVERAGE CONDITIONS -->
<h2>Yesterday's Average Conditions</h2>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Date</th>
			<th>Temperature</th>
			<th>Humidity</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?= $values['yesterdayDate'] ?></td>
			<td><?= number_format($values['yesterdayTemp'],1) ?></td>
			<td><?= number_format($values['yesterdayHumid'],1) ?></td>
		</tr>
	</tbody>
</table>


<!-- CHART -->
<h2>CHART</h2>


<?php
// Some data
//$ydata = array(11,3,8,12,5,1,9,13,5,7);
$ydata = $values['chart'];

// Create the graph. These two calls are always required
$graph = new Graph(1024,480,$aInline=false);
$graph->SetScale('textlin');

// Create the linear plot
$lineplot=new LinePlot($ydata);
$lineplot->SetColor('green');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke('auto');
?>

<img src="Index.png">
