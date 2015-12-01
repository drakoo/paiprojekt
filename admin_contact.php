<?php
include_once('config.php');

$mysql_user_name = mysql_user_name;
$mysql_user_passwd = mysql_user_passwd;
$mysql_name = mysql_name;
$host = host;

$mysql = mysql_connect($host,$mysql_user_name,$mysql_user_passwd)
	or die('Nie mogę połączyć się z bazą danych: '.mysql_error());

mysql_select_db($mysql_name,$mysql)
	or die('Nie mogę wybrać bazy: '.mysql_error());	

$contact_res = mysql_query('SELECT * FROM contact',$mysql)
	or die('Błędne zapytanie: '.mysql_error());
	
$contact_result = mysql_fetch_array($contact_res, MYSQL_ASSOC);	

$firm_name = $_POST['firm_name'];
$firm_adress = $_POST['firm_adress'];
$firm_nip = $_POST['firm_nip'];
$firm_regon = $_POST['firm_regon'];
$firm_phone_one = $_POST['firm_phone_one'];
$firm_phone_two = $_POST['firm_phone_two'];
$firm_email = $_POST['firm_email'];

if(isset($_POST['save_contact']))
{
	$inquiry = "UPDATE contact SET firm_name = '".$firm_name."',adress = '".$firm_adress."',nip = '".$firm_nip."',regon = '".$firm_regon."',phone_one = '".$firm_phone_one."',phone_two = '".$firm_phone_two."',email = '".$firm_email."' ";
	$res = mysql_query($inquiry);
	if (!$res)
	{
		exit('Błąd w zapytaniu MySQL:<br><<b>'.$inquiry.'</b><br>'.mysql_error());
	}
	else
	{
		$updated = "<br/><img class='img' src='theme/images/info.png'> Pomyślnie zaktualizowano.<br/>";
	}
}
else
{
		echo '<br/><b>Pozostaw Puste jeżeli nie chcesz wyświetlić na stronie.</b><br/><br/>';
		echo '<form action="admin.php?admin=contact" method="post">';
		echo 'Nazwa firmy: <br /><input type="text" name="firm_name" maxlength="150" size="50" value="'.$contact_result['firm_name'].'" /> <br /><br />';
		echo 'adres: <br /><input type="text" name="firm_adress" maxlength="150" size="50" value="'.$contact_result['adress'].'" /> <br /><br />';
		echo 'NIP: <br /><input type="text" name="firm_nip" maxlength="20" size="50" value="'.$contact_result['nip'].'" /> <br /><br />';
		echo 'REGON: <br /><input type="text" name="firm_regon" maxlength="20" size="50" value="'.$contact_result['regon'].'" /> <br /><br />';
		echo 'telefon 1: <br /><input type="text" name="firm_phone_one"  size="50" value="'.$contact_result['phone_one'].'" /> <br /><br />';
		echo 'telefon 2: <br /><input type="text" name="firm_phone_two" size="50" value="'.$contact_result['phone_two'].'"/> <br /><br />';
		echo 'adres email: <br /><input type="text" name="firm_email" maxlength="50" size="50" value="'.$contact_result['email'].'"/> <br /><br />';
		echo '<input type="submit" name="save_contact" value="Dodaj" />';
		echo '</form>';	
}

?>

<?php
echo $updated;
mysql_close($mysql); 
?>