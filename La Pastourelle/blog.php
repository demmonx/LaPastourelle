<?php
verifLoginWithArray ( $_SESSION, 0, true );
try {
	$adminOk = checkLoginWithArray ( $_SESSION, 1 );
} catch ( Exception $e ) {
	$adminOk = false;
}
echo "<h1>Blog</h1>";

// administration intégrée dans la page des blogs
// S'affiche uniquement si l'utilisateur est un administrateur
// pour ajouter de nouvelles photos
if ($adminOk) {
	?>
<h2>Ajouter une image</h2>


<form method="POST" id="post-pic" action="blog_traitement.php"
	enctype="multipart/form-data">
	<br>
	<TEXTAREA name="description" id="desc" placeholder='Description'></TEXTAREA>
	<br> <br> Image : <input type="file" id="uploadFile" name="fichier"
		size="50"> <input type="hidden" name="ac" value="1" /> <input
		class="btn btn-default" type="submit" name="envoyer" value="Publier">
</form>
<hr />
<script type="text/javascript">
$(document).ready(function () {
//Ajout d'une nouvelle photo
$('#post-pic').on('submit', function (e) {

    e.preventDefault(); // Empeche de soumettre le formulaire
    var form = $(this); // L'objet jQuery du formulaire
    var formdata = (window.FormData) ? new FormData(form[0]) : null;
    var data = (formdata !== null) ? formdata : form.serialize();

    var fichier = $('#uploadFile').val();  // fichier

    // Vérifie pour éviter de lancer une requête fausse
    if (fichier === '') {
       alert('Le fichier doit être renseigné');
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
                alert(html);  // affichage du résultat
                // On efface si ok
                if (html.search("succès") >= 0) {
                    $('#uploadFile').val('');
                    $('#desc').val('');
                    $("#list-billet").load("list_blog.php");
                }
            }
        });
    }
});
});</script>
<?php
}
echo "<div id='list-billet'>";
require_once 'list_blog.php';
echo '</div>'?>

