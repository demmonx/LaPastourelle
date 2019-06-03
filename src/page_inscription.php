<script language="javascript">
$(document).ready(function () {
    /** * Formulaire de connexion ** */
    $('#inscription').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire

        // Récupération des valeurs
        var pseudo = $('#pseudo').val();  
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
        if (pseudo === '' || pass === '' || mail === '' || nom === '' 
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
                    if (html.search("inscription") >= 0) {
                    	form.get(0).reset();
                    	grecaptcha.reset();
                    } else {
                    	$('#pass').val("");
                    }
                }
            });
        }
    });
});

</script>


<h1>Inscription</h1>

<div id="espace_reserve">
	<p>Attention ! L'inscription au site est <span>réservée</span> aux seuls <span>membres</span>
	de l'association.<br /> Si vous n'en faites pas partie, nous serions
	ravis que vous nous rejoignez.</p>
</div>
<form id='inscription' action="traitement_inscription.php" method="post">
	<table class='table'>
		<tr>
			<td>Prénom</td>
			<td><input type="text" value="" id='prenom' placeholder='Prénom' name="prenom" required></td>
		</tr>
		<tr>
			<td>Nom</td>
			<td><input type="text" value="" id='nom' placeholder='Nom' name="nom" required></td>
		</tr>
		<tr>
			<td>Pseudo</td>
			<td><input type="text" value="" placeholder='Pseudo' id='pseudo' name="pseudo" required></td>
		</tr>
		<tr>
			<td>Mot de Passe</td>
			<td><input type="password" value="" id='mdp' placeholder='Mot de passe' name="mdp" required></td>
		</tr>
		<tr>
			<td>Adresse</td>
			<td><textarea rows="4" id='adresse' name="adresse" placeholder='Adresse' required></textarea></td>
		</tr>
		<tr>
			<td>Téléphone</td>
			<td><input type="text" value="" id='tel' name="tel" placeholder='Téléphone' required></td>
		</tr>
		<tr>
			<td>E-mail</td>
			<td><input type="text" value="" id='mail' placeholder='Email' name="email" required></td>
		</tr>
		<tr>
			<td>Apparaître dans l'annuaire</td>
			<td><input type="checkbox" name="etat_annuaire" value="true"> Oui (si coché)</td>
		</tr>
	</table>
	<div class="g-recaptcha"
		data-sitekey="6Lf7kxITAAAAAOvjPQ9UKCgwZ0B3l-UztVdvWr_t"></div>

	<br> <input class='btn' type='submit' value="S'inscrire" />
</form>
<div id='msgReturn'></div>


