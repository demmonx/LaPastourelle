<?php
verifLoginWithArray($_SESSION, 1);
?>
<h1>Administration de l'actualité</h1>
<h2>Création d'un type d'actualité</h2>
<form method="post" id="newType" action="actu_type_maj.php">
	<input type="text" name="nom" id='nomType' placeholder="Nom" required /><br />
	<input type="submit" value="Créer" />
</form>
<div id='ajout-result'></div>

<h2>Modifier les types d'actualité</h2>
<div id='modif-type'>
		<?php require 'list_actu_type.php'; ?>
	</div>

<h2>Modifier le contenu</h2>

<div id='actu-container'>
		<?php require 'list_actu.php'; ?>
	</div>


<script language="javascript">
$(document).ready(function () {

    /** Création de type */
    $('#newType').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire
        var name =$("#nomType").val();
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
                    $('#actu-container').load("list_actu.php");
                    $('#modif-type').load("list_actu_type.php");
                    $("#nomType").val('');
                }
            });
        }
    });
});

</script>
