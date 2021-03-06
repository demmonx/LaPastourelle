<?php
verifLoginWithArray($_SESSION, 1, true);
?>

<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des langues
	function refresh() {
		$("#liste-lang").load("list_lang.php");
	}

	// Ajout d'une nouvelle musique
    $('#formS').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire
        var formdata = (window.FormData) ? new FormData(form[0]) : null;
        var data = (formdata !== null) ? formdata : form.serialize();

        var lang = $('#nom-lang').val();  // nom
        var fichier = $('#uploadFile').val();  // fichier
        $('#msgReturn').empty();

        // Vérifie pour éviter de lancer une requête fausse
        if (fichier === '' || lang === '') {
            $('#msgReturn').append('Tous les champs doivent être renseignés');
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
						 form.get(0).reset();
                         refresh();
                    }
                }
            });
        }
    });
});
</script>

<h1>Gestion des langues</h1>
	<h2>Ajout d'une langue</h2>

<div class="identification">
	<form class="form-horizontal" action="traitement_lang.php"
		method="POST" id="formS" enctype="multipart/form-data">

		<label class="control-label" for="nom">Langue</label> <select
			id="nom-lang" name="lang">
			<option value="">-- Choix --</option>
			<?php
$lang = getAllLanguages();
foreach ($lang as $row) {
    echo "<option value=" . $row['id'] . ">" . $row["name"] . "</option>";
}
?>
		</select> <br><label class="control-label" for="fichier">Drapeau</label><input
			type="file" name="fichier" size="20" id='uploadFile' /> <input
			class="btn" type="submit" name="envoyer" value="Enregistrer" />
		<div id="msgReturn"></div>
	</form>
</div>

<hr />

<h2>Langues existantes</h2>
<div class="identification" id="liste-lang">
				<?php
    require "list_lang.php";
    ?>
</div>