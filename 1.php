<?php

mysql_query('SET NAMES utf8');	

$resulth = mysql_query('SELECT * FROM subpage WHERE id = 2',$sql)
	or die('Błędne zapytanie: '.mysql_error());
	
$recordh = mysql_fetch_array($resulth, MYSQL_ASSOC);

echo $recordh['contents'];

?>
