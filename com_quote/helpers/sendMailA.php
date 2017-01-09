<?php 
  require_once('local_server.php');

  $quoteid = $_POST['quoteid'];
  $userName = $_POST['userName'];
  $userEmail = $_POST['userEmail'];
  $userItems = $_POST['userItems'];
  $OEMParts = $_POST['OEMParts'];
  ($OEMParts) ? $mssg = "Caterpillar OEM Parts": $mssg = " ";
  

  $m = JFactory::getMailer();

  $m->setSender(array($userEmail,"UEmapa - Client"));
  
  $m->addRecipient("sales@uemapa.com");
  
  $m->setSubject('Quotes Order - UEmapa');

  	  $email = "
 		<div style=' width: 50%; background-color: #F2F2F2; line-height:13%; padding: 3%; margin: 3%; margin-left: 200%; '>
 			<img src='http://quality.uemapa.com/images/uemapa/logo/logo-uemapa.png' alt='logo-uemapa'>

			<h4 style = 'font-size: large; font-family: sans-serif, Verdana, Arial, Helvetica; font-weight: normal; color: #CF3300; padding-left: 16%;'> Hello, the customer {$userName},</h4>

			<h4 style= 'font-size: medium;  font-family: sans-serif, Verdana, Arial, Helvetica; font-weight: normal; color: #000000; padding-left: 24%;'> request an items quote.</h4>

			<h5 style= 'font-size: medium;  font-family: sans-serif, Verdana, Arial, Helvetica; font-weight: normal; color: #000000; padding-left: 24%;'> {$mssg}, </h5>

			<h2 style= 'font-size: large; font-family: sans-serif, Verdana, Arial, Helvetica; font-weight: normal; color: #CF3300; padding-left: 16%;'> Details </h2>

			<h2>

				<h4 style= 'font-size: medium; font-family: sans-serif, Verdana, Arial, Helvetica;  font-weight: normal; padding-left: 24%; line-height: 5%;'> Quote Order N°: <strong style= ' color: #0040FF; '> {$quoteid} </strong></h4>
			</h2>
	<br>
	<br>
	 
		<div style = 'background: #D7D1D1; padding: 10%; width: 69%; margin-left: 60%;'> {$userItems} </div>
	
	<br>	  
		<h5 style='font-size: medium; font-family: sans-serif, Verdana, Arial, Helvetica; color: #6E6E6E; padding-left: 16px; ' >
	    Att: {$userName}.
		</h5>
	</div>
 ";
  
  $m->setBody($email);
  
  //data table quotes

  $m->IsHTML(true);

  $m->Send();

 ?>