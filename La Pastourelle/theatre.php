<?php

	//récupération du titre de la page
	$titre = recup_titre("theatre");

	//récupération des info dans la BD et traitement
	$tab_theatre = recup_presentation("theatre");
	$cpt = 0;
	$taille_tab = count($tab_theatre);
	
	$le_texte = $tab_theatre[$cpt];
	$cpt++; 
	$l_img0 = $tab_theatre[$cpt];
	$cpt++;
	$l_img1 = $tab_theatre[$cpt];
	$cpt++;
	$l_img2 = $tab_theatre[$cpt];
	$cpt++;
	$l_img3 = $tab_theatre[$cpt];
	$cpt++;
	$l_img4 = $tab_theatre[$cpt];
	$cpt++;
	$l_img5 = $tab_theatre[$cpt];
	$cpt++;
	
	//affichage des images et du texte
	echo "
	<DIV id=\"accueil\">
		<CENTER><H1>".$titre."</H1></CENTER>
	    <CENTER><IMG SRC=\"".$l_img0."\" width=600px align=\"top\"/></CENTER>
		<div style=\"float:left;margin:10px;\">
			<BR><BR>
			<IMG width=250 height=250 SRC='".$l_img1."'  align=\"top\"/></br></br>
			<IMG width=250 height=250 SRC=\"".$l_img2."\"  align=\"top\"/>
		  </DIV>";
	echo "<BR><BR>".$le_texte;
	echo "<div style=\"float:right;margin:10px;\">
			<table>
				<td><IMG width=250 height=200 SRC=\"".$l_img3."\"  align=\"bottom\"/></td>
				<td><IMG width=250 height=200 SRC=\"".$l_img4."\"  align=\"bottom\"/></td>
				<td><IMG width=250 height=200 SRC=\"".$l_img5."\"  align=\"bottom\"/></td>
			</table>
		  </DIV>
		</DIV>";

?>