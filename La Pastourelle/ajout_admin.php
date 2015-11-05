<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	echo'
			<script language="javascript" type="text/javascript">
				setTimeout("window.location=\'index.php?page=accueil\'", 3000);
			</script>';
	exit(0);
} else {?>
	<SCRIPT LANGUAGE="JavaScript">
	/* On crée une fonction de verification */
	function verifForm(formulaire)
	{
	adresse = formulaire.email.value;
	var place = adresse.indexOf("@",1);
	var point = adresse.indexOf(".",place+1);
	if(formulaire.psd.value == "" || formulaire.mdp.value == "" || formulaire.tel.value == "" ||  (formulaire.tel.value).length != 10
	   ||  formulaire.nom.value == "" ||  formulaire.prenom.value == "" ||  formulaire.adresse.value == "") /* on detecte si saisie33 est vide */
		alert('Remplissez correctement tous les champs'); /* dans ce cas on lance un message d'alerte */
	else
		if ((place > -1)&&(adresse.length >2)&&(point > 1))
			formulaire.submit(); /* sinon on envoi le formulaire */
		else
			alert('Entrez une adresse e-mail valide!!');
	}
	</SCRIPT><?php
	echo
	"<CENTER>
		<H2>Ajout d'un administrateur</H2>
		<FORM METHOD=POST ACTION=\"index.php?page=inscriptionAdmin\">
			<TABLE>
				<TR>
					<TD> Prenom </TD>
					<TD><INPUT TYPE=\"text\" VALUE=\"\" NAME=\"prenom\" size=27></TD>
				</TR>
				<TR>
					<TD> Nom </TD>
					<TD><INPUT TYPE=\"text\" VALUE=\"\" NAME=\"nom\" size=27></TD>
				</TR>
				<TR>
					<TD><BR></TD>
					<TD><BR></TD>
				</TR>
				<TR>
					<TD> Pseudo </TD>
					<TD><INPUT TYPE=\"text\" VALUE=\"\" NAME=\"psd\" size=27></TD>
				</TR>
				<TR>
					<TD> Mot de Passe </TD>
					<TD><INPUT TYPE=\"password\" VALUE=\"\" NAME=\"mdp\" size=27></TD>
				</TR>
				<TR>
					<TD><BR></TD>
					<TD><BR></TD>
				</TR>
				<TR>
					<TD>Adresse</TD>
					<TD><TEXTAREA rows=\"4\" name=\"adresse\"></TEXTAREA></TD>
				</TR>
				<TR>
					<TD>Telephone</TD>
					<TD><INPUT TYPE=\"text\" VALUE=\"\" NAME=\"tel\" size=27></TD>
				</TR>
				<TR>
					<TD>E-mail</TD>
					<TD><INPUT TYPE=\"text\" VALUE=\"\" NAME=\"email\" size=27></TD>
				</TR>
				<TR>
					<TD><BR></TD>
					<TD><BR></TD>
				</TR>
			</TABLE>
			<BR>
			<BUTTON NAME=\"btn_inscription\" type=\"button\" value=\"\" onClick=\"verifForm(this.form)\"> ajouter</BUTTON>
		</FORM>
	</CENTER>
		  
	<CENTER>
		<BR/><BR/>
		<A class='btn btn-link' HREF=\"index.php?page=change_admin\">Retour à la page précédente</A>
	</CENTER>";
}		  
?>