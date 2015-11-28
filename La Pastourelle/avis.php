<?php
// récupération du titre de la page
// récupération du titre de la page
$titre = getTraduction("avis_titre", $_SESSION['lang']);
if (isset($titre["valeurtrad"]))
    echo "<h1>" . $titre["valeurtrad"] . "</h1>";
?>

<FORM method="POST" action="avis_traitement.php" id='avis-post'>
	<table>
		<tr>
			<td>Nom</td>
			<td><INPUT type="text" name="nom" required></td>

		</tr>
		<tr>
			<td>Mail</td>
			<td><INPUT type="text" name="email" required></td>
		</tr>
	</table>
	<P>
		Message :<br>
		<textarea name="message" class='form-compteRendu' required></textarea>
	</p>
	<span class="g-recaptcha" data-sitekey="6LdtxxETAAAAAHVeSXfnx22t002er0foPHhTADRT"></span>
	<input type="submit" value="Envoyer" />
	<div id='msgReturn'></div>
</form>

<script language="javascript">
$(document).ready(function () {
    /** * Formulaire de connexion ** */
    $('#avis-post').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire

        // Récupération des valeurs
        var nom = $("input[name=nom]", form).val();  
        var message = $("textarea[name=message]", form).val();  
        var mail = $("input[name=email]", form).val();  

        // Regex de test l'adresse mail
        var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
        $('#msgReturn').empty();
        // Vérifie pour éviter de lancer une requête fausse
        if ( mail === '' || nom === '' || message === '') {
            $('#msgReturn').append('Les champs doivent êtres remplis');
        } else if (!reg.test(mail)) {
            	$('#msgReturn').append("L'adresse mail doit être valide");         
        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                data: form.serialize(), // Envoie de toutes les données
                success: function (html) { // Récupération de la réponse
                    $('#msgReturn').append(html);  // affichage du résultat
                    if (html === "Le message a été envoyé avec succès" ) {
                    	form.get(0).reset();
                    }
                }
            });
        }
    });
});

</script>
