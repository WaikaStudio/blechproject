<?php
// Select Manufacturer from Category HKS Component: parent_id = 10
// ---------------------------------------------------------------
require_once('local_server.php');


	$db = JFactory::getDBO();
	$query = $db->getQuery(true);	
	$query
		->select('idbrand')
		->from($db->quoteName('#__quote_head'));
	$query->where($db->quoteName('id') . '= 1');
	$db->setQuery($query);
	$db->execute();
	$num_rows = $db->getNumRows();
	$ro = $db->loadAssocList();

	$parent_id = $ro[0]['idbrand'];
	
	$db = JFactory::getDBO();
	$query = $db->getQuery(true);	
	$query
		->select('*')
		->from($db->quoteName('#__hikashop_category'));
	$query->where($db->quoteName('category_parent_id') . '=' . $db->quote($parent_id));
	$db->setQuery($query);
	$db->execute();
	$num_rows = $db->getNumRows();
	$row = $db->loadAssocList();
	//echo "Manufacturer";
// Records for Manufacturer:
	for ($i = 0; $i < $num_rows; $i++){
		echo '<option data-brandid="'. $row[$i]['category_id'] .'" data-brandname="'. $row[$i]['category_name'] .'">' . $row[$i]['category_name'] . '</option>';
	}

?>