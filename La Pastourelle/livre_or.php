<?php
// Récupération des textes annexes de traduction pour cette zone
$titre = getTraduction('livre', $_SESSION['lang']);

if (isset($titre["content"]))
    echo "<h1>" . $titre["content"] . "</h1>";
    // Affichage du texte
echo "<div id='livre-container'>";
require 'list_livre_or.php';
echo "</div>";
?>
<form action="livre_or_traitement.php" class='post-form' method="post">
	<p>
		<INPUT type="text" name="nom" placeholder='Nom' required><br>
	</p>
	<P>
		Message<br>
		<textarea name="message" class='form-compteRendu' required></textarea>
	</p>
	<span class="g-recaptcha"
		data-sitekey="6LdtxxETAAAAAHVeSXfnx22t002er0foPHhTADRT"></span> <input
		type="submit" class="btn" value="Envoyer" />
	<div id="ajout-result"></div>
</form>

<script language="javascript">
$(document).ready(function () {

    /** Création de type */
    $('.post-form').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire
        var name =$("input[name=nom]", form).val();
        var message =$("textarea[name=message]", form).val();
        $('#ajout-result').empty();  // affichage du résultat
        if (name === "" || message === '') {
        	 $('#ajout-result').append("Les champs doivent être remplis");
        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                data: form.serialize(), // Envoie de toutes les données
                success: function (html) { // Récupération de la réponse
                    $('#ajout-result').append(html);  // affichage du résultat
                    if (html.search("succès") >= 0) {
                        form.get(0).reset();
                    }
                }
            });
        }
    });
});

</script>