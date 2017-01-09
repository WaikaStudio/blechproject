<?php 
require_once('local_server.php');

	$productCode = $_POST['productCode'];

	$db = JFactory::getDBO();
	
	$query = $db->getQuery(true);	
	$query 	->select(array('a.product_id', 'b.price_value'))
			->from($db->quoteName('#__hikashop_product', 'a'))
			->join('INNER', $db->quoteName('#__hikashop_category', 'b') . ' ON (' . $db->quoteName('a.product_id') . ' = ' . $db->quoteName('b.price_product_id') . ')')
			->where($db->quoteName('a.product_id') . ' = ' . $db->quoteName('b.price_product_id') . 
	        " AND " . $db->quoteName('a.product_code') . ' = ' . $db->quote($productCode));
	$db->setQuery($query);
	$db->execute();
	
	$num_rows = $db->getNumRows();
	
	$row = $db->loadAssocList();

 ?>