<!DOCTYPE html>
<html lang="nl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="../styles/styles.css">
		<title>Verwerken</title>
		<!--
			auteur: Dion Potkamp
			datum: 07-01-2019
		-->
	</head>
	<body>
		<?php
		require_once("functions.php");
		//errors handelen
		set_error_handler("error");
		//gegevens van het forumier opvangen
		$email = htmlspecialchars($_POST['email']);
		$wachtwoord = htmlspecialchars($_POST['password']);
		//bestand openen
		$bestand = fopen("gebruikers/gebruikers.txt", "r");
		//als en zolang het bestand geopend is dan het account aanmaken
		if(!$bestand) {
			echo "Kon geen bestand openen!";
		}
		while(!feof($bestand)) {
			//string omzetten in array
			$account = fgets($bestand);
			$account = explode("*", $account);
			//als email en wachtwoord overeenkomen de sessie starten
			if($account[1] == $email && $account[2] == $wachtwoord) {
				session_start();
				//$_SESSION vars aanmaken zodat ze makkelijk op te roepen zijn in de andere php pagina's
				$_SESSION["user"] = $email;
				$_SESSION["name"] = $account[0];
				$_SESSION["foto"] = $account[3];
				$_SESSION["time"] = $account[4];
				$_SESSION["count"] = 0;
				$_SESSION["ID"] = $_COOKIE["PHPSESSID"];
				//melding, omleiding en afsluiten
				echo "
						<script>
							alert('U bent ingelogd als $email.');
							location.href='welkom.php';
						</script>
				";
				exit;
			}
		}
		//als de email en wachtwoord niet overeenkomen een melding en omleiding
		echo "
		<script>
			alert('Wachtwoord of gebruikersnaam ongeldig.');
			location.href='../index.html';
		</script>
		";
		?>
	</body>
</html>