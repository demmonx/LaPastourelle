<?php
checkLoginWithArray ( $_SESSION, 1 );

echo "<h1>Gestion des musiques</h1>";
echo "<div id='player-content'>";
require 'inc.player.php';
echo "</div>";

?>
<!--Formulaire d'ajout d'une musique-->
<h2>Nouvelle musique</h2>


<form action="traitement_player.php" method="post"
	enctype="multipart/form-data" class="formS">
	<label for="fichier">Musique à ajouter : </label><input type="file"
		name="fichier" id="uploadFile"><br /> <input type="text" name="nom"
		id="titre" placeholder='Titre'><br /> <input type="text" name="band" id="groupe"
		placeholder='Groupe'><br /><br /> <input type="submit" class='btn'
		value="Ajouter">
	<div id="msgReturn"></div>

</form>
<?php 
// Génération de la liste pour l'admin
echo "<h2>Listes des musiques</h2>";
echo "<div id='liste-player-full'>";
	require_once 'list_music.php';
echo '</div>';

?>
<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des music mais pas le player
	function refresh() {
		$("#liste-player-full").load("list_music.php");
		$("#player-content").load("inc.player.php");
	}

	// Ajout d'une nouvelle musique
    $('.formS').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire
        var formdata = (window.FormData) ? new FormData(form[0]) : null;
        var data = (formdata !== null) ? formdata : form.serialize();

        var fichier = $('#uploadFile').val();  // fichier
        var titre = $('#titre').val(); 
        var groupe = $('#groupe').val(); 
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
                        $('#titre').val('');
                        $("#groupe").val('');;
                        refresh();
                    }
                }
            });
        }
    });
});
</script>
