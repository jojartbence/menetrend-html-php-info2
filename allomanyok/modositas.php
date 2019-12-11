<!DOCTYPE html>
<html>
	<?php include ("header.php"); ?>
	
	<?php include ("menu.php"); ?>
	
	<div id="tartalom">
		<h1>Az adatbázisban található járatok</h1>
		<?php
		 $eredmeny=mysqli_query($link,"SELECT vonat.id, vasutvonal, a1.nev as a1nev,m1.mikor as m1mikor, m1.tipus as m1tipus, a2.nev as a2nev,m2.mikor as m2mikor, m2.tipus as m2tipus
			FROM megall m1 INNER JOIN megall m2 ON m1.VonatId=m2.VonatId
			INNER JOIN allomas a1 ON a1.id=m1.AllomasId
			INNER JOIN allomas a2 ON a2.id=m2.AllomasId
			INNER JOIN vonat ON m1.VonatId=vonat.Id
			WHERE m1.tipus='Induló állomás' AND m2.tipus='Végállomás'
			ORDER BY a1.nev,m1.mikor"); ?>
		<table>
			<tr>
				<th>Vasútvonal száma</th>
                <th>Induló állomás</th>
                <th>Mikor indul</th>
				<th>Végállomás</th>
				<th>Mikor érkezik</th>
				<th>Módosít</th>
				<th>Töröl</th>
			</tr>
			<?php while ($row = mysqli_fetch_array($eredmeny)): ?>
			<tr>
				<td><?=$row['vasutvonal']?></td>
				<td><?=$row['a1nev']?></td>
				<td><?=$row['m1mikor']?></td>
				<td><?=$row['a2nev']?></td>
				<td><?=$row['m2mikor']?></td>
				<td>
					<a href="jaratmodosit.php?id=<?=$row['id']?>">
						Módosítás
					</a>
				</td>
				<td>
					<a href="jarattorol.php?id=<?=$row['id']?>">
						Járat törlése
					</a>
				</td>
			</tr>
			<?php endwhile; ?>
		</table>
		<p/>
	</div>
	
	<?php include("footer.php"); ?>
    
</html>
