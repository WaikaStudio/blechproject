<?php

  require_once('local_server.php');
  // Update Quote Status: Closed!
  $quoteid = $_POST['quoteid'];
  
  $db = JFactory::getDBO();
  
  $query = $db->getQuery(true);

  $field = array($db->quoteName('state') . ' = 2');
  
  $condition = array( $db->quoteName('id') . ' = ' . $db->quote($quoteid) );
  
  $query
    ->update($db->quoteName('#__quote_ctrl'))
    ->set($field)
    ->where($condition);
  $db->setQuery($query);
  
  $result = $db->execute();

?>