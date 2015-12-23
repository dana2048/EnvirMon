
<!-- INDEX TEMPLATE -->

<?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');

//echo 'USE_CACHE =';
//print_r(USE_CACHE);
//echo '<br>';

//echo 'CACHE_DIR =';
//print_r(CACHE_DIR);
//echo '<br>';

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


<!-- TEMPERATURE CHART -->
<h2>Yesterday's Temperature Chart</h2>

<?php
// Some data
//$ydata = array(11,3,8,12,5,1,9,13,5,7);
//$chartFileName = sys_get_temp_dir() . '\\' . 'chartTemperature.png';
$chartFileName = 'chartTemperature.png';

// Create the graph. These two calls are always required
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$graph->SetScale('textlin');

// SENSOR 1 - 
//Create the linear plot
$lineplot=new LinePlot($values['chartTemperature1']);
$lineplot->SetColor('darkgreen');
$lineplot->SetStyle('dashed');

// Add the plot to the graph
$graph->Add($lineplot);

// SENSOR 2 - 
//Create the linear plot
$lineplot=new LinePlot($values['chartTemperature2']);
$lineplot->SetColor('darkred');
$lineplot->SetStyle('dotted');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke($chartFileName);
//echo '<img src="' . $chartFileName . '">'
//echo '<img src=file:///' . $chartFileName . '>';
echo '<img src="' . $chartFileName . '">';
?>


<!-- PRESSURE CHART -->
<h2>This Month's Pressure Chart</h2>

<?php
$ydata = $values['chartPressure'];
//print_r($ydata);
$chartFileName = sys_get_temp_dir() . '\\' . 'chartPressure.png';
$chartFileName = 'chartPressure.png';

// Create the graph. These two calls are always required
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$graph->SetScale('textlin');

// Create the linear plot
$lineplot=new LinePlot($ydata);
$lineplot->SetColor('green');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke($chartFileName);
echo '<img src="' . $chartFileName . '">';
?>

<!-- MONTH TEMPERATURE CHART -->
<h2>This Month's Temperature Chart</h2>

<?php
$ydata = $values['chartMonthTemperature'];
//print_r($ydata);
$chartFileName = sys_get_temp_dir() . '\\' . 'chartMonthTemperature.png';
$chartFileName = 'chartMonthTemperature.png';

// Create the graph. These two calls are always required
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$graph->SetScale('textlin');

// Create the linear plot
$lineplot=new LinePlot($ydata);
$lineplot->SetColor('green');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke($chartFileName);
echo '<img src="' . $chartFileName . '">';
?>
