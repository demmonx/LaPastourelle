<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect("index.php?page=accueil", 3);
	exit(0);
} else { ?>
<SCRIPT LANGUAGE="JavaScript">
/* On crée une fonction de verification */
function verifForm(formulaire)
{
adresse = formulaire.email.value;
var place = adresse.indexOf("@",1);
var point = adresse.indexOf(".",place+1);	
if(formulaire.psd.value == "" || formulaire.tel.value == "" ||  (formulaire.tel.value).length != 10 || formulaire.email.value == "" 
   ||  formulaire.nom.value == "" ||  formulaire.prenom.value == "" ||  formulaire.adresse.value == "" || formulaire.Nmdp.value != formulaire.mdp2.value) /* on detecte si saisie33 est vide */
	alert('Remplissez correctement tous les champs'); /* dans ce cas on lance un message d'alerte */
else
	if ((place > -1)&&(adresse.length >2)&&(point > 1))
		formulaire.submit(); /* sinon on envoi le formulaire */
	else
		alert('Entrez une adresse e-mail valide!!');
}
</SCRIPT>


<?php

	/** récupération des données personnelle */
	$pseudo = $_SESSION['pseudo'];
	
	//récupération des liens dans la BD et traitement
	$tab_membre = recup_un_membre($pseudo);
	$cpt = 0;
	$taille_tab = count($tab_membre);
	//while ($cpt < $taille_tab )
	//{
	if ($taille_tab == 0) {
		echo "<center>Votre profil n'a pas encore été validé nous ne pouvons pas afficher vos coordonnées<br/></center>";
	}
	foreach ($tab_membre as $row) {
		$le_psd = $row[$cpt];
		$cpt++;
		$l_email = $row[$cpt];
		$cpt++;
		$le_telephone = $row[$cpt];
		$cpt++;
		$le_nom = $row[$cpt];
		$cpt++;
		$le_prenom = $row[$cpt];
		$cpt++;
		$l_adresse = $row[$cpt];
		$cpt++;
		$l_etat_annuaire = $row[$cpt];
		$cpt++;
	}
	
	
		$l_adresse = str_replace("<br />", "", $l_adresse);

		echo "<BR><BR>
		<CENTER>
			<H2>MODIFICATION DES DONNEES PERSONNELLES</H2><BR><BR>
			<FORM METHOD=POST ACTION=\"modifInfoPerso.php\">
				<TABLE>
					<TR>
						<TD> Prénom </TD>
						<TD><INPUT TYPE=\"text\" VALUE=\"".$le_prenom."\" NAME=\"prenom\" size=27></TD>
					</TR>
					<TR>
						<TD> Nom </TD>
						<TD><INPUT TYPE=\"text\" VALUE=\"".$le_nom."\" NAME=\"nom\" size=27></TD>
					</TR>
					<TR>
						<TD><BR></TD>
						<TD><BR></TD>
					</TR>
					<TR>
						<TD> Pseudo </TD>
						<TD><INPUT TYPE=\"text\" VALUE=\"".$le_psd."\" NAME=\"psd\" size=27></TD>
					</TR>
					<TR>
						<TD>Nouveau Mot de Passe </TD>
						<TD><INPUT TYPE=\"password\" VALUE=\"\" NAME=\"Nmdp\" size=27></TD>
					</TR>
					<TR>
						<TD>Retaper le Mot de Passe </TD>
						<TD><INPUT TYPE=\"password\" VALUE=\"\" NAME=\"mdp2\" size=27></TD>
					</TR>
					<TR>
						<TD><BR></TD>
						<TD><BR></TD>
					</TR>
					<TR>
						<TD>Adresse</TD>
						<TD><TEXTAREA rows=\"4\" name=\"adresse\">".$l_adresse."</TEXTAREA></TD>
					</TR>
					<TR>
						<TD>Téléphone</TD>
						<TD><INPUT TYPE=\"text\" VALUE=\"".$le_telephone."\" NAME=\"tel\" size=27></TD>
					</TR>
					<TR>
						<TD>E-mail</TD>
						<TD><INPUT TYPE=\"text\" VALUE=\"".$l_email."\" NAME=\"email\" size=27></TD>
					</TR>
					<TR>
						<TD> cochez cette case si vous acceptez<BR>
							 que les adminstrateurs puisse mettre<BR>
							 vos coordonnées dans l'annuaire <BR>
							 des membres présent sur ce site
						</TD>";
				if ($l_etat_annuaire == 1){
					echo"
						<TD><INPUT TYPE=\"checkbox\" NAME=\"etat_annuaire[]\" VALUE=\"\" checked></TD>
					</TR>";
				} else {
					echo"
					<TR>
						<TD><INPUT TYPE=\"checkbox\" NAME=\"etat_annuaire[]\" VALUE=\"\"></TD>
					</TR>";
				}
				echo "
				</TABLE>
				<BR>
				<BUTTON NAME=\"btn_modif\" type=\"button\" value=\"\" onClick=\"verifForm(this.form)\">Modifier</BUTTON>
			</FORM>
		</CENTER>";
}
?>
