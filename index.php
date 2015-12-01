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

/*  SITE PROPERTIES */

$result_site_propertise = mysql_query('SELECT * FROM site_properties',$sql)
	or die('Błędne zapytanie: '.mysql_error());
	
$record_site_propertise = mysql_fetch_array($result_site_propertise, MYSQL_ASSOC);

/* CONTACT */
mysql_query('SET NAMES utf8');	

	$result_contact = mysql_query('SELECT * FROM contact',$sql)
		or die('Błędne zapytanie: '.mysql_error());
		
	$record_contact = mysql_fetch_array($result_contact, MYSQL_ASSOC);

/* MENU */ 
$resultm = mysql_query('SELECT * FROM subpage',$sql)
	or die('Błędne zapytanie: '.mysql_error());
	
while ($recordm = mysql_fetch_array($resultm, MYSQL_ASSOC)){
	if($recordm['id'] == 1) 
		$aktualnosci = $recordm['pagename'];
	if($recordm['id'] == 2) 
		$site1 = $recordm['pagename'];
	if($recordm['id'] == 3) 
		$site2 = $recordm['pagename'];
	if($recordm['id'] == 4) 
		$site3 = $recordm['pagename'];			
} 

$day = date('d');
$day_of_the_week = date('l');
$month = date('n');
$year = date('Y');
$hourminute = date('G:i');

$month_pl = array(1 => 'Stycznia', 'Lutego', 'Marca', 'Kwietnia', 'Maja', 'Czerwca', 'Lipca', 'Sierpnia', 'Września', 'Października', 'Listopada', 'Grudnia');

$day_of_the_week_pl = array('Monday' => 'Poniedziałek', 'Tuesday' => 'Wtorek', 'Wednesday' => 'Środa', 'Thursday' => 'Czwartek', 'Friday' => 'Piątek', 'Saturday' => 'Sobota', 'Sunday' => 'Niedziela');

$time = $day_of_the_week_pl[$day_of_the_week].", ".$day." ".$month_pl[$month]." ".$year."r. ".$hourminute;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
	<title><?php echo $record_site_propertise['title'] ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?php echo $record_site_propertise['description'] ?>" />
	<meta name="keywords" content="<?php echo $record_site_propertise['keywords'] ?>" />
	<meta http-equiv="content-language" content="pl" />
	<meta name="author" content="<?php echo $record_site_propertise['author'] ?>" />
	<link rel="stylesheet" type="text/css" href="theme/styles.css" />
	<link rel="stylesheet" href="theme/lightbox.css" type="text/css" media="screen" />
	<script src="js/jquery-1.11.0.min.js"></script>
	<script src="js/lightbox.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/cookies.js"></script>
	<script type="text/javascript">
	$(document.body).ready(function () {
            $("#tresc:hidden").fadeIn("slow");
        });
	
	$("a").click(function (e) {
            e.preventDefault();
            $("#tresc").fadeOut("slow", function () {
                window.location.href = $("a").attr("href");
            });
        });
	</script>
</head>
<body>
	<div id="container">
		<div id="content">
				<div id="seperator"></div>
				<div id="top"><img src="theme/images/logo.jpg" alt="logo" /></div>
				<div id="menu">
				<ul>
					<li><a href="index.php?site=home_page">Strona Główna</a></li>
					<li><a href="index.php?site=gallery&cat=category">Galeria</a></li>
					<li><a href="index.php?site=aktualnosci"><?php echo $aktualnosci ?></a></li>
					<li><a href="index.php?site=1"><?php echo $site1 ?></a></li>
					<li><a href="index.php?site=2"><?php echo $site2 ?></a></li>
					<li><a href="index.php?site=3"><?php echo $site3 ?></a></li>
					
				</ul>
				</div>
				<div id="tresc">
				<?php
				$arg = $_GET['site'];
				switch($arg){
					case "home_page":
						include('contact.php');
					break;
					
					case "gallery":
						include('gallery.php');
					break;
					
					case "aktualnosci":
						include('aktualnosci.php');
					break;
					
					case "1":
						include('1.php');
					break;
					
					case "2":
						include('2.php');
					break;
					
					case "3":
						include('3.php');
					break;
										
					default:
						include('contact.php');
					break;
				}
				?>
				</div>
				<div id="footer"><p style="float:left;margin-left:25px;"><?php echo $time; ?></p><p style="float:right"><?php echo $record_site_propertise['footer']; ?></p></div>
		</div>
	</div>
</body>
</html>
<?php 
mysql_close($sql);
?>