<?php
	//connect_BD();

	//$bdd=connect_BD_PDO();
	//récupération du titre de la page
	$titre = recup_titre("danse");
	//récupération des info dans la BD et traitement
	$tab_theatre = recup_presentation("danse");
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
	
	//affichage de la premiere image en haut a gauche
	echo "<DIV id=\"accueil\" >
			<CENTER><H1>".$titre."</H1></CENTER>
			<CENTER><IMG SRC=\"".$l_img0."\" width=600px align=\"top\"/></CENTER><BR><BR>
			<div style=\"float:left;margin:10px;\">
				<IMG SRC=\"".$l_img1."\" width=250px/><BR><BR><BR>
				<IMG SRC=\"".$l_img2."\" width=250px/><BR><BR><BR>
				<IMG SRC=\"".$l_img3."\" width=250px/><BR><BR><BR>
				<IMG SRC=\"".$l_img4."\" width=250px/><BR><BR><BR>
				<IMG SRC=\"".$l_img5."\" width=250px/><BR><BR><BR>
			</DIV>";
	echo "<div style=\"float:top;\"><BR><BR>".$le_texte."</DIV></DIV>";
			

?>