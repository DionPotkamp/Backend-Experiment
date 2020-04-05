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
		<div class="postsBG"></div>
		<header>
		</header>
		<nav>
			<a href="../index.html">
				<input type="button" name="terug" value="Terug om in te loggen" style="width: 15vw;">
			</a>
		</nav>
		<main>
		<?php
		require_once("functions.php");
		//errors handelen
		set_error_handler("error");
		
		if(isset($_POST["submit"])) {
			//fotonaam voor valideren en om op te slaan later
			$fotoNaam = basename($_FILES["foto"]["name"]);
			global $uploadsMap;
			//funcie voor het controleren of een afbeelding bestaat
			// zo ja word het account niet aangemaakt
			// zo nee dan word het account wel aangemaakt
			function photoValidate() {
				global $uploadsMap;
				$uploadsMap = "gebruikers/profielfotos/";
				$uploadsMap = $uploadsMap . basename($_FILES["foto"]["name"]);
				$fotoType = pathinfo($uploadsMap, PATHINFO_EXTENSION);
				//controleer of deze foto al bestaat
				if(file_exists($uploadsMap)) {
					$bericht = "Deze foto bestaat al.";
					return false;
				}
				//valideer foto groote
				if($_FILES["foto"]["size"] > 500000) {
					$bericht = "Deze foto is te groot.";
					return false;
				}
				//valideer formaat
				if($fotoType != "jpg" && $fotoType != "png" && $fotoType != "jpeg" && $fotoType != "gif") {
					$bericht = "De foto moet een jpg, jpeg, png of een gif zijn.";
					return false;
				}
				return true;
			}
			//als photovalidate() waar is:
			if(photoValidate()) {
				// verplaats foto van temp-map naar gebruikers/profielfotos/
				if(move_uploaded_file($_FILES["foto"]["tmp_name"], $uploadsMap)) {
					$bericht = "Foto is geüpload.";
					//gebruikers file openen
					$bestandPath = "gebruikers/gebruikers.txt";
					$bestand = fopen($bestandPath, "ab");
					if(!$bestand) {
						$bericht = "kon geen bestand openen!";
					}
					//gegevens uit het formulier opvangen en verwerken in één var
					//TOR = Time Of Registration, met error handeling
					$naam = htmlspecialchars($_POST['naam']);
					$email = htmlspecialchars($_POST['email']);
					$wachtwoord = htmlspecialchars($_POST['password']);
					$profielFoto = $fotoNaam;
					$time = new DateTime("now");
					$time = $time->format('Y-m-d H:i:s');
					if ($time) {
					  $TOR =  $time;
					} else {
					  $time = "Tijd onbekent";
					}
					$profiel = 
								$naam . "*" .
								$email . "*" .
								$wachtwoord . "*" .
								$profielFoto . "*" .
								$TOR . "\n";
					//$profiel schrijven in gebruikers.txt
					fwrite($bestand, $profiel, strlen($profiel));
					//als het bestand gesloten is: melding
					if(fclose($bestand)) {
						$bericht = "<p>Account is aangemaakt.</p>";
					} else {
						$bericht = "Kon bestand niet afsluiten.<br>Probeer het opnieuw";
					} 
				} else {
					$bericht = "Probleem bij het uploaden van de foto. Account niet aangemaakt.<br>Probeer het opnieuw.";
				};
			};
		};
		?>
			<article class="errorReg"> 
				<?php echo $bericht; ?>
			</article>
		</main>
	</body>
</html>