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

mysql_query('SET NAMES utf8');		
	
$result = mysql_query('SELECT * FROM site_properties',$mysql)
	or die('Błędne zapytanie: '.mysql_error());
	
$record = mysql_fetch_array($result, MYSQL_ASSOC);
//from sql
$title = $record['title'];
$description = $record['description'];
$keywords = $record['keywords'];
$author = $record['author'];
$email = $record['contactmail'];
$footer = $record['footer'];

//from form
$site_title = $_POST['site_title'];
$site_description = $_POST['site_description'];
$site_keywords = $_POST['site_keywords'];
$site_author = $_POST['site_author'];
$site_email = $_POST['site_email'];
$site_footer = $_POST['site_footer'];

if(isset($_POST['update']))
{
	$inquiry = 'UPDATE site_properties SET title = "'.$site_title.'", description = "'.$site_description.'", keywords = "'.$site_keywords.'", author = "'.$site_author.'", contactmail = "'.$site_email.'", footer = "'.$site_footer.'"';
	$res = mysql_query($inquiry);
	if (!$res)
	{
		exit('Błąd w zapytaniu MySQL:<br><<b>'.$inquiry.'</b><br>'.mysql_error());
	}
	else
	{
		//echo "<b> Pomyślnie zaktualizowano!</b><br /><br />";
		$updated = "<img class='img' src='theme/images/info.png'> Pomyślnie zaktualizowano!";
		$result = mysql_query('SELECT * FROM site_properties');
		$record = mysql_fetch_array($result, MYSQL_ASSOC);
		$title = $record['title'];
		$description = $record['description'];
		$keywords = $record['keywords'];
		$author = $record['author'];
		$email = $record['contactmail'];
		$footer = $record['footer'];
	}
}
?>

<form action="admin.php?admin=site_properties" method="post">
	Tytuł strony: <br/><input type="text" name="site_title" size="50" value="<?php echo $title ?>" maxlength="75" /><br /><br />
	Opis Strony: <br/><input type="text" name="site_description" size="50" maxlength="150" value="<?php echo $description ?>" /><br /><br />
	Słowa Kluczowe:<br/> <small>(oddzielić przecinkami)</small><br/><input type="text" name="site_keywords" maxlength="256" size="50" value="<?php echo $keywords ?>" /><br /><br />
	Autor Strony:<br/> <input type="text" name="site_author" maxlength="50" size="50" value="<?php echo $author ?>" /><br /><br />
	Adres e-mail:<br/> <small>(adres na który będą wysyłane maile z formularza)</small><br/><input type="text" name="site_email" maxlength="40" size="50" value="<?php echo $email ?>" /><br /><br />
	Stopka:<br/> <input type="text" name="site_footer" size="50" maxlength="200" value="<?php echo $footer ?>" /><br /><br />
	<input type="submit" name="update" value="Aktualizuj" />
</form>

<?php
echo $updated;
mysql_close($mysql); 
?>