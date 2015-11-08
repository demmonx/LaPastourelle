<?php
if (! isset($_SESSION['pseudo']) or ! isset($_SESSION['pass']) or
         ! verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    echo "<center>
			Vous ne pouvez pas accéder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
    exit(0);
} else {
    ?>
<center>
	<div id="slideshow">
	<?php
    
    require "slider.inc.php";
    ?>
	</div>
	<?php
    echo "<h1>Liste des images : </h1>";
    $tab = recup_all_diapos();
    if (count($tab) > 0) {
        echo "<table class='table table-bordered' id='list-photos-full'>";
        require_once 'list_photos.php';
        echo "</table>";
    } else {
        echo "Aucune image n'a été trouvée";
    }
    
    echo "<h1>Ajouter une nouvelle image : </h1>";
    ?>
	<form action="slider_traitement.php" method="post"
		enctype="multipart/form-data" id="formS">
		<label for="fichier">Photo : <input type="file" id="uploadFile"
			name="fichier"></label> <label> <input class="btn btn-info"
			type="submit" value="Ajouter"></label>
		<div id="msgReturn"></div>
	</form>
</center>

<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des music mais pas le player
	function refresh() {
		$("#list-photos-full").load("list_photos.php");
		$("#slideshow").load("slider.inc.php");
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
<?php
}
?>