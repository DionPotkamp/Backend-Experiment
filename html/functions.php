<?php
//errors handelen
function error($nr, $str) {
	echo "<strong>Geef de volgende code door aan een beheerder:</strong> [$nr] $str.";
}
//Functie om te controleren of iemand is ingelogt of niet
function ingelogt($id, $sessie, $path) {
	$mijnSession = $sessie;
	if(isset($id) && $id == $mijnSession) {
		$ingelogt = true;
	} else {
		$ingelogt = false;
		echo "	<script>	
					alert('Je moet ingelogt zijn om dit te doen.');
					location.href='". $path ."../index.html';
				</script>
		";
		exit;
	}
	return($ingelogt);
}
//het verschil tussen nu en de opgegeven datum teruggeven
function dateDiff($then) {
	$nu = new DateTime("now");
	$then = new DateTime($then);
	$ago = date_diff($then, $nu);
	$ago = $ago->format("%a");
	if($ago == 0) {
		$ago = "vandaag";
	} elseif($ago == 1) {
		$ago = $ago . " dag geleden";
	} else {
		$ago = $ago . " dagen geleden";
	}
	return($ago);
}
//Functie om alle posts te laten zien.
function showPosts($counter, $foto, $path, $title, $time, $poster, $name, $text) {
	if($poster == $name) $poster = "jou";
	echo "
		<span class='profielFoto postsA'>
			<img class='pfFoto' src='" . $path . $foto . "'>
		</span>
		<article class='postsA'>
			<span class='naam'>" . $title ." </span>
			<span class='time' title='" . dateDiff($time) . " gepost'>Gepost op: " . $time . "</span>
			<span class='poster'>Door: " . $poster . "</span>
			<br>
			<p class='text'>" . $text . "</p>
		</article>
	";
}
