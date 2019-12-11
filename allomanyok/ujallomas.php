<!DOCTYPE html>
<html>
	<?php include ("header.php"); ?>
	
	<?php include ("menu.php"); ?>
	
	<div id="tartalom">
		<h2>Az adatbázisban megtalálható állomások</h2>
		<?php $eredmeny=mysqli_query($link,"SELECT Nev FROM menetrend.allomas ORDER BY Nev"); ?>
		<ul>
			<?php while ($row = mysqli_fetch_array($eredmeny)): ?>
			<li><?=$row['Nev']?></li>
			<?php endwhile; ?>
		</ul>		
		
		<form action="ujallomas.php" method="post">
            <h2>Új állomás felvétele a rendszerbe</h2>
            <p>
                Állomás neve: <input type="text" name="nev" />    
            </p>
            <p> 
                <input type="submit" value="Felvétel" name="uj" />
            </p>
        </form>
		
		<?php
		if (isset($_POST['uj'])) {
			$nev = $_POST['nev'];
			$query = sprintf("SELECT COUNT(*) FROM allomas WHERE allomas.nev='%s'", mysqli_real_escape_string($link, $nev));
			$eredmenyall=mysqli_query($link, $query);
			$allomasszam = mysqli_fetch_array($eredmenyall);
			if ($allomasszam['COUNT(*)']==1) echo "HIBA! Az állomás már létezik!";
			else
			{
				if($nev=='') echo "HIBA! A név mező nem lehet üres";
				else {
					$query=sprintf("INSERT INTO allomas (Nev) VALUES('%s')", mysqli_real_escape_string($link, $nev));
					mysqli_query($link,$query);
					printf("%s megálló sikeresen hozzáadva az adatbázishoz!",$nev);
					header( "refresh:1.5;" );
				}
			}
		}
		?>
	</div>
	
	<?php include("footer.php"); ?>
    
</html>