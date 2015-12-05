<?php
verifLoginWithArray($_SESSION, 1, true);

// récupération des informations à ajouter dans la page
$coord = getCoordonnees();
?>
<h1>Coordonnées</h1>

<form action="traitement_coord.php" method="post"
	enctype="multipart/form-data" id="formS">
	<table class='table table-bordered'>
		<tr>
			<th>Téléphone</th>
			<td><input type='text'
				value='<?php echo isset($coord['tel']) ? $coord['tel'] : ""; ?>'
				name='tel' required /></td>
		</tr>
		<tr>
			<th>Adresse</th>
			<td>
			<?php

echo "<textarea name='adresse' class='form-compteRendu' required>" .
         (isset($coord['adr']) ? stripnl2br2($coord['adr']) : "") .
         "</textarea></td>";
?>
		
		
		
		
		
		
		</tr>
		<tr>
			<th>Carte</th>
			<td><?php echo isset($coord['img']) ? $coord['img'] : ""; ?>
			<input type="file" id="uploadFile" name="fichier"></td>
		</tr>
		<tr>
			<th>Mail</th>
			<td><input type='text'
				value='<?php echo isset($coord['mail']) ? $coord['mail'] : ""; ?>'
				name='mail' required /></td>
		</tr>
	</table>
	<input type="submit" class='btn' value='Modifier' />
	<div id='msgReturn'></div>
	'
</form>

<script type="text/javascript">
$(document).ready(function () {


	// Ajout d'une nouvelle musique
    $('#formS').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire
        var formdata = (window.FormData) ? new FormData(form[0]) : null;
        var data = (formdata !== null) ? formdata : form.serialize();

        var fichier = $('#uploadFile').val();  // fichier
        $('#msgReturn').empty();

        // Vérifie pour éviter de lancer une requête fausse
         var tel = $("input[name=tel]", form).val();  
        var adresse = $("textarea[name=adresse]", form).val();  
        var mail = $("input[name=mail]", form).val();  

        // Regex de test l'adresse mail
        var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
        $('#msgReturn').empty();
        // Vérifie pour éviter de lancer une requête fausse
        if ( mail === '' || tel === '' || adresse === '') {
            $('#msgReturn').append('Les champs doivent êtres remplis');
        } else if (!reg.test(mail)) {
            	$('#msgReturn').append("L'adresse mail doit être valide");       
        }else if (isNaN(tel) || tel.length != 10) {
        	$('#msgReturn').append('Le numéro de téléphone doit être valide');  
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
                }
            });
        }
    });
});
</script>
