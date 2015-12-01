<?php
include_once('config.php');

$mysql_user_name = mysql_user_name;
$mysql_user_passwd = mysql_user_passwd;
$mysql_name = mysql_name;
$host = host;

$sql = mysql_connect($host,$mysql_user_name,$mysql_user_passwd)
	or die('Nie mogę połączyć się z bazą danych: '.mysql_error());

mysql_select_db($mysql_name,$sql)
	or die('Nie mogę wybrać bazy: '.mysql_error());

$result = mysql_query('SELECT * FROM site_properties',$sql)
	or die('Błędne zapytanie: '.mysql_error());
	
$record = mysql_fetch_array($result, MYSQL_ASSOC);

$name = htmlspecialchars($_POST['name']);
$surname = htmlspecialchars($_POST['surname']);
$email = htmlspecialchars($_POST['email']);
$subject = htmlspecialchars(trim($_POST['subject']));
$message = htmlspecialchars(trim($_POST['message']));

$admin_email = $record['contactmail'];
$from  = "From: $email \r\n";
$from .= 'MIME-Version: 1.0'."\r\n";
$from .= 'Content-type: text/html; charset=utf-8'."\r\n";

$check_name = '/^[A-ZŁŚ]{1}+[a-ząęółśżźćń]+$/';
$check_email = '/^[a-zA-Z0-9.\-_]+@[a-zA-Z0-9\-.]+\.[a-zA-Z]{2,4}$/';
?>

<html>
<head>
	<title><?php echo $record['title'] ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="theme/styles.css" />
</head>
<body>
<div style="width:100%;padding-top:100px">
<?php
if(preg_match($check_name, $name)) 
{
	if(preg_match($check_name, $surname))
	{
		if(preg_match($check_email, $email)) 
		{
			if(!empty($subject))
			{
				if(!empty($message))
				{
					$list = "Przysłał - $name $surname <br /> ($email) <br /><br /> Treść wiadomości: <br /><br /> $message";
					if(mail($admin_email, $subject, $list, $from))
					{
						echo "<div id='send-mail'>Wysłano Poprawnie!<br/><br/><small><a class='footer' href='index.php?site=contact'>Powrót</a></small></div>";
					}
					else
					{
						echo"<div id='send-mail'>Błąd!<br/><br/><small><a class='footer' href='index.php?site=contact'>Powrót</a></small></div>";
					}
				}
				else 
				{
					echo "<div id='send-mail'>Nie podano treści wiadomości.<br/><br/><small><a class='footer' href='index.php?site=contact'>Powrót</a></small></div>";
				}
			}	
			else 
				echo "<div id='send-mail'>Nie podano tematu wiadomości.<br/><br/><small><a class='footer' href='index.php?site=contact'>Powrót</a></small></div>";	
		}
		else
			echo "<div id='send-mail'>Adres e-mail nieprawidłowy.<br/><br/><small><a class='footer' href='index.php?site=contact'>Powrót</a></small></div>";
    }
	else
		echo "<div id='send-mail'>Błędne nazwisko.<br/><br/><small><a class='footer' href='index.php?site=contact'>Powrót</a></small></div>";
} 
else 
	echo "<div id='send-mail'>Błędne imię. <br/><br/><small><a class='footer' href='index.php?site=contact'>Powrót</a></small></div>";  

?>
</div>
</body>
</html>
<?php 
mysql_close($sql);
?>