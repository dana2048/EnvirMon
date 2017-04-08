
<?php
try {
// Database Access
include 'includes/data.php';

//gather some data
$sql = 'SELECT * FROM data limit 20';
$result = $db->query($sql);
$values = $result->fetch_array(MYSQL_ASSOC);


// template handler
include 'includes/template.php';

// create new instance of template handler for index template
$tpl = new Template('admin');

// pass $values variable to our template
$tpl->vars = array(
	'values' => $values
);

// compile and print template
$tpl->render();
} catch(Exception $e){}
?>