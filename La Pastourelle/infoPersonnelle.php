<?php
if (! isset($_SESSION['pseudo']) or ! isset($_SESSION['pass']) or
         ! verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {
    echo "
			Vous ne pouvez pas accèder à ces pages sans être connecté<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  ";
    redirect("index.php?page=accueil", 3);
    exit(0);
} else {
    ?>
<script language="javascript">
$(document).ready(function () {
    /** * Formulaire de connexion ** */
    $('#modif').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire

        // Récupération des valeurs
        var mail = $('#mail').val();  
        var nom = $('#nom').val();  
        var prenom = $('#prenom').val(); 
        var tel = $('#tel').val();  
        var adresse = $('#adresse').val(); 
        var pass = $('#mdp').val(); 
        var pass2 = $('#mdp2').val(); 

        // Regex de test l'adresse mail
        var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
        $('#msgReturn').empty();
        // Vérifie pour éviter de lancer une requête fausse
        if (mail === '' || nom === '' 
            || prenom === '' || tel === '' || adresse === '' || (pass !== '' && pass2 === '')) {
            $('#msgReturn').append('Les champs doivent êtres remplis');
        }else if (isNaN(tel) || tel.length != 10) {
        	$('#msgReturn').append('Le numéro de téléphone doit être valide');
        } else if (!reg.test(mail)) {
            	$('#msgReturn').append("L'adresse mail doit être valide");  
        } else if (pass != '' && pass != pass2) {
        	$('#msgReturn').append("Les mots de passe sont différents");       
        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                data: form.serialize(), // Envoie de toutes les données
                success: function (html) { // Récupération de la réponse
                    $('#msgReturn').append(html);  // affichage du résultat
                    	$('#pass').val("");
                    	$('#pass2').val("");
                    
                }
            });
        }
    });
});

</script>


<?php
    
    /**
     * récupération des données personnelle
     */
    $pseudo = $_SESSION['pseudo'];
    
    // récupération des liens dans la BD et traitement
    $tab_membre = recup_un_membre($pseudo);
    $cpt = 0;
    $taille_tab = count($tab_membre);
    // while ($cpt < $taille_tab )
    // {
    if ($taille_tab == 0) {
        echo "Votre profil n'a pas encore été validé nous ne pouvons pas afficher vos coordonnées<br/>";
    }
    $le_psd = $tab_membre['pseudo'];
    $l_email = $tab_membre['email'];
    $le_telephone = $tab_membre['telephone'];
    $le_nom = $tab_membre['nom'];
    $le_prenom = $tab_membre['prenom'];
    $l_adresse = $tab_membre['adresse'];
    $l_etat_annuaire = $tab_membre['etat_annuaire'];
    
    $l_adresse = str_replace("<br />", "", $l_adresse);
    
    echo "<BR><BR>
		
			<H2>MODIFICATION DES DONNEES PERSONNELLES</H2>
			<FORM id='modif' METHOD=POST ACTION='modifInfoPerso.php'>
				<TABLE>
					<TR>
						<TD>Pseudo</TD>
						<TD><strong>" . $le_psd . "</strong></TD>
					</TR>
					<TR>
						<TD>Nom</TD>
						<TD><INPUT TYPE='text' VALUE='" .
             $le_nom .
             "' NAME='nom' id='nom'></TD>
					</TR>

					<TR>
						<TD>Prénom</TD>
        				<TD><INPUT TYPE='text' VALUE='" .
             $le_prenom .
             "' NAME='prenom' id='prenom'></TD>
					</TR>
					<TR>
						<TD>Nouveau Mot de Passe</TD>
						<TD><INPUT TYPE='password' NAME='Nmdp' id='mdp'></TD>
					</TR>
					<TR>
						<TD>Retaper le Mot de Passe </TD>
						<TD><INPUT TYPE='password' NAME='mdp2' id='mdp2'></TD>
					</TR>
					<TR>
						<TD>Adresse</TD>
						<TD><TEXTAREA rows='4' id='adresse' name='adresse'>" .
             stripnl2br2($l_adresse) .
             "</TEXTAREA></TD>
					</TR>
					<TR>
						<TD>Téléphone</TD>
						<TD><INPUT TYPE='text' id='tel' VALUE='" .
             $le_telephone . "' NAME='tel'></TD>
					</TR>
					<TR>
						<TD>E-mail</TD>
						<TD><INPUT TYPE='text' id='mail' VALUE='" .
             $l_email . "' NAME='email'></TD>
					</TR>
					<TR>
						<TD> cochez cette case si vous acceptez
							 que les adminstrateurs puisse mettre
							 vos coordonnées dans l'annuaire
							 des membres présent sur ce site
						</TD>";
    if ($l_etat_annuaire == 1) {
        echo "
						<TD><INPUT TYPE='checkbox' NAME='etat_annuaire[]' VALUE='1' checked></TD>
					</TR>";
    } else {
        echo "
					<TR>
						<TD><INPUT TYPE='checkbox' NAME='etat_annuaire[]' VALUE='0'></TD>
					</TR>";
    }
    echo "
				</TABLE>
				<BR>
				<input type='submit' value='Modifier' />
			</FORM>
            <div id='msgReturn'></div>
		";
}
?>
