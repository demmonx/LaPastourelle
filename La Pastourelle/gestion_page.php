<?php
verifLoginWithArray($_SESSION, 1);
?>
<h1>Administration des pages</h1>
<h4>Création d'une page</h4>
<form method="post" id="newPage" action="gestion_page_traitement.php">
	<input type="text" name="nom" id='nomPage' placeholder="Nom" required /><br />
	<input type="submit" value="Créer" />
</form>
<div id='ajout-result'></div>

<h4>Gérer les pages</h4>
<div id='modif-page'>
		<?php require 'list_page.php'; ?>
	</div>

<script language="javascript">
$(document).ready(function () {

    /** Création de type */
    $('#newPage').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire
        var name =$("#nomPage").val();
        $('#ajout-result').empty();  // affichage du résultat
        if (name === "") {
        	 $('#ajout-result').append("Les champs doivent être remplis");
        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                data: form.serialize(), // Envoie de toutes les données
                success: function (html) { // Récupération de la réponse
                    $('#ajout-result').append(html);  // affichage du résultat
 
                    $('#modif-page').load("list_page.php");
                    $("#nomPage").val('');
                }
            });
        }
    });
});

</script>