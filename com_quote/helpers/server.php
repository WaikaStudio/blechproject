<?php 

	//Cabecera incluir librerias en el SERVER

	define( '_JEXEC', 1) ;
	define('JPATH_BASE', '/home/uemapa71/public_html/uemapa.com/quality'); //SERVER

	// Required Joomla Files
	require_once ( JPATH_BASE .'/includes/defines.php' );
	require_once ( JPATH_BASE .'/includes/framework.php' );

	// Connect to Joomla's Database Class
	require_once ( JPATH_BASE .'/libraries/joomla/factory.php' );

 ?>