<?php
session_start();
include_once('config.php');

$mysql_user_name = mysql_user_name;
$mysql_user_passwd = mysql_user_passwd;
$mysql_name = mysql_name;
$host = host;


$sql = mysql_connect($host,$mysql_user_name,$mysql_user_passwd)
	or die('Nie mogę połączyć się z bazą danych: '.mysql_error());

mysql_select_db($mysql_name,$sql)
	or die('Nie mogę wybrać bazy: '.mysql_error());

mysql_query('SET NAMES utf8');		
	
if (isset($_GET['logout'])==1) 
{
	$_SESSION['zalogowany'] = false;
	session_destroy();
}

function filter($data)
{
    if(get_magic_quotes_gpc())
        $data = stripslashes($data);

    return mysql_real_escape_string(htmlspecialchars(trim($data)));
}

if (isset($_POST['log']))
{
	$login = filter($_POST['login']);
	$passwd = filter($_POST['passwd']);
	$passwd_md5 = md5($passwd);

	if (mysql_num_rows(mysql_query("SELECT login, pass FROM user WHERE login = '".$login."' AND pass = '".$passwd_md5."';")) > 0)
	{

		$_SESSION['zalogowany'] = true;
		$_SESSION['login'] = $login;
		
	}
	else $error_data =  '<div id="admin-login-error"><img class="img" src="theme/images/error.png"> Wpisano złe dane!</div>';
}

$day = date('d');
$day_of_the_week = date('l');
$month = date('n');
$year = date('Y');
$hourminute = date('G:i');

$month_pl = array(1 => 'Stycznia', 'Lutego', 'Marca', 'Kwietnia', 'Maja', 'Czerwca', 'Lipca', 'Sierpnia', 'Września', 'Października', 'Listopada', 'Grudnia');

$day_of_the_week_pl = array('Monday' => 'Poniedziałek', 'Tuesday' => 'Wtorek', 'Wednesday' => 'Środa', 'Thursday' => 'Czwartek', 'Friday' => 'Piątek', 'Saturday' => 'Sobota', 'Sunday' => 'Niedziela');

$time = $day_of_the_week_pl[$day_of_the_week].", ".$day." ".$month_pl[$month]." ".$year."r. ".$hourminute;

if ($_SESSION['zalogowany']==true)
{
	echo"<div id='log-ap'>";
	echo"<div id='log-ap-info'>";
	echo "<div style='float:left;padding:5px 20px 5px 0px'>Witaj <b><font color='red'>".$_SESSION['login']."</font></b> ";
	
	echo "<a href='?logout=1'>[Wyloguj]</a></div> <div class='right'>".$time."</div></div>";	
	$result = mysql_query("SELECT * FROM user WHERE login = '".$_SESSION['login']."'");
	$record = mysql_fetch_array($result, MYSQL_ASSOC);
	$admin = $record['status'];
	if($admin == "admin")
	{	
	include_once('administration.php');
	}
	else
	{
		echo "<br/>User";
	}
	echo "</div>";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Panel Administracyjny</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="pl" />
	<link rel="stylesheet" type="text/css" href="theme/admin.css" />
	<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
	<script>
        tinymce.init({selector:'textarea', language : 'pl', entity_encoding : 'raw', height : 300, plugins: "link,preview,textcolor,advlist,autolink,autosave,charmap,code,emoticons,hr,image,media,paste,spellchecker", toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify |  forecolor backcolor emoticons | bullist numlist outdent indent | link image"});
	</script>
</head>
<body>

<?php if ($_SESSION['zalogowany']==false): 
echo $error_data; ?>

<div id="admin-login-top"><img class="img" src="theme/images/login.png"> Panel Logowania</div>
<div id="admin-login">
	<form action="admin.php" method="post">
	Login:<br/> <input class="admin-log" type="text" name="login" /><br /><br />
	Hasło:<br/> <input class="admin-log" type="password" name="passwd" /><br /><br />
</div>
<div id="admin-login-button">
		<center><input type="submit" name="log" value="Zaloguj" /></center>
		</form>
</div>
<?php 
endif;
?>
</body>
</html>
<?php
mysql_close($sql); 
?>