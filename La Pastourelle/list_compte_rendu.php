<?php
@session_start ();
require_once "traitement.inc.php";
if (! isset ( $_SESSION ['pseudo'] ) or ! isset ( $_SESSION ['pass'] ) or ! verifLo ( $_SESSION ['pseudo'], $_SESSION ['pass'] )) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect ( "index.php?page=accueil", 3 );
	exit ( 0 );
} // else
$list = getCompteRendu ();
$admin = verifLoAdmin ( $_SESSION ['pseudo'], $_SESSION ['pass'] );
// Affichage du titre
if ($admin) {
	echo '<center><H2>Compte rendu des réunions précédentes</H2></center>';
} else {
	echo "<center><H2>COMPTE RENDU DE REUNION, D'ASSEMBLEE GENERALE, ...</H2></center>";
}

// Affichage de chaque compte rendu
if (count ( $list ) == 0) {
	echo "Aucun compte rendu à afficher";
}
foreach ( $list as $row ) {
	echo " <div>";
	if ($admin) {
		$delete_img = "<a class='delete' href='compte_rendu_traitement.php?ac=1&id=" . $row ["id"] . "'><img src='/ressources/images/delete.png'/></a>";
		echo $delete_img . " ";
	}
	echo "Compte rendu du " . date ( "j-M-Y", strtotime ( $row ['date'] ) ) . " : <button class='spoiler'>Afficher / Masquer</button>
        	<div class='spoiler-hidden' >";
	// Formulaire de modification
	if ($admin) {
		echo "
				  <FORM method='post' action='compte_rendu_traitement.php' class='update'>
					Modifier le compte rendu : <BR>
                    <input type='hidden' value='" . $row ["id"] . "' name='id' />
					<textarea class='form-compteRendu' name='content' rows='15' cols='20'>" . stripnl2br2 ( ($row ["txt"]) ) . "</textarea><br />
					<input class='btn' type='submit' value='Modifier'>
				  </FORM>";
	} else {
		echo "
				  <div >" . nl2br ( html_entity_decode ( decodeREGEX ( $row ["txt"] ) ) ) . "</div>";
	}
	echo "</div></div>";
}

?>
<!-- On appelle la fonction spoiler ici, sinon elle ne trouve pas les éléments -->
<script type="text/javascript">
$(document).ready(function () {

    /*** Spoiler ***/
    // Clique sur élément
    $(".spoiler").click(function () {
        $(this).next().toggle(0); // inverse l'état de l'élément suivant en 4ms
        return false;  // bloque la fonction par défaut
    });

	$('.delete').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
        // confirmation
        if (confirm("Supprimer l'élément selectionnée ?")) {
            // requete de suppression
            $.ajax({
                url: $(this).attr("href"),
                type: 'GET',
                success: function (html) { // Récupération de la réponse
                   	 alert(html); 
                   	 refresh();                  
                    
                }
            });
        }
    });


	function refresh() {
		$("#list-cr").load("list_compte_rendu.php");
		}

    
    $('.update').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire

        // Récupération des valeurs
        var content = $("textarea[name=content]", form).val();
        // Vérifie pour éviter de lancer une requête fausse
        if (content === '') {
            alert('Les champs doivent êtres remplis');
        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                data: form.serialize(), // Envoie de toutes les données
                success: function (html) { // Récupération de la réponse
                    alert(html);
                }
            });
        }
    });
});
</script>
