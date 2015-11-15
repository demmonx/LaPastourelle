<?php
@session_start();
require_once 'traitement.inc.php';
$adminOK = false;
if (isset($_SESSION['pseudo']) && isset($_SESSION['pass']) &&
         verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    $adminOK = true;
}

if ($adminOK) {
    $tab = recup_all_music();
    if (count($tab) != 0) {
        
        echo "<tr>";
        
        echo "<th>Titre</th>";
        echo "<th>Artiste</th>";
        echo "<th>Statut</th>";
        echo "<th>Activer / Désactiver</th>";
        echo "<th>Supprimer</th>";
        echo "</tr>";
        // mise en forme
        foreach ($tab as $row) {
            echo "<tr>";
            
            echo "<td>" . $row["titre"] . "</td>";
            echo "<td>" . $row["groupe"] . "</td>";
            echo "<td>" . ($row["statut"] == 'A' ? "Activé" : "Désactivé") .
                     "</td>";
            echo "<td><a class='statut' href='player_traitement.php?ac=1&id=" .
                     $row["id"] . "'>" .
                     ($row["statut"] == 'A' ? "Désactiver" : "Activer") .
                     "</a></td>";
            echo "<td><a class='delete' href='player_traitement.php?ac=2&id=" .
                     $row["id"] .
                     "'><img src='/ressources/images/delete.png'/></a></td>";
            echo "</tr>";
        }
    }
}
?>
<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des music mais pas le player
	function refresh() {
		$("#liste-player-full").load("list_music.php");
		$("#player-content").load("player.inc.php");
	}

	$('.delete').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
        // confirmation
        if (confirm("Supprimer la musique selectionnée ?")) {
            // requete de suppression
            $.ajax({
                url: $(this).attr("href"),
                type: 'GET',
                success: function (html) { // Récupération de la réponse
                    // recharge la liste des images si ok
                    if (html === "Suppression effectuée avec succès") {
                        refresh();
                    } else {
                        alert(html);
                    }
                    
                }
            });
        }
    });

	// Inverse le statut
    $('.statut').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
        // requete de modification
        $.ajax({
            url: $(this).attr("href"),
            type: 'GET',
            success: function (html) { // Récupération de la réponse
                // recharge la liste des images si ok
                if (html === "Mise à jour effectuée avec succès") {
                    refresh();
                } else {
                    alert(html);
                }
                
            }
        });
    });
});
</script>