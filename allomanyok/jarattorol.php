<!DOCTYPE html>
<html>
	<?php include ("header.php"); ?>
	
	<?php include ("menu.php"); ?>
	
	<div id="tartalom">
	<?php
	
	if (isset($_GET['id'])) {
		$id=$_GET['id'];
		$query=sprintf("DELETE FROM megall WHERE vonatid='%d'",mysqli_real_escape_string($link,$id));
		mysqli_query($link,$query);
		$query=sprintf("DELETE FROM vonat WHERE id='%d'",mysqli_real_escape_string($link,$id));
		mysqli_query($link,$query);
	}
	?>
	
	</div>
	
	<?php include("footer.php"); ?>
	<?php header("Location: modositas.php"); ?>
    
</html>
