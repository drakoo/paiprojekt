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
	
mysql_query('SET NAMES utf8');	

$result = mysql_query('SELECT * FROM subpage',$sql)
	or die('Błędne zapytanie: '.mysql_error());
 
?>

<div id='log-ap-menu'>
<ul>
<li><a href="admin.php?admin=site_properties">GŁÓWNE USTAWIENIA</a></li>
<?php
while ($record = mysql_fetch_array($result, MYSQL_ASSOC)){
	if($record['id'] == 1)
	{
		echo '<li><a href="admin.php?admin=aktualnosci">'.$record['pagename'].' </a></li> ';
	} 
	else
	{
		if($record['id'] == 2)
		{
			echo '<li><a href="admin.php?admin=1">'.$record['pagename'].'</a></li>';
		}
		else
		{
			if($record['id'] == 3)
			{
				echo '<li><a href="admin.php?admin=2">'.$record['pagename'].'</a></li>';
			}
			else
			{
				if($record['id'] == 4)
				{
					echo '<li><a href="admin.php?admin=3">'.$record['pagename'].'</a></li>';
				}
				else
				{
					if($record['id'] == 5)
					{
						echo '<li><a href="admin.php?admin=dzialosie">'.$record['pagename'].'</a></li>';
					}					
				}
			}
		}
	}
}
?>
<li><a href="admin.php?admin=gallery">GALERIA</a></li>
</ul>
</div>
<?php
$arg = $_GET['admin'];

echo"<div id='log-ap-content'>";
switch($arg){
	case "site_properties":
		include('site_properties.php');
	break;
	case "aktualnosci":
		include('admin_aktualnosci.php');
	break;
	case "1":
		include('admin_1.php');
	break;
	case "2":
		include('admin_2.php');
	break;
	case "3":
		include('admin_3.php');
	break;		
	case "gallery":
		include('admin_gallery.php');
	break;
	case "contact":
		include('admin_contact.php');
	break;
	default:
		include('homeadmin.php');
	break;
}
echo"</div>";
?></div>