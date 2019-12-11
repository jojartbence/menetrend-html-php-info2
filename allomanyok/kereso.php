<!DOCTYPE html>
<html>
	<?php include ("header.php"); ?>
	
	<?php include ("menu.php"); ?>
	
	<div id="tartalom">
		<form action="kereso.php" method="post">
            <h1>Keresés a menetrendben</h1>
            <p>
                Honnan?  
				<select name="honnan">
				<?php
					$eredmeny=mysqli_query($link, "SELECT Nev FROM allomas ORDER BY nev");
					while ($row = mysqli_fetch_array($eredmeny)): ?>
						<option value=<?=$row['Nev']?>><?=$row['Nev']?></option>
				<?php	endwhile; ?>
				</select>				
            </p>
            <p>
                Hova?  
				<select name="hova">
				<?php
					$eredmeny=mysqli_query($link, "SELECT Nev FROM allomas ORDER BY nev");
					while ($row = mysqli_fetch_array($eredmeny)): ?>
						<option value=<?=$row['Nev']?>><?=$row['Nev']?></option>
				<?php	endwhile; ?>
				</select>				
            </p>
            <p> 
                <input type="submit" value="Tervezés" name="uj" />
            </p>
        </form>
	
<?php
if (isset($_POST['uj'])) {
	$honnan = $_POST['honnan'];
	$hova = $_POST['hova'];
	if($honnan==$hova) echo "HIBA! A kiinduló és a célállomás nem lehet azonos!";
	else {
	$query=sprintf("
		SELECT vasutvonal, a1.nev as a1nev,m1.mikor as m1mikor, m1.tipus as m1tipus, a2.nev as a2nev,m2.mikor as m2mikor, m2.tipus as m2tipus
		FROM megall m1 INNER JOIN megall m2 ON m1.VonatId=m2.VonatId
		INNER JOIN allomas a1 ON a1.id=m1.AllomasId
		INNER JOIN allomas a2 ON a2.id=m2.AllomasId
		INNER JOIN vonat ON m1.VonatId=vonat.Id
		WHERE '%s' = a1.nev and '%s' = a2.nev AND m1.mikor<m2.mikor
		ORDER BY m1mikor" ,
		mysqli_real_escape_string($link, $honnan),
		mysqli_real_escape_string($link, $hova));
		
	$eredmeny = mysqli_query($link,$query);

?>
	 <table>
            <tr>
				<th>Vasútvonal</th>
                <th>Indulás</th>
                <th>Mikor indul</th>
				<th>Érkezés</th>
				<th>Mikor érkezik</th>
            </tr>
			
			<?php while ($row = mysqli_fetch_array($eredmeny)): ?>
			<tr>
				
				<td><?=$row['vasutvonal']?></td>
				<td><?=$row['a1nev']?><br/><?=$row['m1tipus']?></td>
				<td><?=$row['m1mikor']?></td>
				<td><?=$row['a2nev']?><br/><?=$row['m2tipus']?></td>
				<td><?=$row['m2mikor']?></td>
			</tr>
			<?php endwhile; ?>
			
        </table>	
	
	<?php }
	} ?>
	<p/>
	</div>
<?php include("footer.php"); ?>
    
</html>
