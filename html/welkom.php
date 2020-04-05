<!DOCTYPE html>
<html lang="nl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="../styles/styles.css">
		<title>Home</title>
		<!--
			auteur: Dion Potkamp
			datum: 07-01-2019
		-->
		<?php
		require("functions.php");
		//errors handelen
		set_error_handler("error");
		//sessie starten
		session_start();
		//controleren of user is ingelogt
		ingelogt($_SESSION["ID"], session_id(), ""); 
		$profielFoto = "gebruikers/profielfotos/" . $_SESSION["foto"];
		//in het document worden enkele vars aangeroepen
		?>
	</head>
	<body>
		<div class="postsBG"></div>
		<header>
			<h1 class="groet">
				Welkom
			</h1>
			<div class="profielfoto">
				<img id="profielFoto" src="<?php echo $profielFoto; ?>" alt="Profielfoto">
			</div>
			<img id="altfoto" src="../styles/images/logoclear.png">
			<div class="pfnaam">
				<h2>
					<?php echo $_SESSION["name"]; ?>
				</h2>
			</div>
		</header>
		<nav>
			<a href="uitloggen.php" class="uitlogknop">
				<input type="button" name="uitloggen" value="Uitloggen">
			</a>
			<a href="blog/blogshome.php" class="forumknop">
				<input type="button" name="forum" value="Naar het forum">
			</a>
		</nav>
		<main>
			<p>
				<h1>
					Hallo!
				</h1>
				<p class="welkomtext">
					Welkom op je persoonlijke pagina.
						<br><br>
					<span class="done">Hier krijg je binnenkort onder andere te zien hoeveel en welke berichten jij geplaatst hebt.</span>
					<span class="doneAfter">Vanaf nu beschikbaar, klik op de onderstaande knop.</span><br>
					Ook komt er een berichtenbox waarmee je privé berichten kunt sturen aan andere leden op dit forum.
				</p>
				<br>
			</p>
			<?php
			//posts inladen
			$bestandInhoud = file_get_contents("blog/blogs.txt");
			$postJsonArray = json_decode($bestandInhoud, true);
			//counter instellen voor de while lus. $c is het aantal arrays in $postJsonArray
			$c = count($postJsonArray);
			$i = 0;
			$aP = 0;
			//uitrekenen of en hoeveel posts er zijn
			while($i < $c){
				if($postJsonArray[$i]['poster'] == $_SESSION["name"]) {
					$aP++;
				}
				$i++;
			}
		?>
			<span id="OwnPostsShow">
				<?php
			if($aP == 0) {
				echo "<br>Je hebt nog geen topics gepost";
			} else {
				echo <<<BUTTON
				<p class="ownPosts" onclick="getElementById('OwnPostsShow').style.display='none';">Verberg de topics die jij gepost hebt</p>
BUTTON;
			} 
				if($aP != 0) {
					echo "<br>In totaal heb je er $aP gepost<hr class='hrblog'>";
				}
				$path = "gebruikers/profielfotos/";
				$i = 0;
				while($i < $c){
					ob_flush();
					flush();
					usleep(500000);
					if($postJsonArray[$i]['poster'] == $_SESSION["name"]) {
						showPosts($c, $postJsonArray[$i]['foto'], $path, $postJsonArray[$i]['naam'], $postJsonArray[$i]['time'], $postJsonArray[$i]['poster'], $_SESSION["name"], $postJsonArray[$i]['text']);
					}
					$i++;
				}
				ob_end_flush();
				?>
			</span>
		</main>
	</body>
</html>