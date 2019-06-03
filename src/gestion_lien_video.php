<?php
verifLoginWithArray($_SESSION, 1, true);
?>
<h1>Administration des vidéos</h1>
<h2>Ajout d'un lien</h2>
<form method="post" id="newLink" action="traitement_lien_video.php">
	<input type="text" name="nom" placeholder="Nom" required /><br /> <input
		type="text" name="url" placeholder="URL" required /> <br /> <input class='btn' type="submit" value="Ajouter" />
</form>
<div id='ajout-result'></div>


<h2>Gestion des liens</h2>
<div id='lien-container'>
		<?php require 'list_lien_video.php'; ?>
	</div>


<script language="javascript">
$(document).ready(function () {

	/** Validation d'une adresse mail */
	function isUrlValid(url) {
	    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
	}
	
    /** Création de type */
    $('#newLink').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire
        var name =$("input[name=nom]", form).val();
        var url =$("input[name=url]", form).val();
        $('#ajout-result').empty();  // affichage du résultat
        if (name === "" || url === '' ) {
        	 $('#ajout-result').append("Les champs doivent être remplis");
        }else if (!isUrlValid(url)) {
       	 $('#ajout-result').append("L'adresse mail doit être valide");
       } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                data: form.serialize(), // Envoie de toutes les données
                success: function (html) { // Récupération de la réponse
                    $('#ajout-result').append(html);  // affichage du résultat
                    $('#lien-container').load("list_lien_video.php");
                    if (html.search("succès") >= 0) {
                        form.get(0).reset();
                    }
                }
            });
        }
    });
});

</script>
