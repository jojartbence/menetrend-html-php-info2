<!DOCTYPE html>
<html>
	<?php include ("header.php"); ?>
	
	<?php include ("menu.php"); ?>
	
	<div id="tartalom">
		<form action="ujjarat.php" method="post">
            <h1>Új járat felvétele a rendszerbe</h1>
            <p>
                Vasútvonal száma? <input type="number" name="vasutvonal" />    
            </p>
            <p>
                Induló állomás?  
				<select name="induloall">
				<?php
					$eredmeny=mysqli_query($link, "SELECT Nev FROM allomas ORDER BY nev");
					while ($row = mysqli_fetch_array($eredmeny)): ?>
						<option value=<?=$row['Nev']?>><?=$row['Nev']?></option>
				<?php	endwhile; ?>
				</select>				
            </p>
			<p>
                Mikor indul? <input type="time" name="induloido" />    
            </p>
            <p>
                Végállomás?  
				<select name="vegall">
				<?php
					$eredmeny=mysqli_query($link, "SELECT Nev FROM allomas ORDER BY nev");
					while ($row = mysqli_fetch_array($eredmeny)): ?>
						<option value=<?=$row['Nev']?>><?=$row['Nev']?></option>
				<?php	endwhile; ?>
				</select>				
            </p>
			<p>
                Mikor érkezik? <input type="time" name="erkezoido" />    
            </p>
            <p> 
                <input type="submit" value="Felvétel" name="uj" />
            </p>
        </form>
	
	
	<?php
	
	if (isset($_POST['uj'])) {
		$vasutvonal = $_POST['vasutvonal'];
		$induloall = $_POST['induloall'];
		$induloido = $_POST['induloido'];
		$vegall = $_POST['vegall'];
		$erkezoido = $_POST['erkezoido'];
		if ($erkezoido <= $induloido)
		{
			echo "HIBA! A vonat nem érhet be korábban a végállomásra, mint ahogy elindult!";
		}
		if($vasutvonal<=0)
		{
			echo "HIBA! A vasútvonalnak egy 0-nál nagyobb számnak kell lennie";
		}
		if($induloall==$vegall)
		{
			echo "HIBA! Az induló állomás és a végállomás nem lehet azonos!";
		}
		if ($erkezoido > $induloido && $vasutvonal>0 && $induloall!=$vegall)
		{
			$query=sprintf("INSERT INTO vonat (Vasutvonal) VALUES ('%d')", mysqli_real_escape_string($link, $vasutvonal));
			mysqli_query($link,$query);
			$ujid=mysqli_insert_id($link);
			$query=sprintf("INSERT INTO megall VALUES('%d', (SELECT Id FROM Allomas WHERE Allomas.nev='%s') , '%s' , 'Induló állomás')", mysqli_real_escape_string($link, $ujid), mysqli_real_escape_string($link, $induloall), mysqli_real_escape_string($link, $induloido));
			mysqli_query($link,$query);
			$query=sprintf("INSERT INTO megall VALUES('%d', (SELECT Id FROM Allomas WHERE Allomas.nev='%s') , '%s' , 'Végállomás')", mysqli_real_escape_string($link, $ujid), mysqli_real_escape_string($link, $vegall), mysqli_real_escape_string($link, $erkezoido) );
			mysqli_query($link,$query);
			echo "A járat sikeresen felvéve az adatbázisba!";
		}
	}
	?>
		
	</div>
	
	<?php include("footer.php"); ?>
    
</html>
