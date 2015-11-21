<?php
@session_start();
@header('Content-Type: text/html; charset=utf-8');
require_once "traitement.inc.php";
if (! isset($_SESSION['pseudo']) || ! isset($_SESSION['pass']) ||
         ! verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {
    exit("Vous n'avez pas les droits requis");
} // else
  
// récupération des info dans la BD et traitement
$tab_planning = getPlanning();

/**
 * tableau du planning
 */
echo "
		<TABLE class='table table-bordered table-striped'>
			<TR>
				<TH>JOUR</TH>
				<TH>DATE</TH>
				<TH>LIEU</TH>
				<TH>MUSICIENS</TH>";
if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    echo "<TH colspan='3'>Actions</TH>";
} // Ajout des colones de suppression
echo "</TR>";
$adminOK = false;
if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    $adminOK = true;
}
foreach ($tab_planning as $row) {
    $un_jour = $row["jour"];
    $une_date = $row["date"];
    $un_lieu = $row["lieu"];
    $un_musiciens = $row["joueur"];
    $unId = $row["id"];
    
    // traitement de la date pour l'afficher de la forme jj/mm/aaaa
    $morceau_date = explode("/", $une_date);
    $jour = $morceau_date[2];
    $mois = $morceau_date[1];
    $annee = $morceau_date[0];
    $une_date = $jour . "/" . $mois . "/" . $annee;
    
    echo "<TR><TD>" . $un_jour . "</TD><TD>" . $une_date . "</TD><TD>" . $un_lieu .
             "</TD><TD>" . $un_musiciens . "</TD> ";
    if ($adminOK) {
        echo "<TD><A class='delete btn btn-link' HREF='planning_traitement.php?ac=1&id=" .
                 $unId .
                 "'><img src='ressources/images/delete.png' alt='Supprimer' /> </A> </TD>
			      <TD><A class='btn btn-link' HREF='index.php?page=modifDatePlanning&id=" .
                 $unId . "'> Modifier</A></TD>";
    }
}

echo "</TABLE>";
?>
<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des music mais pas le player
	function refresh() {
        $('#planning-container').load("list_planning.php");
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