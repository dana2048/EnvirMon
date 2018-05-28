
<!-- nDays_1 TEMPLATE -->

<?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');
?>


<!-- YESTERDAY'S AVERAGE CONDITIONS --> 
<h3><?php echo number_format($values['nDays']); ?> Day Average Conditions</h3>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Date</th>
			<th>Location</th>
			<th>Luminance</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
                $num = count($values['nDayTimes']);
		for($i=0; $i<$num; $i++)
		{
			echo('<tr>');
			echo('<td>' . $values['nDayTimes'][$i] . '</td>');
			echo('<td>' . $values['location'][$i] . '</td>');
			echo('<td>' . number_format(floatval($values['nDayAverage'][$i]),1) . '</td>');
			echo('</tr>');
		}
		?>
	</tbody>
</table>


<!-- CHART - HOURLY -->
<h3><?php echo number_format($values['nDays']); ?> Day Hourly Average</h3>

<?php
function Chart__($firstSensor, $numSensors, $valName, $locName)
{
    global $values;

try{
$lineColor = array('red', 'green', 'blue', 'black', 'red', 'green', 'blue', 'black', 'red', 'green', 'blue', 'black', 'red', 'green', 'blue', 'black');
$chartFileName = $valName . '.png';

$nDays = $values['nDays'];
$startTime = $values['startTime'];

$lTime = $startTime;
$numHours = $nDays*24;
for($i=0; $i<$numHours; $i++)
{
    $hr = $i%24; //x-axis labels 0..23 0..23 0..23
    if($hr == 0)
        $xL[] = date("ymd", $lTime); //at zero hour show YMD
    else
        $xL[] = $hr; //else show hour 1..23
    $lTime += 60*60; //seconds in one hour
}

// Create the graph
$graph = new Graph(1024,480,$chartFileName,100,$aInline=false);
$graph->SetScale('textlin');    //x-axis text, y-axis linear, auto range and scale
//$graph->SetScale('intlin',0,0,0,24); //typeXY, Ymin, Ymax, Xmin, Xmax
//$graph->SetScale('intlin',0,0,0,$numHours); //typeXY, Ymin, Ymax, Xmin, Xmax
$graph->xaxis->SetTickLabels($xL);
$graph->xaxis->SetTextTickInterval(12,0); //interval between ticks, starting tick
$graph->SetMargin(50,10,10,0);

// LEGEND
$graph->legend->SetPos(0.02, 0.10, 'right', 'bottom'); //0.08
$graph->legend->SetShadow('gray@0.2',2);
$graph->legend->SetFont(FF_ARIAL, FS_NORMAL, 10);

// AXES
$graph->yaxis->SetTitleMargin(30);
//$graph->xaxis->scale->ticks->Set(24*60*60); //set major tick step one per day
//$graph->xaxis->HideTicks(true, false); //hide minor tick marks, don't hide major tick marks
$graph->xaxis->SetTitle('Time Of Day', 'middle');
$graph->yaxis->SetTitle('Value', 'middle');

// GRID
$graph->xgrid->Show();

//$numSensors = count($values[$locName]);
//$numSensors = count($values[$valName]);
for($i=$firstSensor; $i<$numSensors; $i++)
{ 
    //Create the linear plot
    $lineplot=new LinePlot($values[$valName][$i]);

    // Add the plot to the graph
    $graph->Add($lineplot);
    $lineplot->SetLineWeight(4);
    $lineplot->SetColor($lineColor[$i]);
    $lineplot->SetStyle('solid');
    $lineplot->SetLegend($values[$locName][$i]);
}

// Display the graph
@unlink($chartFileName);
$graph->Stroke($chartFileName);
echo '<img src="' . $chartFileName . '">';
} 
catch(Exception $e){
    echo $e->getMessage();
}
} //function Chart__

Chart__(0,4,'chartLuminance-hourly','locationL');
Chart__(0,2,'chartLuminance1-hourly','locationL1');
?>


<!-- some blank space at the bottom -->
<br><br><br>
