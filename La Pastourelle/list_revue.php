<?php
@session_start();
require_once 'traitement.inc.php';
$adminOK = false;
if (isset($_SESSION['pseudo']) && isset($_SESSION['pass']) &&
         verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    $adminOK = true;
}

if (! $adminOK) {
    exit("Vous n'avez pas les droits requis");
}
echo "<table>";
$tab = recup_revuePresse();
if (count($tab) != 0) {
    
    echo "<tr>";
    
    echo "<th>Titre</th>";
    echo "<th>Supprimer</th>";
    echo "</tr>";
    // mise en forme
    foreach ($tab as $row) {
        echo "<tr>";
        
        echo "<td>" . $row["titre"] . "</td>";
        echo "<td><a class='delete' href='gestion_revue_traitement.php?ac=1&id=" .
                 $row["id"] .
                 "'><img src='/ressources/images/delete.png'/></a></td>";
        echo "</tr>";
    }
}
echo "</table>";
?>
</table>
<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des page
	function refresh() {
        $('#modif-revue').load("list_revue.php");
	}

	$('.delete').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
        // confirmation
        if (confirm("Supprimer l'élément selectionnée ?")) {
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