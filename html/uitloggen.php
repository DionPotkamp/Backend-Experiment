<!DOCTYPE html>
<html lang="nl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="../styles/styles.css">
		<title>Uitgelogt</title>
		<!--
			auteur: Dion Potkamp
			datum: 07-01-2019
		-->
	</head>
	<body>
		<div class="postsBG"></div>
		<header>
			<img id="altfoto" src="../styles/images/logoclear.png">
		</header>
		<nav>
			<a href="../index.html" >
				<input type="button" name="terug" value="Naar inlog scherm" style="width: 15vw;">
			</a>
		</nav>
		<main class="uitlogM">
			<article class="uitlogA">
				<?php
				require_once("functions.php");
				//errors handelen
				set_error_handler("error");
				//sessie starten, melding geven en sessie verwijderen
				session_start();
				
				if(!$_SESSION["user"]) {
					echo "<br>Je was al uitgelogt.";
				} else {
					echo "<br>Tot de volgende keer " . $_SESSION["name"];
				}
				
				session_destroy();
				?>
			</article>
		</main>
	</body>
</html>