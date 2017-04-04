
<!-- Monthly TEMPLATE -->

<?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');



?>


<!-- MONTH TEMPERATURE CHART -->
<h2>This Month's Average Daily Temperature</h2>

<?php
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

// Create the linear plot -- INDOOR
$lineplot=new LinePlot($values['temperatureMonth-in']);
$lineplot->SetColor('red');
$lineplot->SetStyle('solid');
$lineplot->SetLegend('Indoor');

// Add the plot to the graph
$graph->Add($lineplot);

// Create the linear plot -- OUTDOOR
$lineplot=new LinePlot($values['temperatureMonth-out']);
$lineplot->SetColor('green');
$lineplot->SetStyle('solid');
$lineplot->SetLegend('Outdoor');

// Add the plot to the graph
$graph->Add($lineplot);

// Create the linear plot -- CRAWL
$lineplot=new LinePlot($values['temperatureMonth-crawl']);
$lineplot->SetColor('blue');
$lineplot->SetStyle('solid');
$lineplot->SetLegend('Crawl Space');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke($chartFileName);
echo '<img src="' . $chartFileName . '">';
?>


<!-- MONTH HUMIDITY CHART -->
<h2>This Month's Average Daily Humidity</h2>

<?php
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

// Create the linear plot -- INDOOR
$lineplot=new LinePlot($values['humidityMonth-in']);
$lineplot->SetColor('red');
$lineplot->SetStyle('solid');
$lineplot->SetLegend('Indoor');

// Add the plot to the graph
$graph->Add($lineplot);

// Create the linear plot -- OUTDOOR
$lineplot=new LinePlot($values['humidityMonth-out']);
$lineplot->SetColor('green');
$lineplot->SetStyle('solid');
$lineplot->SetLegend('Outdoor');

// Add the plot to the graph
$graph->Add($lineplot);

// Create the linear plot -- CRAWL
$lineplot=new LinePlot($values['humidityMonth-crawl']);
$lineplot->SetColor('blue');
$lineplot->SetStyle('solid');
$lineplot->SetLegend('Crawl Space');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke($chartFileName);
echo '<img src="' . $chartFileName . '">';
?>


<!-- MONTH PRESSURE CHART -->
<h2>This Month's Average Daily Pressure</h2>

<?php
$chartFileName = 'chartPressure.png';

// Create the graph
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$graph->SetScale('textlin');
$graph->SetMargin(55,10,10,50);

// AXES
$graph->xaxis->SetTitle('Day Of Month', 'middle');
$graph->yaxis->SetTitle('Inches', 'middle');
$graph->yaxis->SetTitleMargin(45);

// Create the linear plot
$lineplot=new LinePlot($values['pressureMonth']);
$lineplot->SetColor('green');
$lineplot->SetStyle('solid');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke($chartFileName);
echo '<img src="' . $chartFileName . '">';
?>

<!-- some blank space at the bottom -->
<br><br><br>
