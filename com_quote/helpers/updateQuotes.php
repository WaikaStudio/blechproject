<?php 
  require_once('local_server.php');
  
  $quote = $_POST['quote'];

  foreach ($quote[1] as /*$key =>*/ $item) {
  
    $db   = JFactory::getDBO();
    $id    = $item[0];
    $price = $item[1];

  // Update Quote Control State #__quote_ctrl
    $query  = $db->getQuery(true);

    $fields = array($db->quoteName('state') . ' = 1');

    $conditions = array( $db->quoteName('id') . ' = ' . $db->quote($quote[0]) );
    $query
      ->update($db->quoteName('#__quote_ctrl'))
      ->set($fields)
      ->where($conditions);
    $db->setQuery($query);
    $result = $db->execute();
  
  // Update Quote Items Price #__quote_item
    $query  = $db->getQuery(true);

    $fields = array($db->quoteName('price') . ' = ' . $db->quote($price));

    $conditions = array($db->quoteName('quote') . ' = ' . $db->quote($quote[0]),
                        $db->quoteName('id') . ' = ' . $db->quote($id));
    $query
      ->update($db->quoteName('#__quote_item'))
      ->set($fields)
      ->where($conditions);
    $db->setQuery($query);
    $result = $db->execute();
  }

  // return mssg success update
  echo "Updated Successful";
?>