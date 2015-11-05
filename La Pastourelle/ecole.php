<?php
	//récupération du titre de la page
	$titre = recup_titre("ecole");
	
	//récupération des info dans la BD et traitement
	$tab_theatre = recup_presentation("ecole");
	$cpt = 0;
	$taille_tab = count($tab_theatre);
	
	$le_texte = $tab_theatre[$cpt];
	$cpt++; 
	$l_img1 = $tab_theatre[$cpt];
	$cpt++;
	$l_img2 = $tab_theatre[$cpt];
	$cpt++;
	$l_img3 = $tab_theatre[$cpt];
	$cpt++;
	$l_img4 = $tab_theatre[$cpt];
	$cpt++;
	
	//affichage de la premiere image en haut a gauche
	echo "
		<DIV id=\"accueil\"><CENTER><H1>".$titre."</H1></CENTER>
			<div style=\"float:right;margin:10px;\">
				<IMG SRC=\"".$l_img1."\" width=250px align=\"top\"/>
				<IMG SRC=\"".$l_img2."\" width=250px align=\"top\"/>
			</DIV>";
	echo "<BR><BR>".$le_texte;
	echo "	<div style=\"float:right;\">
				<IMG SRC=\"".$l_img3."\" width=250px align=\"bottom\"/>
			</DIV>";
	echo "	<div style=\"float:left;\">
				<IMG SRC=\"".$l_img4."\" width=250px align=\"bottom\"/>
			</DIV>
		</DIV>";

?>