<?php

mysql_query('SET NAMES utf8');	

$resultgallerycat = mysql_query('SELECT * FROM gallery_category',$sql)
	or die('Błędne zapytanie: '.mysql_error());
	
echo "<div id='gallery_content'>";

/*while($recordgallery = mysql_fetch_array($resultgallery, MYSQL_ASSOC))
{	
	echo "<div style='width:310px;height:250px;overflow:hidden;float:left'><a href='images/".$recordgallery['images']."' rel='lightbox[gallery]'><img class='gallery' src='images/".$recordgallery['images']."'></a></div>";
}*/

$arg = $_GET['cat'];
switch($arg){
	case "category":
		while($recordgallerycat = mysql_fetch_array($resultgallerycat, MYSQL_ASSOC))
		{	
			echo "<div style='width:310px;height:250px;overflow:hidden;float:left;margin-right:5px;'>
			<div style='height:40px;'><a style='color:#000;text-decoration:none;font-weight:bold' href='index.php?site=gallery&cat=".$recordgallerycat['id']."'>".$recordgallerycat['name']."</div><div><img class='gallery' width='300' src='images/".$recordgallerycat['images']."'></a></div></div>";			
		}
	break;
	case "".$_GET['cat']."":
		$category_id = $_GET['cat'];
			$resultgallery = mysql_query('SELECT * FROM gallery WHERE cat_id='.$category_id.'',$sql)
				or die('Błędne zapytanie: '.mysql_error());
			
			while($recordgallery = mysql_fetch_array($resultgallery, MYSQL_ASSOC))
			{	
				/*echo "<a href='images/".$recordgallery['images']."' rel='lightbox[gallery]'><img class='gallery' src='images/".$recordgallery['images']."' width='220' height='170'></a>";*/
				/*echo "<div style='width:310px;height:250px;overflow:hidden;float:left'><a href='images/".$recordgallery['images']."' rel='lightbox[gallery]'><img class='gallery' src='images/".$recordgallery['images']."'></a></div>";*/
				
				echo "
				<div style='width:310px;height:250px;overflow:hidden;float:left;margin-right:5px;'>
					<a href='images/".$recordgallery['images']."' rel='lightbox[gallery]'>
						<img class='gallery' width='300' src='images/".$recordgallery['images']."'>
					</a>
				</div>";
			}
		

	break;
}

echo "</div><div style='clear:both'> </div>";
?>

