<?php
	require_once('local_server.php');

// Insert New Quote
	$db = JFactory::getDBO();
	$query = $db->getQuery(true);	
	$query
		->select('idpart')
		->from($db->quoteName('#__quote_head'));
	$query->where($db->quoteName('id') . '=1');
	$db->setQuery($query);
	$db->execute();
	$num_rows = $db->getNumRows();
	$catid = $db->loadAssocList();
	$catid = $catid[0]['idpart'];

	$db 	= JFactory::getDBO();

	//Data
	$uid 		= $_POST['id'];			//user id
	$date 		= date("Y-m-d H:i:s");	//date
	$datosForm 	= $_POST['datos'];		//form data

// Insert Quote Control #__quote_control
	$query 	= $db->getQuery(true);

	//id nro quote
	//uid user id
	//brandid identifier of brand
	// created date quote	
	$columns= array('id','uid','created', 'catid');
	$values = array( 0,
					 $db->quote($uid),
					 $db->quote($date),
					 $db->quote($catid)
					);
	$query
		->insert($db->quoteName('#__quote_ctrl'))
		->columns($db->quoteName($columns))
		->values(implode(',', $values)); 
	$db->setQuery($query);
	$db->execute();

	$quoteid = $db->insertid();	//last id of quote table

// Insert Quote Items #__quote_item

	$datosForm = array_filter($datosForm); //filter of data

	foreach ($datosForm as $v1) {

		insertItem($v1, $quoteid);   	
	}

	function insertItem($arr, $quoteid) {

		$db 	= JFactory::getDBO();
		$query 	= $db->getQuery(true);
		$columns= array('id','quote', 'brand', 'pserial','quantity', 'productid', 'price');

		$values = array( 0,
					 	 $db->quote($quoteid),
					 	 $db->quote($arr[6]),
						 $db->quote($arr[1]),
						 $db->quote($arr[2]),
						 $db->quote($arr[3]),
						 $db->quote($arr[4])
					);
		$query
			->insert($db->quoteName('#__quote_item'))
			->columns($db->quoteName($columns))
			->values(implode(',', $values)); 
		$db->setQuery($query);
		$db->execute();
	    
	}

	$db = JFactory::getDBO();
	$query = $db->getQuery(true);	
	$query
		->select('mess_submit')
		->from($db->quoteName('#__quote_head'));
	$query->where($db->quoteName('id') . '=1');
	

	$mess_submit = $db->setQuery($query)->loadRow();
	
	$message = array('mess_submit' => $mess_submit, 'quoteid' => $quoteid);
	$message = json_encode($message);
	echo $message;

?>