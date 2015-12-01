<?php

mysql_query('SET NAMES utf8');	

$resultr = mysql_query('SELECT * FROM subpage WHERE id = 3',$sql)
	or die('Błędne zapytanie: '.mysql_error());
	
$recordr = mysql_fetch_array($resultr, MYSQL_ASSOC);

echo $recordr['contents'];

?>
