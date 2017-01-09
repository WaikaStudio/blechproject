<?php

  require_once('local_server.php');
// ---------------------------------------------------------------
  //Get Quotes of Users by state Ordered:0

  $state = $_POST['inputVal'];

  $db = JFactory::getDBO();
  
  $query = $db->getQuery(true); 
  $query->select('*')
      ->from($db->quoteName('#__quote_ctrl'))
      ->where($db->quoteName('state') . ' = ' . $db->quote($state))
      ->order('created DESC');
  $db->setQuery($query);
  $db->execute();
  
  $num_rows = $db->getNumRows();
  $row = $db->loadAssocList();

// ---------------------------------------------------------------

  if($num_rows > 0) {

    for ($i = 0; $i < $num_rows; $i++){
      
      $db = JFactory::getDBO();
      $query = $db->getQuery(true);
      $query->select('*')
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
        $uid     = $row[$i]['uid'];
        $items = $ro;

        $quote = array('quoteid' => $quoteid,'state' => $state, 'created' => $created, 'uid' => $uid, 'items' => $items);
        
        $quotes[] = $quote;
      }
    } //endfor
    $Quotes = json_encode($quotes);
    echo $Quotes;
  }

?>