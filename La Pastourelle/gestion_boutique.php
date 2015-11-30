<?php
verifLoginWithArray($_SESSION, 1);
?>
<h1>Administration de la boutique</h1>
<h2>Ajout d'un produit</h2>
<form method="post" id="newType" action="produit_maj.php">
	<input type="text" name="nom" id='nomProd' placeholder="Nom" required /><br />
	<input type="number" name="prix" step='0.01' id='prixProd'
		placeholder="Prix en €" required /><br /> <input type="submit"
		value="Ajouter" />
</form>
<div id='ajout-result'></div>

<h2>Modifier les produits</h2>
<div id='modif-produit'>
		<?php require 'list_produit.php'; ?>
	</div>

<h2>Modifier les descriptions des produits</h2>

<div id='boutique-container'>
		<?php require 'list_boutique.php'; ?>
	</div>


<script language="javascript">
$(document).ready(function () {

    /** Création de type */
    $('#newType').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire
        var name =$("#nomProd").val();
        var prix =$("#prixProd").val();
        $('#ajout-result').empty();  // affichage du résultat
        if (name === "" || prix === '') {
        	 $('#ajout-result').append("Les champs doivent être remplis");
        } else if (isNaN(prix) || prix <= 0) {
        	$('#ajout-result').append("Le prix n'est pas valide");
        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                data: form.serialize(), // Envoie de toutes les données
                success: function (html) { // Récupération de la réponse
                    $('#ajout-result').append(html);  // affichage du résultat
                    $('#boutique-container').load("list_boutique.php");
                    $('#modif-produit').load("list_produit.php");
                    if (html.search("succès") >= 0) {
                        form.get(0).reset();
                    }
                }
            });
        }
    });
});

</script>
