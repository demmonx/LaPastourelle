<?php
require 'player.inc.php';
getPlayer();

$adminOK = false;
if (isset($_SESSION['pseudo']) && isset($_SESSION['pass']) &&
         verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    $adminOK = true;
}

if ($adminOK) {
    $tab = recup_all_music();
    if (count($tab) != 0) {
        // Génération de la liste pour l'admin
        echo "<h1>Listes des fichiers audio : </h1>";
        echo "<table id='liste-player-full'>";
        require_once 'list_music.php';
        echo '</table>';
    }
    
    ?>
<!--Formulaire d'ajout d'une musique-->
<h1>Ajout d'une chanson :</h1>

</center>
<form action="player_traitement.php" method="post"
	enctype="multipart/form-data" class="formS" style="margin-left: 200px;">
	<label for="fichier">Musique à ajouter : </label><input type="file"
		name="fichier" id="uploadFile"><br /> <label for="nom">Titre : </label><input
		type="text" name="nom" id="titre"><br /> <label for="band">Chanteur/Groupe
		: </label><input type="text" name="band" id="groupe"><br />
	<center>
		<input type="submit" value="Ajouter">
		<div id="msgReturn"></div>

</form>
<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des music mais pas le player
	function refresh() {
		$("#liste-player-full").load("list_music.php");
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
                    if (html === "Ajout effectué avec succès") {
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
<?php
}
?>
