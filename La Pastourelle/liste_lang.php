<?php
@session_start();
require_once 'traitement.inc.php';
verifLoginWithArray($_SESSION, 1);

$supported_lang = getSupportedLanguages();
$allLang = getLanguages();
// Affichage du drapeau correspondant
if (count($allLang) > 1) {
    echo '<table><tr><th>Langue</th><th>Action</th><th>Support</th></tr>';
    foreach ($allLang as $lang) {
        
        // Vérifie si la langue est supporté ou pas
        $support = $supported_lang[array_search($lang["id"], $supported_lang)] ==
                 $lang["id"];
        // Si c'est bon on affiche un check
        $support_link = "<i class='fa fa-check fa-2x'></i>";
        // Sinon bug + lien de modif
        $unsupport_link = "<i class='fa fa-bug fa-2x'></i>";
        
        // Affichage tableau
        echo "<tr>";
        echo "<td>" . $lang["name"] . "</td>";
        echo "<td><a class='delete' href='lang_maj_traitement.php?ac=1&id=" .
                 $lang["id"] . "'><i class='fa fa-close fa-2x'></i></a></td>";
        echo "<td><a target='blank' href='index.php?page=gestion_titre&lang=" .
                 $lang['id'] . "'>" .
                 ($support ? $support_link : $unsupport_link) . "</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<br /><br /><b>Aucune langue à  supprimer</b>";
}
?>

<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des langues
	function refresh() {
		$("#liste-lang").load("liste_lang.php");
	}

	$('.delete').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
        // confirmation
        if (confirm("Supprimer la langue selectionnée ?")) {
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
    
});
</script>