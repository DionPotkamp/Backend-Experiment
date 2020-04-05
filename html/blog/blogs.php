<!DOCTYPE html>
<html lang="nl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="../../styles/styles.css">
		<title>Verwerken</title>
		<!--
			auteur: Dion Potkamp
			datum: 08-01-2019
		-->
	</head>
	<body>
		<article>
		<?php 
		require("../functions.php");
		//errors handelen
		set_error_handler("error");
		//sessie starten
		session_start();
		//controleren of user ingelogd is
		ingelogt($_SESSION["ID"], session_id(), "../");
		
		if(isset($_POST["submit"])) {
			//vars valideren
			$postNaam = ucfirst(htmlspecialchars($_POST["titel"]));
			$uniekTitel = "";
			//bestand openen, lezen(voor later) en omzetten in een array
			$bestand = fopen("blogs.txt", "ab");
			$bestandInhoud = file_get_contents("blogs.txt");
			$postJsonArray = json_decode($bestandInhoud, true);
			//controleer of de title al bestaat, 
			//	zo ja dan moet de gebruiker een andere titel gebruiken
				$c = count($postJsonArray);
				$i = 0;
				while($i <= $c){
					if($postNaam == $postJsonArray[$i]["naam"]) {
						$uniekTitel = false;
						break;
					} else {
						$uniekTitel = true;
					}	
					$i++;
				}
				//als $uniekTitel waar is zal er gecontroleerd worden of het bestand is geopend
				if($uniekTitel) {
					if(!$bestand) {
						echo "	
							<script>
								alert('Kon geen bestand openen! Probeer het opnieuw.');
								location.href='blogs.html';
							</script>";
						exit;
					}
					//gegevens van het formulier opvangen
					$poster = $_SESSION["name"];
					$time = new DateTime("now");
					$time = $time->format('Y-m-d H:i:s');
					if ($time) {
					  $time =  $time;
					} else {
					  $time = "Tijd onbekent";
					}
					$pfFoto = $_SESSION["foto"];
					$text = nl2br(htmlspecialchars($_POST['topic']));
					//gegevens in associative array zetten
					$data = [
						"naam" 	=> "$postNaam",
						"time" 	=> "$time",
						"poster"=> "$poster",
						"foto"=> "$pfFoto",
						"text" 	=> "$text"
					];
					//encoden naar JSON
					$postJsonString = json_encode($data);
					//lengte van bestand (-1, want array begint bij 0)
					$lengt = (strlen("$bestandInhoud") - 1);
					//als laatste char ] is, vervang met , om het JSON structuur te behouden
					if (substr($bestandInhoud, $lengt) == "]") {
						$bestandInhoud = str_replace("]" , "," , $bestandInhoud);
						ftruncate($bestand, 0);
					} else {
						echo "	
							<script>
								alert('Probleem bij het verwerken. Post is niet geüpload.');
								location.href='blogs.html';
							</script>";
						exit;
					}
					//samenvoegen van oude en nieuwe content + ] om het JSON structuur te behouden
					$bestandInhoud = $bestandInhoud . $postJsonString . "]";
					//scrijven in bestand
					fwrite($bestand, $bestandInhoud, (strlen($postJsonString) + strlen($bestandInhoud) + 1));
					//bestand sluiten en controleren of het gebeurt is
					if(fclose($bestand)) {
						//aantal posts bijwerken
						$_SESSION["count"] = $c;
						echo "	
							<script>
								alert('Post is aangemaakt en wordt gepubliceerd');
								location.href='blogshome.php';
							</script>";
						exit;
					} else {
						echo "	
							<script>
								alert('Kon bestand niet afsluiten.');
								location.href='blogs.html';
							</script>";
						exit;
					} 
				} else {
					echo "	
						<script>
							alert('Deze titel is al in gebruik, kies een andere.');
							location.href='blogs.html';
						</script>";
					exit;
				}
			}
		?>
		</article>
	</body>
</html>