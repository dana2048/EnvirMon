
<?php

// Database Access
include 'includes/data.php';

//gather some data
$sql = 'SELECT * FROM data limit 2';
$result = $db->query($sql);

// loop through results and print debug data
/*while ( $row = $result->fetch_array(MYSQL_ASSOC) ) {
	echo '<pre>';
	print_r($row);
	echo '</pre>';
	echo '<hr>';
} */

$values = $result->fetch_array(MYSQL_ASSOC);


// template handler
include 'includes/template.php';

// create new instance of template handler for index template
$tpl = new Template('index');

// pass $shirts variable to our template
$tpl->vars = array(
	'values' => $values
);

// compile and print template
$tpl->render();

?>