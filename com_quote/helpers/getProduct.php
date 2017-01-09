<?php
require_once('local_server.php');

$productCode = $_POST['productCode'];
if(!empty($productCode))
{
// Select Product from Category
// ---------------------------------------------------------------


	$db = JFactory::getDBO();
	$query = $db->getQuery(true);	
	$query 	->select(array('a.product_id', 'b.price_value'))
			->from($db->quoteName('#__hikashop_product', 'a'))
			->join('INNER', $db->quoteName('#__hikashop_price', 'b') . ' ON (' . $db->quoteName('a.product_id') . ' = ' . $db->quoteName('b.price_product_id') . ')')
			->where($db->quoteName('a.product_id') . ' = ' . $db->quoteName('b.price_product_id') . 
	        " AND " . $db->quoteName('a.product_code') . ' = ' . $db->quote($productCode));
	$db->setQuery($query);
	$db->execute();
	
	$num_rows = $db->getNumRows();
	
	$row = $db->loadAssocList();
	
	//if row exists: get image get doc
	if($num_rows > 0) 
	{
		$product_id  = $row[0]['product_id'];
		$price_value = $row[0]['price_value'];
		


		$db = JFactory::getDBO();
		$query = $db->getQuery(true);	
		$query 	->select(array('a.product_id', 'b.file_path'))
				->from($db->quoteName('#__hikashop_product', 'a'))
				->join('INNER', $db->quoteName('#__hikashop_file', 'b') . ' ON (' . $db->quoteName('a.product_id') . ' = ' . $db->quoteName('b.file_ref_id') . ')')
				->where($db->quoteName('a.product_id') . ' = ' . $db->quoteName('b.file_ref_id') .
				" AND " . $db->quoteName('b.file_type') . ' = "product"' . //file
		        " AND " . $db->quoteName('a.product_id') . ' = ' . $db->quote($product_id) . 
				" AND " . $db->quoteName('b.file_ordering') . ' = 0');
		$db->setQuery($query);
		$db->execute();
		$num_rows = $db->getNumRows();
		$row = $db->loadAssocList();

		// Image for Product:
		// for ($i = 0; $i < $num_rows; $i++){
		// 	echo $row[$i]['product_id'];
		// 	echo $row[$i]['file_path'];
		// }
		if($num_rows > 0) {

			$file_path = $row[0]['file_path'];
			$productRow = array('product_id' => $product_id, 'price_value' => $price_value, 'file_path' => $file_path);
			$productRow = json_encode($productRow);
			echo $productRow;
		}
		else {
			$productRow = array('product_id' => $product_id, 'price_value' => $price_value);
			$productRow = json_encode($productRow);
			echo $productRow;
		}
		
	}
	else {

		$productRow = array();
		$productRow = json_encode($productRow);
		echo $productRow;
	}
	
	// Price for Product:
	// for ($i = 0; $i < $num_rows; $i++){
	// 	echo $row[$i]['product_id'];
	// 	echo $row[0]['price_value'];
	// }

}
?>