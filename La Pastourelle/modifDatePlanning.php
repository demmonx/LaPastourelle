<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	exit(0);
} else {?>
<SCRIPT LANGUAGE="JavaScript">
/* On crée une fonction de verification */
 // TODO vérifier le formulaire
function verifForm(formulaire)
{
temps = formulaire.date.value;
var place = temps.indexOf("/",1);
var point = temps.indexOf("/",place+1);
if(formulaire.date.value == "" || formulaire.lieu.value == "" || formulaire.musiciens.value == "") /* on detecte si saisie33 est vide */
	alert('Remplissez correctement tous les champs'); /* dans ce cas on lance un message d'alerte */
else
	if ((place == 2)&&(temps.length == 10)&&(point == 5))
		formulaire.submit(); /* sinon on envoi le formulaire */
	else
		alert('Entrez une date valide!!');
}
</SCRIPT>

<?php

	$info_date = recup_datePlanning($_GET["id"]);	
	
	echo "<DIV id=\"accueil\"><CENTER><H2>ADMINISTRATION DU PLANNING</H2>";
	echo "<BR><BR>";
	echo "<FORM METHOD=POST ACTION=\"index.php?page=modifDatePlanningBD\">
			<TABLE WIDTH=840px>
				<TR><TD>Jour</TD><TD><INPUT type=text name=\"jour\" size=15px value=\"".$info_date['jour']."\"></TD></tr>
			<tr><TD>Date (jj/mm/aaaa)</TD><TD><INPUT type=text name=\"date\" size=15px value=\"".$info_date['date']."\"></TD></tr>
			<tr><TD>Lieu</TD><TD><INPUT type=text name=\"lieu\" size=15px value=\"".$info_date['lieu']."\"></tr>
			<tr><TD>Musiciens</TD><TD><textarea name='musiciens'>".$info_date['joueur']."</textarea></TD></TR></TABLE>
				<INPUT type=hidden name=\"id\" size=15px value=\"".$info_date['id']."\">
				<BR><BUTTON NAME=\"btn_val\" type=\"button\" value=\"\" onClick=\"verifForm(this.form)\">Modifier</BUTTON><BR><BR>
		  </FORM></DIV>";
		  
	echo "<BR><BR><CENTER><A class='btn btn-link' HREF='index.php?page=planning'>Retour à la page précédente</A></CENTER>";
}	  
?>