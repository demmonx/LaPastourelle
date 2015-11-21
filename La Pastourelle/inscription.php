<?php
$cryptinstall = "./cryptographp.fct.php";
require_once $cryptinstall;
?>
<script language="javascript">
$(document).ready(function () {
    /** * Formulaire de connexion ** */
    $('#inscription').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire

        // Récupération des valeurs
        var pseudo = $('#pseudo').val();  
        var code = $('#code').val();  
        var mail = $('#mail').val();  
        var nom = $('#nom').val();  
        var prenom = $('#prenom').val(); 
        var tel = $('#tel').val();  
        var adresse = $('#adresse').val(); 
        var pass = $('#mdp').val(); 

        // Regex de test l'adresse mail
        var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
        $('#msgReturn').empty();
        // Vérifie pour éviter de lancer une requête fausse
        if (pseudo === '' || pass === '' || code === '' || mail === '' || nom === '' 
            || prenom === '' || tel === '' || adresse === '') {
            $('#msgReturn').append('Les champs doivent êtres remplis');
        }else if (isNaN(tel) || tel.length != 10) {
        	$('#msgReturn').append('Le numéro de téléphone doit être valide');
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
                    if (html === "Votre inscription a été prise en compte" ) {
                    	form.get(0).reset();
                    } else {
                    	$('#code').val("");
                    	$('#pass').val("");
                    }
                }
            });
        }
    });
});

</script>


<h2>Inscription</h2>

<div id="espace_reserve">
	Attention ! L'inscription au site est <span>réservée</span> aux seuls <span>membres</span>
	de l'association.<br /> Si vous n'en faites pas partie, nous serions
	ravis que vous nous rejoignez.
</div>
<form id='inscription'
	action="inscription_traitement.php?<?PHP echo SID; ?>" method="post">
	<table>
		<tr>
			<td>Prénom</td>
			<td><input type="text" value="" id='prenom' name="prenom" required></td>
		</tr>
		<tr>
			<td>Nom</td>
			<td><input type="text" value="" id='nom' name="nom" required></td>
		</tr>
		<tr>
			<td colspan="2"><br></td>
		</tr>
		<tr>
			<td>Pseudo</td>
			<td><input type="text" value="" id='pseudo' name="pseudo" required></td>
		</tr>
		<tr>
			<td>Mot de Passe</td>
			<td><input type="password" value="" id='mdp' name="mdp" required></td>
		</tr>
		<tr>
			<td colspan="2"><br></td>
		</tr>
		<tr>
			<td>Adresse</td>
			<td><textarea rows="4" id='adresse' name="adresse" required></textarea></td>
		</tr>
		<tr>
			<td>Téléphone</td>
			<td><input type="text" value="" id='tel' name="tel" required></td>
		</tr>
		<tr>
			<td>E-mail</td>
			<td><input type="text" value="" id='mail' name="email" required></td>
		</tr>
		<tr>
			<td colspan="2"><br></td>
		</tr>
		<tr>
			<td>Ajout de vos coordonnées dans l'annuaire des membres de
				l'association. Oui si coché</td>
			<td><input type="checkbox" name="etat_annuaire" value="true"></td>
		</tr>
		<tr>
			<td colspan="2"><?php dsp_crypt(0,1); ?></td>
		</tr>
		<tr>
			<td colspan="2">Recopier le code:<br> <input type="text" name="code"
				id='code' required></td>
		</tr>
	</table>

	<br> <input type="submit" name="submit" value="S'inscrire" />
</form>
<div id='msgReturn'></div>


