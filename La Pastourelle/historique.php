<?php
	//connect_BD();

	//$bdd=connect_BD_PDO();
	//récupération du titre de la page
	$titre = recup_titre("historique");

	//récupération des info dans la BD et traitement
	$tab_histo = recup_presentation("historique");
	$cpt = 0;
	$taille_tab = count($tab_histo);
	
	$le_texte = $tab_histo[$cpt];
	$cpt++; 
	$l_img1 = $tab_histo[$cpt];
	$cpt++;
	$l_img2 = $tab_histo[$cpt];
	$cpt++;
	$l_img3 = $tab_histo[$cpt];
	$cpt++;
	$l_img4 = $tab_histo[$cpt];
	$cpt++;
	$l_img5 = $tab_histo[$cpt];
	$cpt++;
	
	//affichage de la premiere image en haut a gauche
	echo "
		<DIV id=\"accueil\">
			<CENTER><H1>".$titre."</H1></CENTER>
			<div style=\"float:left;margin:10px;\">
				<IMG SRC=\"".$l_img1."\" width=250px align=\"top\"/>
			</DIV>";
	echo "	<div style=\"float:right;margin:10px;\">
				<DIV style=\"height=200px;background-color=yellow;\"></DIV>
				<IMG SRC=\"".$l_img2."\" width=250px align=\"bottom\"/><BR><BR><BR>
				<IMG SRC=\"".$l_img3."\" width=250px align=\"bottom\"/><BR><BR><BR>
				<IMG SRC=\"".$l_img4."\" width=250px align=\"bottom\"/><BR><BR><BR>
				<IMG SRC=\"".$l_img5."\" width=250px align=\"bottom\"/><BR><BR><BR>
			</DIV>";
	echo "
			<BR><BR>".$le_texte."
		</DIV>";
?>