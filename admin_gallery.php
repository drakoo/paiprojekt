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
	
$result_gallery = mysql_query('SELECT * FROM gallery',$mysql)
	or die('Błędne zapytanie: '.mysql_error());	
	
$result_gallery_cat = mysql_query('SELECT * FROM gallery_category',$mysql)
	or die('Błędne zapytanie: '.mysql_error());	
	
$result_cat = mysql_query('SELECT * FROM gallery_category',$mysql)
	or die('Błędne zapytanie: '.mysql_error());	

$gallery_images_tmp = $_FILES['gallery_image']['tmp_name'];
$gallery_save_as = $_FILES['gallery_image']['name'];
$max_rozmiar = 1024*1024;
$cat_id = $_POST['gallery_cat'];

$gallery_cat_images_tmp = $_FILES['gallery_cat_image']['tmp_name'];
$gallery_cat_save_as = $_FILES['gallery_cat_image']['name'];
$gallery_cat_name = $_POST['category_name'];

if(isset($_POST['save_gallery']))
{
	if (is_uploaded_file($gallery_images_tmp)) 
	{
		if ($_FILES['gallery_image']['size'] > $max_rozmiar) 
		{
			$updated = '<b>ERROR:</b> Błąd! Plik jest za duży!<br/><br/>';
		} 
		else 
		{
			if(file_exists("images/".$gallery_save_as))
				$updated = "<b>ERROR:</b> Istnieje już plik o takiej samej nazwie!<br/><br/>";
			else
			{
				move_uploaded_file($gallery_images_tmp, /*$_SERVER['DOCUMENT_ROOT'].*/'images/'.$gallery_save_as);
				$inquiry_eq = "INSERT INTO `gallery` ( `id` , `images`, `cat_id`) VALUES ( NULL , '".$gallery_save_as."', '".$cat_id."')";
				$res_eq = mysql_query($inquiry_eq);
				if (!$res_eq)
				{
					exit('<b>ERROR:</b> Błąd w zapytaniu MySQL:<br><<b>'.$inquiry.'</b><br>'.mysql_error());
				} 
				else
				{
				$updated = "<img class='img' src='theme/images/info.png'> Pomyślnie Dodano.<br/><br/>";
				}
			}
		}
	} 
	else 
	{
		$updated = '<b>ERROR:</b> Błąd przy przesyłaniu danych!<br/><br/>';
	}
}



$cat_id_edit = $_POST['gallery_cat_edit'];

if(isset($_POST['save_gallery_edit']))
{
	$get_edit_id = $_GET['id'];
	$inquiry_eq = "UPDATE gallery SET cat_id = ".$cat_id_edit." WHERE id =".$get_edit_id."";
	$res_eq = mysql_query($inquiry_eq);
	if (!$res_eq)
	{
		exit('<b>ERROR:</b> Błąd w zapytaniu MySQL:<br><<b>'.$inquiry.'</b><br>'.mysql_error());
	} 
	else
	{
	$updated = "<img class='img' src='theme/images/info.png'> Pomyślnie Zapisano.<br/><br/>";
	}
}

if(isset($_POST['save_cat_gallery']))
{
	if (is_uploaded_file($gallery_cat_images_tmp)) 
	{
		if ($_FILES['gallery_cat_image']['size'] > $max_rozmiar) 
		{
			$updated = '<b>ERROR:</b> Błąd! Plik jest za duży!<br/><br/>';
		} 
		else 
		{
			if(file_exists("images/".$gallery_cat_save_as))
				$updated = "<b>ERROR:</b> Istnieje już plik o takiej samej nazwie!<br/><br/>";
			else
			{
				move_uploaded_file($gallery_cat_images_tmp, /*$_SERVER['DOCUMENT_ROOT'].*/'images/'.$gallery_cat_save_as);
				$inquiry_eq = "INSERT INTO `gallery_category` ( `id` , `name`, `images`) VALUES ( NULL , '".$gallery_cat_name."', '".$gallery_cat_save_as."')";
				$res_eq = mysql_query($inquiry_eq);
				if (!$res_eq)
				{
					exit('<b>ERROR:</b> Błąd w zapytaniu MySQL:<br><<b>'.$inquiry.'</b><br>'.mysql_error());
				} 
				else
				{
				$updated = "<img class='img' src='theme/images/info.png'> Pomyślnie Dodano.<br/><br/>";
				}
			}
		}
	} 
	else 
	{
		$updated = '<b>ERROR:</b> Błąd przy przesyłaniu danych!<br/><br/>';
	}
}

