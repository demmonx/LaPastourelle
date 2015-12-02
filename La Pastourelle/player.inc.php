<?php

require_once 'traitement.inc.php';

/**
 * Retourne le lecteur audio
 */
function getPlayer() {
	$tab = getPlaylist ();
	if (count ( $tab ) > 0) {
		?>

<div class="player">
	<div class="pl"></div>
	<div><strong class="title"></strong></div>
	<div class="artist"></div>
	<table class="controls-player">
	<tr>
			<td class="rew"><i class="fa fa-step-backward fa-2x"></i>
		</td>
		<td class="pause"><i class="fa fa-pause fa-2x"></i>
		</td>
				<td class="play"><i class="fa fa-play fa-2x"></i>
		</td>
		<td class="fwd"><i class="fa fa-step-forward fa-2x"></i></td>
		</tr>
	</table>
	<div class="volume"></div>
	<div class="tracker"></div>
</div>
<strong>Liste de lecture (<?php echo count($tab)?>) </strong>
<span class='spoiler'><i class='fa fa-plus-square-o'></i></span>
<ul class="playlist spoiler-hidden">
        <?php
		// Génération de la playlist
		foreach ( $tab as $row ) {
			echo "<li audiourl='" . $row ["lien"] . "' artist='" . $row ["groupe"] . "'>" . $row ["titre"] . "</li>";
		}
		echo "</ul>";
		echo "<script type='text/javascript' src='ressources/js/player.js'></script>";
		echo "<script type='text/javascript' src='ressources/js/spoiler.js'></script>";
	} else {
		echo "Pas de chansons disponibles";
	}
}

getPlayer ();
?>
