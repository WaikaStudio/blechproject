<?php
require_once('local_server.php');

	$db = JFactory::getDBO();

	//Get Quotes of User
	
	$query = $db->getQuery(true);	
	$query 	->select('*')
			->from($db->quoteName('#__quote_ctrl'))
			->where($db->quoteName('uid') . ' = ' . $db->quote($_POST['id']))
			->order('id DESC');
	$db->setQuery($query);
	$db->execute();
	
	$num_rows = $db->getNumRows();
	$row = $db->loadAssocList();

	if($num_rows > 0) {

		for ($i = 0; $i < $num_rows; $i++){
			
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);	
			$query 	->select('*')
					->from($db->quoteName('#__quote_item'))
					->where($db->quoteName('quote') . ' = ' . $db->quote($row[$i]['id']));
			$db->setQuery($query);
			$db->execute();

			$num_row = $db->getNumRows();
			$ro = $db->loadAssocList();

			if($num_row > 0) {
				
				$quoteid = $row[$i]['id'];
				$state   = $row[$i]['state'];
				$created = $row[$i]['created'];
				$items = $ro;

				$quote = array('quoteid' => $quoteid, 'state' => $state, 'created' => $created, 'items' => $items);
				
				$quotes[] = $quote;

			}


		} //endfor
		$Quotes = json_encode($quotes);
		echo $Quotes;
	}

	//Message

	// $db = JFactory::getDBO();
	// $query = $db->getQuery(true);	
	// $query
	// 	->select('mess_submit')
	// 	->from($db->quoteName('#__quote_head'));
	// $query->where($db->quoteName('id') . '=1');
	// $db->setQuery($query);
	// $db->execute();
	// $num_rows = $db->getNumRows();
	// $mess_submit = $db->loadAssocList();

	// $mess_submit = $mess_submit[0]['mess_submit'];
	
	// $message = array('mess_submit' => $mess_submit);
	// $message = json_encode($message);
	// echo $message;

?>