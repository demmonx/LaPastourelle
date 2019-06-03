<?php
require_once 'inc.function.php';

/**
 * Retourne le lecteur audio
 */
function getPlayer ()
{
    $tab = getPlaylist();
    if (count($tab) > 0) {
        ?>

<div class="player">
<div class='container-fluid'>
	<div class="pl"></div>
	<div>
		<strong class="title"></strong>
	</div>
	<div class="artist"></div>
	<table class="controls-player">
		<tr>
			<td class="rew"><i class="fa fa-step-backward fa-2x"></i></td>
			<td><span class="pause"><i class="fa fa-pause fa-2x"></i></span><span
				class="play"><i class="fa fa-play fa-2x"></i></span></td>
			<td class="fwd"><i class="fa fa-step-forward fa-2x"></i></td>
		</tr>
	</table>
		</div>
	<div class='row'>
		<div class='col-md-1'>
			<i class="fa fa-hourglass fa-2x"></i>
		</div>
		<div class="tracker col-md-10"></div>
	</div>
	<div class='row'>
		<div class='col-md-1'>
			<i class="fa fa-volume-up fa-2x"></i>
		</div>
		<div class="volume col-md-10"></div>
	</div>

	<h2 class='spoiler'>Liste de lecture (<?php echo count($tab)?>) <i
			class='fa fa-plus-square-o'></i>
	</h2>
	<ul class="playlist spoiler-hidden">
        <?php
        // Génération de la playlist
        foreach ($tab as $row) {
            echo "<li audiourl='" . $row["lien"] . "' artist='" . $row["groupe"] .
                     "'>" . $row["titre"] . "</li>";
        }
        echo "</ul>";
        echo "<script type='text/javascript' src='ressources/js/player.js'></script>";
        echo "<script type='text/javascript' src='ressources/js/spoiler.js'></script>";
    } else {
        echo "Pas de chansons disponibles";
    }
    echo "</div>";
}

getPlayer();
?>
