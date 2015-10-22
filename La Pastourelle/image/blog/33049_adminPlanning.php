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

	//récupération des info dans la BD et traitement
	$tab_planning = recup_planning();
	$cpt = 0;
	$taille_tab = count($tab_planning);

	/** titre */
	echo "<DIV id=\"accueil\"><CENTER><H2>ADMINISTRATION DU PLANNING</H2>";
	echo "<BR><BR>";
	echo "<FORM METHOD=POST ACTION=\"ajoutDatePlanning.php\">
			<TABLE WIDTH=840px>
				<TR><TD>Jour</TD><TD><INPUT type=text name=\"jour\" size=15px></TD><TD> </TD>
				<TD>Date (jj/mm/aaaa)</TD><TD><INPUT type=text name=\"date\" size=15px></TD><TD> </TD>
				<TD>Lieu</TD><TD><INPUT type=text name=\"lieu\" size=15px></TD><TD> </TD>
				<TD>Musiciens</TD><TD><INPUT type=text name=\"musiciens\" size=15px></TD><TD> </TD></TR></TABLE>
				<BUTTON NAME=\"btn_val\" type=\"button\" value=\"\" onClick=\"verifForm(this.form)\">Ajouter</BUTTON><BR><BR>
		  </FORM>";
	
	/** tableau du planning */
	echo "<TABLE CELLPADDING=10 BORDER=1 WIDTH=840px>
				<TR><TH>JOUR</TH><TH>DATE</TH><TH>LIEU</TH><TH>MUSICIENS</TH><TH> </TH></TR>";
				
	while ($cpt < $taille_tab){
		$un_jour = $tab_planning[$cpt];
		$cpt++;
		$une_date = $tab_planning[$cpt];
		$cpt++;
		$une_lieu = $tab_planning[$cpt];
		$cpt++;
		$une_musiciens = $tab_planning[$cpt];
		$cpt++;
		
		//traitement de la date pour l'afficher de la forme jj/mm/aaaa
		$morceau_date = explode ("/", $une_date);
		$jour = $morceau_date[2];
		$mois = $morceau_date[1];
		$annee = $morceau_date[0];
		$une_date = $jour."/".$mois."/".$annee;
		
		echo "<TR><TD>".$un_jour."</TD><TD>".$une_date."</TD><TD>".$une_lieu."</TD><TD>".$une_musiciens."</TD> 
		          <TD><A HREF=\"supprDatePlanning.php?date=".$une_date."&lieu=".$une_lieu."\">Supprimer cette date</A></TD></TR>";
	}
	
	echo "</CENTER></TABLE></DIV>";

?>