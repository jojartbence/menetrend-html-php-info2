<!DOCTYPE html>
<html>
	<?php include ("header.php"); ?>
	
	<?php include ("menu.php"); ?>
	
	<div id="tartalom">
	<h2>A kiválasztott járat adatai:</h2>
	<?php
	if (isset($_GET['id'])) {
		$id=$_GET['id'];
		$query=sprintf("SELECT Vasutvonal FROM vonat
						WHERE vonat.id='%d'",
						mysqli_real_escape_string($link,$id));
		$eredmeny=mysqli_query($link,$query);
		$vasutvonal=mysqli_fetch_array($eredmeny)['Vasutvonal'];
		?>
		<h3><?php printf("Vasútvonal száma: %d", $vasutvonal); ?></h3><?php
		$query=sprintf("SELECT Vasutvonal, Allomas.Nev, Allomas.Id, Mikor, Tipus FROM megall
						INNER JOIN vonat ON vonat.id=megall.vonatid
						INNER JOIN allomas ON allomas.id=megall.allomasid
						WHERE vonat.id='%d'
						ORDER BY Mikor",
						mysqli_real_escape_string($link,$id));
		$eredmeny=mysqli_query($link,$query);
	?>
		<table>
			<tr>
				<th>Állomás</th>
                <th>Megáll</th>
                <th>Típus</th>
				<th>Megállási idő módosítása</th>
				<th>Töröl</th>
			</tr>
		<?php while ($row = mysqli_fetch_array($eredmeny)): ?>
			<tr>
				<td><?=$row['Nev']?></td>
				<td><?=$row['Mikor']?></td>
				<td><?=$row['Tipus']?></td>
				<td>
					<form action="megallomodosit.php?id=<?=$id?>&allomasid=<?=$row['Id']?>" method="post">
					<?php if ($row['Tipus']=="Köztes megálló"): ?>
					<p>
					Új idő: <input type="time" name="mikor" />    
					<input type="submit" value="Módosít" name="new" />
					</p>
					<?php endif; ?>
					</form>
				</td>
				<td>
					<a href="megallotorol.php?id=<?=$id?>&allomasid=<?=$row['Id']?>">
						<?php if ($row['Tipus']=="Köztes megálló") echo "Megálló törlése"; ?>
					</a>
				</td>
			</tr>
		<?php endwhile; ?>
		</table>
		

	
		<form action="jaratmodosit.php?id=<?=$id?>" method="post">
            <h2>Új köztes megálló hozzáadása a járathoz</h2>
            <p>
                Állomás neve?  
				<select name="allomas">
				<?php
					$eredmeny=mysqli_query($link, "SELECT Nev FROM allomas ORDER BY nev");
					while ($row = mysqli_fetch_array($eredmeny)): ?>
						<option value=<?=$row['Nev']?>><?=$row['Nev']?></option>
				<?php	endwhile; ?>
				</select>				
            </p>
			<p>
                Mikor áll meg ott? <input type="time" name="mikor" />    
            </p>
            <p> 
                <input type="submit" value="Hozzáadás" name="uj" />
            </p>
        </form>
		
	<?php
	
		if (isset($_POST['uj'])) {
			$allomas = $_POST['allomas'];
			$mikor = $_POST['mikor'];
			$query = sprintf("SELECT COUNT(*) FROM allomas INNER JOIN megall ON allomas.id=megall.allomasid WHERE allomas.nev='%s' AND vonatid=%d", mysqli_real_escape_string($link, $allomas),mysqli_real_escape_string($link, $id));
			$allszam=mysqli_query($link, $query);
			$rowall = mysqli_fetch_array($allszam);
			if ($rowall['COUNT(*)']>0) echo "HIBA! Ezen az állomáson már megáll a vonat! ";
			$query=sprintf("SELECT Mikor, Nev FROM megall
				INNER JOIN vonat ON vonat.id=megall.vonatid
				INNER JOIN allomas ON allomas.id=megall.allomasid
				WHERE vonat.id='%d' AND Tipus='Induló állomás'",mysqli_real_escape_string($link,$id));
			$eredmeny=mysqli_query($link,$query);
			$row=mysqli_fetch_array($eredmeny);
			$mikorindul=$row['Mikor'];
			$induloall=$row['Nev'];
			$query=sprintf("SELECT Mikor, Nev FROM megall
				INNER JOIN vonat ON vonat.id=megall.vonatid
				INNER JOIN allomas ON allomas.id=megall.allomasid
				WHERE vonat.id='%d' AND Tipus='Végállomás'",mysqli_real_escape_string($link,$id));
			$eredmeny=mysqli_query($link,$query);
			$row=mysqli_fetch_array($eredmeny);
			$mikorerkezik=$row['Mikor'];
			$vegall=$row['Nev'];		
			if($mikor<=$mikorindul || $mikor>=$mikorerkezik) echo "HIBA! A megállási időnek az indulási és az érkezési idő közé kell esnie! ";
			if($allomas==$vegall || $allomas==$induloall) echo "HIBA! A megálló neve nem lehet azonos a kiinduló vagy a végállomással!";
			if ($rowall['COUNT(*)']==0 && $mikor>$mikorindul && $mikor<$mikorerkezik && $allomas!=$vegall && $allomas!=$induloall)
			{
				$query=sprintf("INSERT INTO megall VALUES('%d', (SELECT Id FROM Allomas WHERE Allomas.nev='%s') , '%s' , 'Köztes megálló')", $id , $allomas, $mikor);
				mysqli_query($link,$query);
				echo "A köztes megálló sikeresen hozzáadva a járathoz!";
				echo("<meta http-equiv='refresh' content='0'>");
			}
		}	
	}
	?>

	</div>
	
	<?php include("footer.php"); ?>
    
</html>