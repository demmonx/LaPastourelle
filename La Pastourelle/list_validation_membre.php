<?php
@session_start();
require_once 'traitement.inc.php';
verifLoginWithArray($_SESSION, 1);
$aValider = getUnvalitedMember();
if (count($aValider) == 0) {
    echo ("Il n'y a aucun membre en attente");
} else {
    echo "
	<div id='liens'>
		<table class='table table-bordered' >";
    echo "
			<tr>";
    echo "
				<th>Nom</th>
				<th>Prénom</th>
				<th>Pseudo</th>
				<th>Email</th>
				<th>Telephone</th>
				<th>Adresse</th>
				<th colspan='2'>Gestion</th>";
    echo "
			</tr>";
    foreach ($aValider as $row) { // $membNoValid =
                                  // $req_membNoValid->fetch()) {
        echo "
			<tr>";
        echo "
				<td>" . $row['nom'] . "</td>
				<td>" . $row['prenom'] . "</td>
				<td>" . $row['pseudo'] . "</td>
				<td>" . $row['email'] . "</td>
				<td>" . $row['telephone'] . "</td>
				<td>" . $row['adresse'] . "</td>";
        echo "
				<td>
					<a class='valid-membre' href='demande_traitement.php?id=" . $row['id'] . "&ac=3'><i class='fa fa-check fa-2x'></i></a>
				</td>";
        echo "
				<td>
					<a class='delete-membre-valid' href='demande_traitement.php?id=" .
                 $row['id'] . "&ac=4'><i class='fa fa-close fa-2x'></i></a>
				</td>";
        echo "
			</tr>";
    }
    echo "
		</table>
	</div>";
}
?>
<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des music mais pas le player
	function refresh() {
        $('#container-membre-valid').load("list_validation_membre.php");
        $('#container-membre').load("list_membre_actif.php");
	}

	$('.delete-membre-valid').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
        // confirmation
        if (confirm("Supprimer le membre selectionné ?")) {
            // requete de suppression
            $.ajax({
                url: $(this).attr("href"),
                type: 'GET',
                success: function (html) { // Récupération de la réponse
                    // recharge la liste des images si ok
                    if (html.search("supprimé") >= 0) {
                        refresh();
                    } else {
                   	 alert(html);                   
                    }
                }
            });
        }
    });

	$('.valid-membre').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
            // requete de validation
            $.ajax({
                url: $(this).attr("href"),
                type: 'GET',
                success: function (html) { // Récupération de la réponse
                    // recharge la liste des images si ok
                    if (html.search("validé") >= 0) {
                        refresh();
                    } else {
                   	 alert(html);                   
                    }
                }
            });
    });


});
</script>