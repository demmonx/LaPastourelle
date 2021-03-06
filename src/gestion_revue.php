<?php
verifLoginWithArray($_SESSION, 1, true);
?>
<h1>Gestion des revues</h1>
<h2>Ajout d'une revue</h2>
<form method="post" id="newRevue" action="traitement_revue.php"
	enctype="multipart/form-data">
	<label for="fichier">Photo : <input type="file" id="uploadFile"
		name="fichier"></label> <input type="text" name="titre" id='titre'
		placeholder="Titre" required /><br /> <input class='btn' type="submit"
		value="Ajouter" />
</form>
<div id='ajout-result'></div>

<h2>Modifier les revues</h2>
<div id='modif-revue'>
		<?php require 'list_revue.php'; ?>
	</div>


<script language="javascript">
$(document).ready(function () {

	// Ajout d'une nouvelle photo
    $('#newRevue').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire
        var formdata = (window.FormData) ? new FormData(form[0]) : null;
        var data = (formdata !== null) ? formdata : form.serialize();

        var fichier = $('#uploadFile').val();  // fichier
        var titre = $('#titre').val();  // fichier
        $('#ajout-result').empty();
        // Vérifie pour éviter de lancer une requête fausse
        if (titre ==='' || fichier === '') {
        	$('#ajout-result').append('Les champs doivent être remplis');
        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                enctype: 'multipart/form-data',
                contentType: false, // obligatoire pour de l'upload
                processData: false, // obligatoire pour de l'upload
                data: data, // Envoie de toutes les données
                success: function (html) { // Récupération de la réponse
                	$('#ajout-result').append(html);  // affichage du résultat
                    // On efface si ok
                    if (html.search("succès") >= 0) {
                        $('#uploadFile').val('');
                        $('#titre').val('');
                        $("#modif-revue").load("list_revue.php");
                    }
                }
            });
        }
    });
});

</script>
