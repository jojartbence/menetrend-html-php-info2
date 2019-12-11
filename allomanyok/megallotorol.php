<!DOCTYPE html>
<html>
	<?php include ("header.php"); ?>
	
	<?php include ("menu.php"); ?>
	
	<div id="tartalom">
	<?php
		if (isset($_GET['id'])) {
		$id=$_GET['id'];
		$allomasid=$_GET['allomasid'];
		echo $id;
		echo $allomasid;
		$query=sprintf("DELETE FROM megall WHERE vonatid='%d' AND allomasid='%d'",mysqli_real_escape_string($link,$id),mysqli_real_escape_string($link,$allomasid));
		mysqli_query($link,$query);
	}
	
	?>
	</div>
	
	<?php include("footer.php"); ?>
	<?php 
	$head=sprintf("Location: jaratmodosit.php?id=%d",$id);
	header($head);
	?>
    
</html>


