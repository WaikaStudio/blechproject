<?php 

	//Cabecera incluir librerias en LOCAL

	define( '_JEXEC', 1) ;
	define('JPATH_BASE', '/opt/lampp/htdocs/uemapa/'); // LOCAL
	
	require_once ( JPATH_BASE .'includes/defines.php' );
	require_once ( JPATH_BASE .'includes/framework.php' );
	require_once ( JPATH_BASE .'libraries/joomla/factory.php' );

?>