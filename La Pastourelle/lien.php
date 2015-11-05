<?php
if (isset($_SESSION['pseudo']) AND isset($_SESSION['pass']) AND verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass']) 
		AND isset($_GET['up']) AND isset($_GET['lien'])) {
	//Récupération de toutes les langues disponibles
		$req_allLang = $bdd->select("SELECT DISTINCT lang FROM texte");
		$allLang = $req_allLang->fetchAll();
		
	//Changement de place d'un lien
	if ($_GET['up'] == 0 OR $_GET['up'] == 1) {
		//Récupération des l'ids du lien courant et de celui d'avant ou celui d'après
		$req_idlien = $bdd->select('SELECT id FROM lien_ext WHERE lien ="' . $_GET['lien'] . '"');
		//$req_idlien->execute(array($_GET['lien']));
		$num_lien=$req_idlien->fetchAll();
		
		if($_GET['up'] == 1) { 
			$req_idlien2 = $bdd->select('SELECT MAX(id) FROM lien_ext WHERE id <' . $num_lien[0]['id']);
			//$req_idlien2->execute(array($num_lien[0]['id']));
			$num_lien2=$req_idlien2->fetchAll();
			$num = $num_lien2[0]['MAX(id)'];
		} else { 
			$req_idlien2 = $bdd->select('SELECT MIN(id) FROM lien_ext WHERE id >' . $num_lien[0]['id']);
			//$req_idlien2->execute(array($num_lien[0]['id']));
			$num_lien2=$req_idlien2->fetchAll();
			$num = $num_lien2[0]['MIN(id)'];
		}

		//On met son id a 0
		$req_updown = $bdd->select('UPDATE lien_ext SET id = 0 WHERE id ="' . $num_lien[0]['id'] . '"');
		//$req_updown->execute(array($num_lien[0]['id']));
		
		//On descend le lien du dessus ou on monte le lien du dessus
		$req_updown2 = $bdd->select('UPDATE lien_ext SET id ="' . $num_lien[0]['id'] . '" WHERE id ="' . $num . '"');
		//$req_updown2->execute(array($num_lien[0]['id'], $num));
		
		//Et on monte ou on descend le lien que l'on a mis précédement à 0
		$req_updown3 = $bdd->select('UPDATE lien_ext SET id ="' . $num . '" WHERE id = 0');
		//$req_updown3->execute(array($num));
		
	//Suppression d'un lien
	} else if ($_GET['up'] == 2) {
		$req_recupInfoslien = $bdd->select('SELECT * FROM lien_ext WHERE lien ="' . $_GET['lien'] . '"');
		//$req_recupInfoslien->execute(array($_GET['lien']));
		$infosLien=$req_recupInfoslien->fetchAll();

		//Récupération du nom de l'image puis suppression dans le dossier
		$req_recupImg = $bdd->select('SELECT img_adr FROM image WHERE img_num =' . $infosLien[0]['lien'] . ' AND img_page = "lien"');
		//$req_recupImg->execute(array($infosLien[0]['lien_img']));
		$recupImg = $req_recupImg->fetchAll();
		unlink($recupImg[0]['img_adr']);
		//Suppression base de donnée
		$req_delLien1 = $bdd->select('DELETE FROM lien_ext WHERE lien ="' . $infosLien[0]['lien'] . '"');
		//$req_delLien1->execute(array($infosLien[0]['lien']));
		$req_delLien2 = $bdd->select('DELETE FROM texte WHERE txt_num ="' . $infosLien[0]['lien_txt'] . '" AND txt_page = "lien"');
		//$req_delLien2->execute(array($infosLien[0]['lien_txt']));
		$req_delLien3 = $bdd->select('DELETE FROM image WHERE img_num =' . $infosLien[0]['lien_img'] . ' AND img_page = "lien"');
		//$req_delLien3->execute(array($infosLien[0]['lien_img']));
		
	}
}
//récupération du titre de la page
	$titre = recup_titre("lien");
