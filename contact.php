<div id="contact-container">
	
	<div id="contact-info">
	<font size="5" color="#be2b68"><i><b>Witaj na naszej stronie!</b></i></font> <br/>
<b>Autorzy:</b><br/>
<b>Przemysław Bombik</b><br/>
<b>Dariusz Folwarczny</b><br/>
<b>Rafał Kwiatkowski</b><br/>
<br/><br/><br/>
 
<font size="5" color="#be2b68"><i><b>KONTAKT:</b></i> </font><br/>
tel. 777 777 777<br/>
	<?php

	mysql_query('SET NAMES utf8');	

	$result_contact = mysql_query('SELECT * FROM contact',$sql)
		or die('Błędne zapytanie: '.mysql_error());
		
	$record_contact = mysql_fetch_array($result_contact, MYSQL_ASSOC);
	
	if((strlen($record_contact['firm_name']) == 0) && (strlen($record_contact['adress']) == 0) && (strlen($record_contact['nip']) == 0) && (strlen($record_contact['regon']) == 0) && (strlen($record_contact['phone_one']) == 0) &&
	(strlen($record_contact['phone_two']) == 0) && (strlen($record_contact['email']) == 0))
	{
		
	}
	else
	{
		echo "<b>Dane Kontaktowe:</b> <br/><br/>";
		if(strlen($record_contact['firm_name']) != 0)
		{
			echo "<b>".$record_contact['firm_name']."</b><br/>";
		}
		if(strlen($record_contact['adress']) != 0)
		{
			echo "Adres:<i> ".$record_contact['adress']."</i><br/>";
		}
		if(strlen($record_contact['nip']) != 0)
		{	
			echo "NIP:<i> ".$record_contact['nip']."</i><br/>";
		}
		if(strlen($record_contact['regon']) != 0)
		{
			echo "REGON:<i> ".$record_contact['regon']."</i><br/>";
		}
		if(strlen($record_contact['phone_one']) != 0)
		{		
			echo "<i>tel. 1:".$record_contact['phone_one']."</i><br/>";
		}
		if(strlen($record_contact['phone_two']) != 0)
		{		
			echo "<i>tel. 2:".$record_contact['phone_two']."</i><br/>";
		}
		if(strlen($record_contact['email']) != 0)
		{		
			echo "<i><a href='mailto:".$record_contact['email']."'>".$record_contact['email']."</a></i><br/>";
		}
	}	
	?>
	</div>	
	<div id="contact-form">
		<form action="sendmail.php" method="post">
			Imię<font color="red">*</font>: <br/><input type="text" maxlength="20" size="50" name="name" /><br /><br />
			Nazwisko<font color="red">*</font>: <br/><input type="text" maxlength="20" size="50" name="surname" /><br /><br />
			e-mail<font color="red">*</font>: <br/><input type="text" maxlength="40" size="50" name="email" /><br /><br />
			Temat<font color="red">*</font>: <br/><input type="text" maxlength="80" size="50" name="subject" /><br /><br />
			Treść<font color="red">*</font>: <br/><textarea name="message" cols="51" rows="10"></textarea><br /><br />
			<small>Pola oznaczone (<font color="red">*</font>) są obowiązkowe!</small> <br /><br />
			
			<input type="submit" value="Wyślij!" />
		</form>
	</div>
</div>