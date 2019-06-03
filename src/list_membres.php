<?php
@session_start();
require_once 'inc.function.php';
verifLoginWithArray($_SESSION, 1);
$tab_membre = getUsers();
$cpt = 0;
if (count($tab_membre) == 0) {
    echo "Aucun membre disponible";
} else {
    
    echo "
	<DIV id='liens'>
		<TABLE class='table table-bordered' >
			<TR>
					<TH>Nom</TH>
					<TH>Prénom</TH>
					<TH>Pseudo</TH>
					<TH>E-mail</TH>
					<TH>Téléphone</TH>
					<TH>Adresse</TH>
			</TR>";
    
    foreach ($tab_membre as $row) {
        echo "<TR>
					<TD><B>" . $row['nom'] . "</B></TD>";
        echo "	<TD><B>" . $row['prenom'] . "</B></TD>";
        echo "	<TD>" . $row['pseudo'] . "</TD>";
        echo "	<TD>" . $row['email'] . "</TD>";
        echo "	<TD>" . $row['telephone'] . "</TD>";
        echo "	<TD>" . $row['adresse'] . "</TD>";
        echo "<TD><A class='delete-membre' href='traitement_demande.php?id=" .
                 $row['id'] . "&ac=4'><i class='fa fa-close fa-2x'></i></A></TD>";
        echo "</TR>";
    }
    
    echo "
		</TABLE>
	</DIV>";
}
?>
<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des music mais pas le player
	function refresh() {
        $('#container-membre').load("list_membres.php");
	}

	$('.delete-membre').on('click', function (e) {
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


});
</script>