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
	
$result = mysql_query('SELECT * FROM subpage WHERE id = 2',$mysql)
	or die('Błędne zapytanie: '.mysql_error());
	
$record = mysql_fetch_array($result, MYSQL_ASSOC);

$contents = $record['contents'];
$pagename = $record['pagename'];

$site_contents = $_POST['site_contents'];
$site_pagename = $_POST['site_pagename'];

if(isset($_POST['save']))
{
	$inquiry = "UPDATE subpage SET contents = ' ".$site_contents." ',pagename = '".$site_pagename."' WHERE id = '2'";
	$res = mysql_query($inquiry);
	if (!$res)
	{
		exit('Błąd w zapytaniu MySQL:<br><<b>'.$inquiry.'</b><br>'.mysql_error());
	}
	else
	{
		//echo "<b> Pomyślnie zaktualizowano!</b><br /><br />";
		$updated = "<img class='img' src='theme/images/info.png'> Pomyślnie zaktualizowano!";
		$result = mysql_query('SELECT * FROM subpage WHERE id = 2');
		$record = mysql_fetch_array($result, MYSQL_ASSOC);
		$contents = $record['contents'];
		$pagename = $record['pagename'];
	}
}

?>

<form action="admin.php?admin=historia" method="post">
	<div style="padding-bottom:20px"><div style="float:left;margin-right:10px">Nazwa podstrony <br /><small>(nazwa wyświetlająca się w menu)</small>: </div><div style="float:left"><input type="text" name="site_pagename" size="40" value="<?php echo $pagename ?>" maxlength="50" /></div></div>
	<br /><br />
	<textarea name="site_contents"><?php echo $contents ?></textarea>
	<br/><input type="submit" name="save" value="Zapisz" />
</form>

<?php
echo $updated;
mysql_close($mysql); 
?>