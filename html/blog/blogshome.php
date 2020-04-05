<!DOCTYPE html>
<html lang="nl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="../../styles/styles.css">
		<title>Forum ROME:</title>
		<!--
			auteur: Dion Potkamp
			datum: 08-01-2019
		-->
	</head>
	<body>
		<div class="postsBG"></div>
		<?php
		require('../functions.php');
		//errors handelen
		set_error_handler("error");
		//sessie starten
		session_start();
		//controleren of user ingelogd is
		ingelogt($_SESSION["ID"], session_id(), "../");
		?>
		<header>
			<h1 class="groet">Forum ROME:</h1>
			<img id="altfoto" src="../../styles/images/logoclear.png">
		</header>
		<nav>
			<a href="../welkom.php" class="forumknop">
				<input type="button" name="terug" value="Terug">
			</a>
			<a href="../uitloggen.php" class="uitlogknop">
				<input type="button" name="uitloggen" value="Uitloggen">
			</a>
			<a href="blogs.html" class="nieuwtopic">
				<input type="button" name="nieuwtopic" value="Maak een topic"> 
			</a>
			<p class="forumNaam" onclick="alert('<?php echo "Je bent " . dateDiff($_SESSION["time"]) . " geregistreerd" ?>')">
				Ingelogt als: <?php echo $_SESSION["user"] ?>
			</p>
		</nav>
		<main>
			<br><br><br>
			<p>
				<h1>
					Hallo!
				</h1>
				<p class='welkomtext'>
					Welkom op het forum ROME:.
				</p>
				<br>
				<?php
				//posts inladen
				$bestandInhoud = file_get_contents("blogs.txt");
				$postJsonArray = json_decode($bestandInhoud, true);
				//aantal posts bijwerken (-1 om de mededeling niet mee te rekenen)
				$_SESSION["count"] = (count($postJsonArray) - 1);
				//laten zien of en hoeveel posts er zijn
				$aP = $_SESSION["count"]; 
				if($aP == 0) {
					echo "Er zijn nog geen topics gepost";
				} elseif($aP == 1) {
					echo "Bekijk hieronder de posts! In totaal is het er $aP<hr class='hrblog'>";
				} else {
					echo "Bekijk hieronder de posts! In totaal zijn het er $aP<hr class='hrblog'>";
				} 
				?>
			</p>
				<?php
				$path = "../gebruikers/profielfotos/";
				//counter instellen voor de while lus. $c is het aantal arrays in $postJsonArray
				$c = count($postJsonArray);
				$i = 0;
				while($i < $c){
					ob_flush();
					flush();
					usleep(500000);
					showPosts($c, $postJsonArray[$i]['foto'], $path, $postJsonArray[$i]['naam'], $postJsonArray[$i]['time'], $postJsonArray[$i]['poster'], $_SESSION["name"], $postJsonArray[$i]['text']);
					$i++;
				}
				ob_end_flush();
				?>
		</main>
	</body>
</html>