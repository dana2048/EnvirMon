
<!-- Monthly TEMPLATE -->

<?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');
?>


<!-- MONTH TEMPERATURE CHART -->
<h2>This Month's Average Daily Temperature</h2>

<?php
try {
$lineColor = array('red', 'green', 'blue', 'black', 'red', 'green', 'blue', 'black', 'red', 'green', 'blue', 'black', 'red', 'green', 'blue', 'black');
$chartFileName = 'chartMonthTemperature.png';

// Create the graph
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$graph->SetScale('textlin');
$graph->SetMargin(50,10,10,0);

// LEGEND
$graph->legend->SetPos(0.02, 0.08, 'right', 'bottom');
$graph->legend->SetShadow('gray@0.2',2);
$graph->legend->SetFont(FF_ARIAL, FS_NORMAL, 10);

// AXES
$graph->xaxis->SetTitle('Day Of Month', 'middle');
$graph->yaxis->SetTitle('Degrees Fahrenheit', 'middle');
$graph->yaxis->SetTitleMargin(30);

$numSensors = count($values['locationT']);
for($i=0; $i<$numSensors; $i++)
{ 
    // Create the linear plot
    $lineplot=new LinePlot($values['temperatureMonth'][$i]);
    $lineplot->SetLineWeight(4);
    $lineplot->SetColor($lineColor[$i]);
    $lineplot->SetStyle('solid');
    $lineplot->SetLegend($values['locationT'][$i]);

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


<!-- MONTH HUMIDITY CHART -->
<h2>This Month's Average Daily Humidity</h2>

<?php
try{
$chartFileName = 'chartHumidity.png';

// Create the graph
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$graph->SetScale('textlin');
$graph->SetMargin(50,10,10,0);

// LEGEND
$graph->legend->SetPos(0.02, 0.08, 'right', 'bottom');
$graph->legend->SetShadow('gray@0.2',2);
$graph->legend->SetFont(FF_ARIAL, FS_NORMAL, 10);

// AXES
$graph->xaxis->SetTitle('Day Of Month', 'middle');
$graph->yaxis->SetTitle('Percent', 'middle');
$graph->yaxis->SetTitleMargin(30);

$numSensors = count($values['humidityMonth']);
for($i=0; $i<$numSensors; $i++)
{ 
    // Create the linear plot
    $lineplot=new LinePlot($values['humidityMonth'][$i]);
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


<!-- MONTH PRESSURE CHART -->
<h2>This Month's Average Daily Pressure</h2>

<?php
try{
$chartFileName = 'chartPressure.png';

// Create the graph
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$graph->SetScale('textlin');
$graph->SetMargin(55,10,10,50);

// LEGEND
$graph->legend->SetPos(0.02, 0.08, 'right', 'bottom');
$graph->legend->SetShadow('gray@0.2',2);
$graph->legend->SetFont(FF_ARIAL, FS_NORMAL, 10);

// AXES
$graph->xaxis->SetTitle('Day Of Month', 'middle');
$graph->yaxis->SetTitle('Inches', 'middle');
$graph->yaxis->SetTitleMargin(45);

$numSensors = count($values['pressureMonth']);
for($i=0; $i<$numSensors; $i++)
{ 
    // Create the linear plot
    $lineplot=new LinePlot($values['pressureMonth'][$i]);
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
