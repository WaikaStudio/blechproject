<?php 
require_once('local_server.php');

$productCode = $_POST['productCode'];
if(!empty($productCode))
{
// Select Image for product
// ---------------------------------------------------------------
//----
// Ruta de imagenes: uemapa/media/com_hikashop/upload/safe
$db = JFactory::getDBO();
	$query = $db->getQuery(true);	
	$query 	->select('product_id')
			->from($db->quoteName('#__hikashop_product'))
			->where($db->quoteName('product_code') . ' = ' . $db->quote($productCode));
	$db->setQuery($query);
	$db->execute();
	$num_rows = $db->getNumRows();
	$ro = $db->loadAssocList();
//
	$db = JFactory::getDBO();
	$query = $db->getQuery(true);	
	$query 	->select(array('a.product_id', 'b.file_path'))
			->from($db->quoteName('#__hikashop_product', 'a'))
			->join('INNER', $db->quoteName('#__hikashop_file', 'b') . ' ON (' . $db->quoteName('a.product_id') . ' = ' . $db->quoteName('b.file_ref_id') . ')')
			->where($db->quoteName('a.product_id') . ' = ' . $db->quoteName('b.file_ref_id') . 
	        " AND " . $db->quoteName('b.file_type') . ' = "file"' .
			" AND " . $db->quoteName('a.product_id') . ' = ' . $db->quote($ro[0]['product_id'])  . 
			" AND " . $db->quoteName('b.file_ordering') . ' = 0');
			//7M4204
	$db->setQuery($query);
	$db->execute();
	$num_rows = $db->getNumRows();
	$row = $db->loadAssocList();
// Document for Product:

	if($num_rows > 0) {

		$file_path = $row[0]['file_path'];
		$productRow = array('file_path' => $file_path);
		$productRow = json_encode($productRow);
		echo $productRow;
	}
	else {

		$productRow = array();
		$productRow = json_encode($productRow);
		echo $productRow;
	}
}
?>