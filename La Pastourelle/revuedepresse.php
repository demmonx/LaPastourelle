<?php
$adminOK = false;
if(isset($_SESSION['pseudo']) AND isset($_SESSION['pass']) AND verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {
	$adminOK = true;
}
//récupération du titre de la page
$titre = recup_titre("revue_presse");
//récupération des revues de presse dans la BD et traitement
$tab_revue = recup_revuePresse();
$cpt = 0;
$taille_tab = count($tab_revue);

echo "<DIV id=\"liens\"><CENTER><H1>".$titre."</H1></CENTER>
<TABLE RULES=\"rows\" FRAME=\"void\" BORDER=\"3px\" CELLSPACING=\"10px\" width='100%'BORDERCOLORLIGHT=\"white\">";

while ($cpt < $taille_tab )
{
	//affichage des différentes informations
	echo "<TR>";
	$revue_img = recup_img($tab_revue[$cpt], "revue_presse");
	$cpt++;
	$revue_desc = recup_texte($tab_revue[$cpt], "revue_presse");
	$cpt++;
	$revue_num = $tab_revue[$cpt];
	$cpt++;
	//si l'image existe
	if ($revue_img != false){
		echo "<TD><BR><A HREF=\"".$revue_img."\" target=_blank><img SRC=\"".$revue_img."\" WIDTH='210' HEIGHT='250'/></A><BR></TD>";
	}
	else
	{
		echo "<TD> </TD>";
	}
	//si le texte existe
	if ($revue_desc != false){
		echo "<TD>".$revue_desc."</TD>";
	}
	else
	{
		echo "<TD>&nbsp; </TD>";
	}
	if ($adminOK) {
		echo '<TD><A class="btn btn-link" HREF=index.php?page=modif_revue&num='.$revue_num.'>Modifier</A></TD>
			  <TD><A class="btn btn-link" HREF=index.php?page=supprrevue&num='.$revue_num.'>Supprimer</A></TD>';
	}
	echo '</TR><TR></TR>'; 
}
echo "</TABLE></DIV>";
if ($adminOK) {
	echo '<CENTER><A class="btn btn-link" HREF=index.php?page=ajout_revue>Ajouter une revue de presse</A></CENTER>';
}?>