<?php

/**
CRUD
Admin Page For Data Table
*/

// start session handler
session_start();

// connect to the database
require '../includes/db.php';

// include template library
require '../includes/template.php';

// if no action variable was set in the URL, use null
$action = isset($_GET['action']) ? $_GET['action'] : null;

// C-REATE
//--------------------------------------------------------------------------------
if ( $action == 'create' ) {
	// TODO: validate input

	// create a new product
	$sql = 'INSERT INTO products (name, price) VALUES ("' . $db->escape_string($_POST['product']['name']) . '", ' . (float)$_POST['product']['price'] . ')';
	$result = $db->query($sql);

	// if it worked, store a success message in the session and redirect to the show page
	if ( $result ) {
		$_SESSION['message'] = 'Product created successfully';
		header('Location: products.php?action=show&id=' . $db->insert_id);
		exit;
	}
	else {
		echo "Something went wrong!";
		die;
	}

}
// print new product form
else if ( $action == 'new' ) {
	$tpl = new Template('admin/products/new');
	$tpl->layout = 'admin';
	$tpl->render();
}

// R-EAD
//--------------------------------------------------------------------------------
else if ( $action == 'show' ) 
{
	$page_title = "Show Data";
	$today = date("Y-m-d");
	//echo "admin/index.php?show- " . '$today' . " =  " . $today;

	//gather some data
	//$sql = 'SELECT * FROM data where stamp > '2015-11-23 12:00:00'';
	$sql = "SELECT * FROM data where stamp > '" . $today . " 12:00:00'";
	//echo "admin/index.php?show- " . '$sql' . " =  " . $sql;
	$result = $db->query($sql);

	$values = array();

	while ( $row = $result->fetch_array(MYSQL_ASSOC) ) 
	{
		$values[] = $row;
	}

/*
	echo "admin/index.php?show- " . '$values' . "= <br>";
	print_r($values);
	echo "<br><br>";
*/
	//print show template
	$tpl = new Template('admin/data/show');
	$tpl->layout = 'admin';
	$tpl->vars = array
	(
		'values' => $values,
		'page_title' => $page_title
	);
	$tpl->render();
}

// print edit form
//--------------------------------------------------------------------------------
else if ( $action == 'edit' ) {
	// fetch product from database
	$sql = 'SELECT * FROM products WHERE id = ' . (int)$_GET['id'];
	$result = $db->query($sql);
	$product = $result->fetch_array(MYSQL_ASSOC);

	// print template
	$tpl = new Template('admin/products/edit');
	$tpl->layout = 'admin';
	$tpl->vars = array(
		'product' => $product
	);
	$tpl->render();
}
// U-PDATE
//--------------------------------------------------------------------------------
else if ( $action == 'update' ) {
	// TODO: validate data

	// update an existing product
	$sql = 'UPDATE products SET name = "' . $db->escape_string($_POST['product']['name']) . '", price = ' . (float)$_POST['product']['price'] . ' WHERE id = ' . (int)$_GET['id'];
	$result = $db->query($sql);

	// if the query was successful, process uploaded file
	if ( $result ) {
		// continue if the file was uploaded correctly
		if ( is_uploaded_file($_FILES['product_image']['tmp_name']) ) {
			// build path to save new image to
			$upload_dir = '../images/';
			$path = $upload_dir . $_FILES['product_image']['name'];

			// move image to permanent location on disk
			// continue if that all goes correctly
			if ( move_uploaded_file($_FILES['product_image']['tmp_name'], $path) ) {
				// update product record with web-accessable path to image
				$image = 'images/' . $_FILES['product_image']['name'];
				$sql = 'UPDATE products SET image = "' . $db->escape_string($image) . '" WHERE id = ' . (int)$_GET['id'];
				$db->query($sql);
			}
		}

		// store success message in session and redirect to show page
		$_SESSION['message'] = 'Product updated successfully';
		header('Location: products.php?action=show&id=' . $_GET['id']);
		exit;
	}
	else {
		echo "Something went wrong!";
		die;
	}
}
// D-ELETE
//--------------------------------------------------------------------------------
else if ( $action == 'delete' ) {
	// delete a product
	$sql = 'DELETE FROM products WHERE id = ' . (int)$_GET['id'];
	$result = $db->query($sql);

	// if that worked, store a message in the session and redirect to index
	if ( $result ) {
		$_SESSION['message'] = 'Product deleted successfully';
		header('Location: products.php');
		exit;
	}
	else {
		echo "Something went wrong!";
		die;
	}
}
// Index (also R-EAD)
//--------------------------------------------------------------------------------
else {
	echo "No Action Specified";
}

?>