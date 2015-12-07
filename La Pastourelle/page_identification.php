<?php
try {
    checkLoginWithArray($_SESSION, 0);
    exit("Vous êtes déjà connecté sur le site" . footer());
} catch (Exception $e) {
    // do nothing
}

?>
<H1>Identification</H1>
<FORM ACTION="traitement_identification.php" class='login-form'
	METHOD="POST">
	<table class='table'>
		<tr>
			<td>Pseudo</td>
			<td><input type="text" name="pseudo" placeholder="Pseudo" required /></td>
		</tr>
		<tr>
			<td>Mot de passe</td>
			<td><input type="password" name="pass" placeholder="Mot de Passe"
				required /></td>
		</tr>
	</table>
	</a><input class='btn' type="submit" value="Connexion" />
	<div id='msgReturn'></div>
</FORM>
<script language="javascript">
$(document).ready(function () {

    /** Création de type */
    $('.login-form').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire
        var pseudo =$("input[name=pseudo]", form).val();
        var pass =$("input[name=pass]", form).val();
        $('#msgReturn').empty();  // affichage du résultat
        if (pseudo === "" || pass === '') {
        	 $('#msgReturn').append("Les champs doivent être remplis");
        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                data: form.serialize(), // Envoie de toutes les données
                success: function (html) { // Récupération de la réponse
                    $('#msgReturn').append(html);  // affichage du résultat
                    if (html.search("connecté") >= 0) {
                    	history.back();
                    }
                    form.get(0).reset();                    
                }
            });
        }
    });
});

</script>