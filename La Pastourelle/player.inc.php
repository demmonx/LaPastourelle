<?php
require_once 'traitement.inc.php';

/**
 * Retourne le lecteur audio
 */
function getPlayer ()
{
    $tab = getPlaylist();
    if (count($tab) > 0) {
        echo '
    
	<div class="player">
		<div class="pl"></div>
		<div class="title"></div>
		<div class="artist"></div>
		<div class="controls-player">
			<div class="play"></div>
			<div class="pause"></div>
			<div class="rew"></div>
			<div class="fwd"></div>
		</div>
		<div class="volume"></div>
		<div class="tracker"></div>
	</div>
	<ul class="playlist hidden">';
        
        // Génération de la playlist
        foreach ($tab as $row) {
            echo "<li audiourl='" . $row["lien"] . "' artist='" . $row["groupe"] .
                     "'>" . $row["titre"] . "</li>";
        }
        echo "</ul>";
        echo "<script type='text/javascript' src='js/player.js'></script>";
        
    } else {
        echo "Pas de chansons disponibles";
    }
}

getPlayer();