?>
<br/>
<a href="admin.php?admin=gallery&add=on"><input type="submit" value="Dodaj Obraz"></a> <a href="admin.php?admin=gallery&add=image"><input type="submit" value="Zobacz dodane"></a> <br/><br/>
<a href="admin.php?admin=gallery&add=on_cat"><input type="submit" value="Dodaj Kategorie"></a> <a href="admin.php?admin=gallery&add=category"><input type="submit" value="Kategorie"></a><br/><br/>
<?php 
$arg = $_GET['add'];
switch($arg){
	case "on":
?>
<hr><br/>
<form action="admin.php?admin=gallery" method="post" enctype="multipart/form-data">
	<input type="file" name="gallery_image" /> <br /><br />
	Kategoria: <br />
	<select name="gallery_cat">
	<?php
	while($record_cat = mysql_fetch_array($result_cat, MYSQL_ASSOC))
	{
		echo "<option value='".$record_cat['id']."'>".$record_cat['name']."</option>";
	}
	?>
	</select> 
	<br /><br />
	<input type="submit" name="save_gallery" value="Dodaj" />
</form>
<?php		
	break;
	
	case "on_cat":
?>
<hr><br/>
<form action="admin.php?admin=gallery" method="post" enctype="multipart/form-data">
	Nazwa Kategorii: <input type="text" size="55" maxlength="50" name="category_name" /> <br /><br />
	<input type="file" name="gallery_cat_image" /> <br /><br />	
	<input type="submit" name="save_cat_gallery" value="Dodaj" />
</form>
<?php		
	break;
	case "image":
		echo "<hr>";

		$count_result = mysql_query('SELECT * FROM gallery',$mysql);		
		$count = mysql_num_rows($count_result);
		if ($count == 0)
		{
			echo "<br/><b>Brak dodanych zdjęć!</b>";
		}	
		else
		{
		echo '<div id="gallery-container"><center>';		
		
			while($record_gallery = mysql_fetch_array($result_gallery, MYSQL_ASSOC))
			{
				echo '<div style="float:left; margin-top:20px;margin-right:20px"><div id="gallery-image">
				Kategoria:<br/><b>';
				$result_cat = mysql_query('SELECT * FROM gallery_category',$mysql)
					or die('Błędne zapytanie: '.mysql_error());	
				while($cat_name = mysql_fetch_array($result_cat, MYSQL_ASSOC))
				{
					if($cat_name['id'] == $record_gallery['cat_id'])
					{
						echo $cat_name['name'];
					}					
				}				
				echo '</b>
				<div style="clear:both;margin-top:10px"><img class="gallery" src="images/'.$record_gallery['images'].'"></div></div><div class="eq_option" style="background:#d8d8d8;padding:20px"><a style="color:#3f3f3f" href="admin.php?admin=gallery&add=gallery_del&id='.$record_gallery['id'].'"><input type="submit" value="Usuń"></a>
				<a style="color:#3f3f3f" href="admin.php?admin=gallery&add=gallery_cat_edit&id='.$record_gallery['id'].'"><input type="submit" value="Edytuj"></a></div></div>';
			}
		echo '</center></div>';	
		}	
	break;	
	
	
	// USUWANIE ITEMU
	case "gallery_del":
		$get_del_id = $_GET['id'];
		$del_result = mysql_query('SELECT * FROM gallery WHERE id = "'.$get_del_id.'"',$mysql);
		$record_del_gallery = mysql_fetch_array($del_result, MYSQL_ASSOC);
		echo "<hr><br/>";
		if (isset($_POST['delete_gallery']))
		{
			$file_adress = "images/".$record_del_gallery['images'];
			if (unlink($file_adress))
			{
				$del_result = mysql_query( "DELETE FROM `gallery` WHERE id =".$get_del_id);
				if (!$del_result)
				{
					exit('Błąd w zapytaniu MySQL:<br><<b>'.$del_result.'</b><br>'.mysql_error());
				}
				else
				$updated = "<img class='img' src='theme/images/info.png'> Pomyślnie usunięto!<br/><br/>";
			}
			else
			{
				echo "Błąd przy usuwaniu pliku z serwera!";
			}
		}
		else
		{
			echo "Napewno chcesz usunąć?";
			echo "<br/><br/><form action='admin.php?admin=gallery&add=gallery_del&id=".$get_del_id."' method='post'><input type='submit' name='delete_gallery' value='Usuń'></form>";
		}
	break;
	
	case "gallery_cat_del":
		$get_del_id = $_GET['id'];
		$licznik = 0;
		$del_result = mysql_query('SELECT * FROM gallery_category WHERE id = "'.$get_del_id.'"',$mysql);
		$exist_result = mysql_query('SELECT * FROM gallery WHERE cat_id = "'.$get_del_id.'"',$mysql);
		$record_del_gallery = mysql_fetch_array($del_result, MYSQL_ASSOC);
		while($exist_cat = mysql_fetch_array($exist_result, MYSQL_ASSOC))
		{
			$licznik++;
		}
		echo "<hr><br/>";
		if($licznik == 0)
		{
			if (isset($_POST['delete_gallery']))
			{
				$file_adress = "images/".$record_del_gallery['images'];
				if (unlink($file_adress))
				{
					$del_result = mysql_query( "DELETE FROM `gallery_category` WHERE id =".$get_del_id);
					if (!$del_result)
					{
						exit('Błąd w zapytaniu MySQL:<br><<b>'.$del_result.'</b><br>'.mysql_error());
					}
					else
					$updated = "<img class='img' src='theme/images/info.png'> Pomyślnie usunięto!<br/><br/>";
				}
				else
				{
					echo "Błąd przy usuwaniu pliku z serwera!";
				}
			}
			else
			{
				echo "Napewno chcesz usunąć?";
				echo "<br/><br/><form action='admin.php?admin=gallery&add=gallery_cat_del&id=".$get_del_id."' method='post'><input type='submit' name='delete_gallery' value='Usuń'></form>";
			}
		}
		else
		{
			echo "Nie można usunąć ponieważ w tej kategorii znajdują się zdjęcia!";
		}
	break;
	
	case "gallery_cat_edit":
	$get_edit_id = $_GET['id'];
	?>
<form action="admin.php?admin=gallery&id=<?php echo $get_edit_id ?>" method="post" enctype="multipart/form-data">
	Kategoria: <br/><br />
	<select name="gallery_cat_edit">
	<?php
	$edit_item = mysql_query('SELECT * FROM gallery WHERE id='.$get_edit_id.'',$mysql)
	or die('Błędne zapytanie: '.mysql_error());
	$record_item = mysql_fetch_array($edit_item, MYSQL_ASSOC);
	
	while($record_cat = mysql_fetch_array($result_cat, MYSQL_ASSOC))
	{
		if($record_item['cat_id'] == $record_cat['id'])
		{
			echo "<option selected='selected' value='".$record_cat['id']."'>".$record_cat['name']."</option>";
		}
		else
		{
			echo "<option value='".$record_cat['id']."'>".$record_cat['name']."</option>";
		}
	}
	?>
	</select> 
	<br /><br />
	<input type="submit" name="save_gallery_edit" value="Zapisz" />
</form>	
	<?php
	break;
	
	case "category":
		echo "<hr>";

		$count_result = mysql_query('SELECT * FROM gallery_category',$mysql);
		$count = mysql_num_rows($count_result);
		if ($count == 0)
		{
			echo "<br/><b>Brak dodanych kategori!</b>";
		}	
		else
		{
		echo '<div id="gallery-container"><center>';
			while($record_gallery = mysql_fetch_array($result_gallery_cat, MYSQL_ASSOC))
			{
				echo '<div style="float:left; margin-top:20px;margin-right:20px"><div id="gallery-image"><b>'.$record_gallery['name'].'</b><div style="clear:both;margin-top:10px;"><img class="gallery" src="images/'.$record_gallery['images'].'"></div></div>
				<div class="eq_option" style="background:#d8d8d8;padding:20px"><a style="color:#3f3f3f" href="admin.php?admin=gallery&add=gallery_cat_del&id='.$record_gallery['id'].'"><input type="submit" value="Usuń"></a> </div></div>';
			}
		echo '</center></div>';	
		}	
	break;
}
?>

<?php
echo $updated;

mysql_close($mysql); 
?>