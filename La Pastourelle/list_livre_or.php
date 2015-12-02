<?php
@session_start();
require_once 'traitement.inc.php';
try {
	$adminOk = checkLoginWithArray($_SESSION, 1);
} catch (Exception $e) {
	$adminOk = false;
}
$message = getMessageActifLivre();
if (count($message) <= 0) {
    echo "Aucun message à afficher";
}
foreach ($message as $row) {
    echo "<p>";
    if ($adminOk) {
        echo "<a class='delete' href='livre_or_traitement.php?ac=1&id=" .
         $row['id'] . "'><i class='fa fa-close fa-2x'></i></a> ";
    }
    echo "<span >";
    // Traduit le format de date anglais en format français
    $dateAN = htmlspecialchars($row['date']);
    list ($annee, $mois, $jour) = explode('-', $dateAN);
    $dateFr = $jour . "/" . $mois . "/" . $annee;
    echo "Le " . $dateFr . " :<br />";
    echo "</span>";
    
    echo nl2br(html_entity_decode($row['message']));
    echo "</p>";
    echo "<hr/>";
}
?>

<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des music mais pas le player
	function refresh() {
        $('#livre-container').load("list_livre_or.php");
	}

	$('.delete').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
        // confirmation
        if (confirm("Supprimer l'élément selectionné ?")) {
            // requete de suppression
            $.ajax({
                url: $(this).attr("href"),
                type: 'GET',
                success: function (html) { // Récupération de la réponse
                    // recharge la liste des images si ok
                    if (html.search("succès") >= 0) {
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