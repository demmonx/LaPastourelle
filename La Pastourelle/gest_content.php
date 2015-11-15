<?php
@session_start();
@header('Content-Type: text/html; charset=utf-8');
require_once 'traitement.inc.php';
if (! isset($_SESSION['pseudo']) or ! isset($_SESSION['pass']) or
         ! verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    exit("Vous n'avez pas les droits requis");
} // else

?>
<!--  Formulaire d'ajout de contenu -->
<h2>Ajouter un contenu</h2>
<form method='post' id='formS' action='gest_content_traitement.php'
	enctype="multipart/form-data">
	<input type="radio" name="type" value='img' checked> Image <input
		type="radio" name="type" value='video'> Vidéo<br> <label for="fichier">Photo
		: <input type="file" id="uploadFile" name="fichier">
	</label><input class="btn btn-info" type="submit" value="Ajouter">
	<div id='msgReturn'></div>

</form>

<div id='list-ressources'>
<?php require 'list_file.php'?>
</div>
<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des music mais pas le player
	function refresh() {
		$("#list-ressources").load("list_file.php");
	}

	// Ajout d'une nouvelle musique
    $('#formS').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire
        var formdata = (window.FormData) ? new FormData(form[0]) : null;
        var data = (formdata !== null) ? formdata : form.serialize();

        var fichier = $('#uploadFile').val();  // fichier
        $('#msgReturn').empty();

        // Vérifie pour éviter de lancer une requête fausse
        if (fichier === '') {
            $('#msgReturn').append('Le fichier doit être renseigné');
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
                    $('#msgReturn').append(html);  // affichage du résultat
                    // On efface si ok
                    if (html === "Ajout effectué avec succès") {
                        $('#uploadFile').val('');
                        refresh();
                    }
                }
            });
        }
    });
});
</script>