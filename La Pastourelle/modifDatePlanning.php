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
	//récupération du membre a supprimer
	$date = $_GET["date"];
	$lieu = $_GET["lieu"];
	
	//traitement de la date pour l'inserer de la forme aaaa/mm/jj pour pouvoir les classer par date
	$morceau_date = explode ("/", $date);
	$jour = $morceau_date[0];
	$mois = $morceau_date[1];
	$annee = $morceau_date[2];
	$date2 = $annee."/".$mois."/".$jour;
	
	$info_date = recup_datePlanning($date2, $lieu);
	
	
	echo "<DIV id=\"accueil\"><CENTER><H2>ADMINISTRATION DU PLANNING</H2>";
	echo "<BR><BR>";
	echo "<FORM METHOD=POST ACTION=\"index.php?page=modifDatePlanningBD\">
			<TABLE WIDTH=840px>
				<TR><TD>Jour</TD><TD><INPUT type=text name=\"jour\" size=15px value=\"".$info_date[0]."\"></TD><TD> </TD>
				<TD>Date (jj/mm/aaaa)</TD><TD><INPUT type=text name=\"date\" size=15px value=\"".$date."\"></TD><TD> </TD>
				<TD>Lieu</TD><TD><INPUT type=text name=\"lieu\" size=15px value=\"".$lieu."\"></TD><TD> </TD>
				<TD>Musiciens</TD><TD><INPUT type=text name=\"musiciens\" size=15px value=\"".$info_date[3]."\"></TD><TD> </TD></TR></TABLE>
				<INPUT type=hidden name=\"date_A\" size=15px value=\"".$date."\">
				<INPUT type=hidden name=\"lieu_A\" size=15px value=\"".$lieu."\">
				<BR><BUTTON NAME=\"btn_val\" type=\"button\" value=\"\" onClick=\"verifForm(this.form)\">Modifier</BUTTON><BR><BR>
		  </FORM></DIV>";
		  
	echo "<BR><BR><CENTER><A class='btn btn-link' HREF='index.php?page=planning'>Retour à la page précédente</A></CENTER>";
}	  
?>