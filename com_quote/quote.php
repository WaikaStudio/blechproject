<?php
/**
 * @author		
 * @copyright	
 * @license		
 */

defined("_JEXEC") or die("Restricted access");

require_once JPATH_COMPONENT_ADMINISTRATOR.'/helpers/quote.php';
//require_once JPATH_COMPONENT_SITE.'/helpers/category.php';
require_once JPATH_COMPONENT_SITE.'/helpers/route.php';

$controller	= JControllerLegacy::getInstance('Quote');
$input = JFactory::getApplication()->input;

$lang = JFactory::getLanguage();
$lang->load('joomla', JPATH_ADMINISTRATOR);

//JHtml::_('bootstrap.loadCss');
//JHtml::_('bootstrap.framework');
$document = JFactory::getDocument();
$cssFile = "./media/com_quote/css/site.stylesheet.css";
$document->addStyleSheet($cssFile);
//

try {
	$controller->execute($input->get('task'));
} catch (Exception $e) {
	$controller->setRedirect(JURI::base(), $e->getMessage(), 'error');
}

$controller->redirect();
?>