echo "<CENTER><H1>".$titre."</H1></CENTER>";
$adminOK = false;
if (isset($_SESSION['pseudo']) AND isset($_SESSION['pass']) AND verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {	
	$adminOK = true;
}
//Récupération des textes annexes de traduction pour cette zone
	$req_recupLien = $bdd->select("SELECT valeurTrad FROM tradannexe WHERE lang ='" . $_SESSION['lang'] ."' AND nomTrad LIKE 'lien%' ");
	//$req_recupLien->execute(array($_SESSION['lang']));
	$recupLien = $req_recupLien->fetchAll();
//récupération des liens dans la BD et traitement
$tab_lien = recup_lienExt();
$cpt = 0;
$taille_tab = count($tab_lien);
echo '<DIV id="liens">';

//		<TABLE RULES="rows" FRAME="void" CELLSPACING="10px" BORDERCOLORLIGHT="white" style="font-size:13px;" width="840px">
echo '	<table class="table table-bordered">
			<center>
				<TR>
						<TH>'.$recupLien[0]['valeurTrad'].'</TH>
						<TH>'.$recupLien[1]['valeurTrad'].'</TH>
						<TH>'.$recupLien[2]['valeurTrad'].'</TH>';
if ($adminOK) {	
	echo '				<TH colspan="3">Actions</TH>';
}
echo '			</TR>
			</center>';

while ($cpt < $taille_tab ) {
	//affichage des différentes informations
	echo "<TR>";
	$le_lien = $tab_lien[$cpt];
	$cpt++;
	$lien_desc = recup_texte($tab_lien[$cpt], "lien");
	$cpt++;
	$lien_img = recup_img($tab_lien[$cpt], "lien");
	$cpt++;
	$lien_nom = $tab_lien[$cpt];
	$cpt++;
	if ($lien_img != false) {
		echo "<TD style='padding-left: 20px;'><img class='ssBordure' SRC=\"".$lien_img."\" HEIGHT=\"75\" WIDTH=\"98\" BORDER=\"5px\"/> </TD>";
	} else {
		echo "<TD> </TD>";
	}
	//echo "<TD>&nbsp; &nbsp; &nbsp; &nbsp;</TD>";
	echo "<TD><A class='btn btn-link' HREF=\"".$le_lien."\" target=_blank>".$lien_nom."</A></TD>";
	//echo "<TD>&nbsp; &nbsp; &nbsp; &nbsp;</TD>";
	if ($lien_desc != false) {
		echo "<TD>".$lien_desc."</TD>";
	} else { 
		echo "<TD>&nbsp; &nbsp; &nbsp; &nbsp;</TD>";
	}
	if ($adminOK) {
		echo "<TD><A class='btn btn-link' HREF=index.php?page=ajout_lien&lien=".$le_lien."&modif=1>Modifier</A></TD>";
		//echo "<TD>&nbsp; &nbsp; &nbsp; &nbsp;</TD>";
		echo "<TD><A class='btn btn-link' HREF=index.php?page=lien&lien=".$le_lien."&up=2>Supprimer</A></TD>";
		//echo "<TD>&nbsp; &nbsp; &nbsp; &nbsp;</TD>";
		echo '<TD>';
			if ($cpt != 4) { echo "<A HREF='index.php?page=lien&lien=".$le_lien."&up=1><img class='ssBordure' src='image/flecheHaut.png' style='float:left;'/></A>"; }
			if ($cpt != $taille_tab) { echo '<A HREF=index.php?page=lien&lien='.$le_lien.'&up=0><img class="ssBordure" src="image/flecheBas.png" style="float:left;"/></A>'; }
		echo '</TD>';
	}
	echo "</TR>";
}
//echo "<tr>
//		<TD></TD>
//		<TD></TD>
//		<TD></TD>
//		<TD></TD>
//		<TD></TD>
//		<TD></TD>
//	  </tr>
 echo"	 </TABLE>
	</DIV>";
if ($adminOK) {	
	echo "<CENTER><A class='btn btn-link' HREF='index.php?page=ajout_lien'>Ajouter un lien</A></CENTER>";
}
?>