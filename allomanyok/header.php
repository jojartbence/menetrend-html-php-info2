    <head>
        <title>Vasúti menetrend</title>
       <link rel="stylesheet" type="text/css" href="theme.css"> 
	   <meta charset="utf-8" />
    </head>
    <body>
    <div id="keret">
	<div id="fejlec">
        <h1 id="nagycim"><a href="index.php">Vasúti menetrend</a></h1>	
		<?php
			$link = mysqli_connect("localhost","root","") or die("Kapcsolodasi hiba " . mysqli_error());
			mysqli_select_db($link, "menetrend");
			mysqli_query($link,'SET NAMES utf8');
			header('Content-type: text/html; charset=utf-8');
		?>
	</div>
	<div id="fejleckep">
		<a href="index.php"><img src="sinek.jpg"></a>
	</div>
	<hr/>