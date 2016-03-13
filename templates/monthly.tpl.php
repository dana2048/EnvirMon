
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

//echo 'values =';
//print_r($values);
//echo '<br>';

?>


<!-- MONTH PRESSURE CHART -->
<h2>This Month's Pressure Chart</h2>

<?php
$ydata = $values['chartPressure'];
//print_r($ydata);
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


<!-- MONTH HUMIDITY CHART -->
<h2>This Month's Humidity Chart</h2>

<?php
$ydata = $values['chartHumidity'];
//print_r($ydata);
$chartFileName = 'chartHumidity.png';

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
