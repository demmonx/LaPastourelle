<?php
// récupération du titre de la page
// récupération du titre de la page
$titre = getTraduction("avis", $_SESSION['lang']);
if (isset($titre["content"]))
    echo "<h1>" . $titre["content"] . "</h1>";
?>

<FORM method="POST" action="traitement_avis.php" id='avis-post'>
	<p>
		<INPUT type="text" name="nom" placeholder='Nom' required><br> <INPUT
			type="text" name="email" placeholder='@email' required><br>
	</p>
	<P>
		Message<br>
		<textarea name="message" class='form-compteRendu' required></textarea>
	</p>
	<span class="g-recaptcha"
		data-sitekey="6Lf7kxITAAAAAOvjPQ9UKCgwZ0B3l-UztVdvWr_t"></span> <input
		class='btn' type="submit" value="Envoyer" />
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
                    if (html.search("succès") >= 0) {
                    	form.get(0).reset();
                    	grecaptcha.reset();
                    }
                }
            });
        }
    });
});

</script>
