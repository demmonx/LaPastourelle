<?php
@session_start();
verifLoginWithArray($_SESSION, 1, true);
    ?>
	<h1>Gestion du diaporama</h1>
	<div id="slideshow">
	<?php
    
    require "inc.slider.php";
    ?>
	</div>
	    <h2>Nouvelle image</h2>
	<form action="traitement_slider.php" method="post"
		enctype="multipart/form-data" id="formS">
		<label for="fichier">Photo : <input type="file" id="uploadFile"
			name="fichier"></label> <input class="btn" type="submit"
			value="Ajouter">
		<div id="msgReturn"></div>
	</form>
	<?php
    echo "<h2>Liste des images</h2>";
    $tab = getDiapos();
    echo "<div  id='list-photos-full'>";
    require_once 'list_photos.php';
    echo "</div>";
    
    ?>


<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des music mais pas le player
	function refresh() {
		$("#list-photos-full").load("list_photos.php");
		$("#slideshow").load("inc.slider.php");
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
                    if (html.search("succès") >= 0) {
                        $('#uploadFile').val('');
                        refresh();
                    }
                }
            });
        }
    });
});
</script>