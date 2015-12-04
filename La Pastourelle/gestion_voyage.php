<?php
@session_start();
verifLoginWithArray ( $_SESSION, 1, true );
?>

<h1>Gestion des voyages</h1>
<h2>Ajouter un voyage</h2>
<form action="gestion_voyage_traitement.php" method="POST" id="formS">

	<select id='continent' name="continent">
		<option value="">Continent</option>
			<?php
			$continents = getContinents ();
			foreach ( $continents as $row )
				echo "<option value=" . $row ['id'] . ">" . $row ['nom'] . "</option>";
			?>		
	</select> <br />
	<select name='pays' id='pays'>
			<?php
			require 'get_pays.php';			
			?>
			
	</select> <br />
	 <input type="text" name="titre" placeholder='Titre' />
			
	<br /><textarea name="texte" class='editor' placeholder="Description"></textarea>

	<br />
	<input class="btn" type="submit" name="envoyer" value="Enregistrer" />
	<div id="msgReturn"></div>

</form>

<h2>Modification des voyages</h2>
<div id="liste-continent">
	<?php
    require "liste_voyage.php";
    ?>
</div>    

<script type="text/javascript">
$(document).ready(function () {

	$('#continent').on('change', function (e) {
        var code = $('#continent').val();
        var url = "get_pays.php";
        if (code !== '') {
            url += "?id=" + code;
        }
        $("#pays").html("");
        $("#pays").load(url);

    });

	// Rafraichit la liste des voyages
	function refresh() {
		$("#liste-continent").load("liste_voyage.php");
	}

	// Ajout d'un nouveau continent
    $('#formS').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire

        var pays = $('select[name=pays]', form).val();  // pays
        var titre = $('input[name=titre]', form).val();
        $('#msgReturn').empty();

        // Vérifie pour éviter de lancer une requête fausse
        if (pays === '' || titre === '' ) {
            $('#msgReturn').append('Tous les champs doivent être renseignés');
        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                data: form.serialize(), // Envoie de toutes les données
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

