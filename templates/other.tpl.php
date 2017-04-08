
<!-- Yesterday TEMPLATE -->

<?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');

?>


<!-- TEMPERATURE CHART X 4 -->
<h3>Yesterday's Temperature Chart x 4</h3>

<?php
try {
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
} catch(Exception $e){}
?>
