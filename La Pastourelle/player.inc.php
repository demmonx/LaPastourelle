<?php
require_once 'traitement.inc.php';

/**
 * Retourne le lecteur audio
 */
function getPlayer ()
{
    $tab = recup_actuel_playlist();
    if (count($tab) > 0) {
        echo '
    <center>
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
        
        // Lien du lecteur sur autre page
        echo "<p>" . getPlayerTrad()[0]['valeurTrad'] .
                 " :
    <a class='btn btn-link' href='#'
		onClick=\"javascript:window.open('ressources/player.html','popup','width=182,height=102')\">" .
                 getPlayerTrad()[1]['valeurTrad'] . "</a></p>";
    } else {
        echo "Pas de chansons disponibles";
    }
}

