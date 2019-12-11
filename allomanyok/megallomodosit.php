<!DOCTYPE html>
<html>
	<?php include ("header.php"); ?>
	
	<?php include ("menu.php"); ?>
	
	<div id="tartalom">
	<?php
		if (isset($_GET['id']) && isset($_POST['new'])) {
			$id=$_GET['id'];
			$allomasid=$_GET['allomasid'];
			$mikor = $_POST['mikor'];
			$query=sprintf("SELECT Mikor FROM megall
				INNER JOIN vonat ON vonat.id=megall.vonatid
				INNER JOIN allomas ON allomas.id=megall.allomasid
				WHERE vonat.id='%d' AND Tipus='Induló állomás'",mysqli_real_escape_string($link,$id));
			$eredmeny=mysqli_query($link,$query);
			$row=mysqli_fetch_array($eredmeny);
			$mikorindul=$row['Mikor'];
			$query=sprintf("SELECT Mikor, Nev FROM megall
				INNER JOIN vonat ON vonat.id=megall.vonatid
				INNER JOIN allomas ON allomas.id=megall.allomasid
				WHERE vonat.id='%d' AND Tipus='Végállomás'",mysqli_real_escape_string($link,$id));
			$eredmeny=mysqli_query($link,$query);
			$row=mysqli_fetch_array($eredmeny);
			$mikorerkezik=$row['Mikor'];
			if($mikor>$mikorindul && $mikor<$mikorerkezik)
			{
				$query=sprintf("UPDATE megall SET Mikor='%s' WHERE vonatid=%d AND allomasid=%d",mysqli_real_escape_string($link,$mikor),mysqli_real_escape_string($link,$id),mysqli_real_escape_string($link,$allomasid));
				mysqli_query($link,$query);
			}
		}
		
	?>
	</div>
	
	<?php include("footer.php"); ?>
	<?php 
	$head=sprintf("Location: jaratmodosit.php?id=%d",$id);
	header($head);
	?>
    
</html>