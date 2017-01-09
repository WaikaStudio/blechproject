<?php 
  require_once('local_server.php');

  $uid = $_POST['uid'];
  
  $user = JFactory::getUser($uid);

  $quoteid = $_POST['quoteid'];
  $userName = $user->name;
  $userMail = $user->email;
  $userItems = $_POST['userItems'];

  $m = JFactory::getMailer();

  $m->setSender(array("sales@uemapa.com","UEmapa - Sales"));
  
  $m->addRecipient($userMail);
  
  $m->setSubject('Quotes Order - UEmapa');

  
  
  $email = "
 		<div style=' width: 50%; background-color: #F2F2F2; line-height:13%; padding: 3%; margin: 3%; margin-left: 200%; '>
 			<img src='http://quality.uemapa.com/images/uemapa/logo/logo-uemapa.png' alt='logo-uemapa'>

			<h4 style = 'font-size: large; font-family: sans-serif, Verdana, Arial, Helvetica; font-weight: normal; color: #CF3300; padding-left: 16%;'> Hello {$userName},</h4>

			<h4 style= 'font-size: medium;  font-family: sans-serif, Verdana, Arial, Helvetica; font-weight: normal; color: #000000; padding-left: 24%;'> your quote is active to buy.</h4>

			<h2 style= 'font-size: large; font-family: sans-serif, Verdana, Arial, Helvetica; font-weight: normal; color: #CF3300; padding-left: 16%;'> Details </h2>

			<h2>

				<h4 style= 'font-size: medium; font-family: sans-serif, Verdana, Arial, Helvetica;  font-weight: normal; padding-left: 24px; line-height: 5px;'> Quote Order N°: <strong style= ' color: #0040FF; '> {$quoteid} </strong></h4>
				<div style='background-color: #34DD40; font-weight: 400; font-family: sans-serif, Verdana, Arial, Helvetica; color: #FFF; width: 20%; border-radius: 0.25rem; border: 2px solid #32C73D;  vertical-align: middle;padding: 5px 5px; text-align: center; margin-left: 24px; padding: 0.5rem 1rem; font-size: 1rem;'> It is Active </div>
			</h2>
	<br>
	<br>
	 
		<div style = 'background: #D7D1D1; padding: 10%; width: 73%; margin-left: 55%;'> {$userItems} </div>
	
	<br>
	<div style = 'padding-left: 24%;'> <button style = ' display: inline-block; font-weight: 400; line-height: 1.25; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -moz-user-select: none; border: 1px solid transparent; padding: 0.5rem 1rem; font-size: 1rem; border-radius: 0.25rem; color: #FFF; background-color: #31B0D5; border-color: #2AABD2;' > Buy </button></div>
		<h5 style=' font-size: medium; font-family: sans-serif, Verdana, Arial, Helvetica; color: #6E6E6E; padding-left: 16px; ' >
	    Att: UE Machinery and Parts LLC.
		</h5>
	</div>
  ";

  $m->setBody($email);
  
  $m->IsHTML(true);

  $m->Send();

?>