 <?php

	//////////////////////////////////////// RECUPERATION DONNEES //////////////////////////////////////
	
	//récupération du titre de la page
	$titre = recup_titre("coordonnees");
	
	//récupération des informations à ajouter dans la page
	$tab_coord = recup_infoCoord();
	$cpt = 0;
	
	//Récupération des textes annexes de traduction pour cette zone
	//$req_recupCoor = $bdd->prepare("SELECT valeurTrad FROM tradannexe WHERE lang = ? AND nomTrad LIKE 'coor%' ");
	//$req_recupCoor->execute(array($_SESSION['lang']));
	
	
	$req_recupCoor = $bdd->select("SELECT valeurTrad FROM tradannexe WHERE lang = '" . $_SESSION['lang'] . "' AND nomTrad LIKE 'coor%' ");
	$recupCoor = $req_recupCoor->fetchAll();
	
		////////////////////////////////////////// TRAITEMENT AFFICHAGE /////////////////////////////////////////
	
		//recupération des données
		$coord_adr = $tab_coord[$cpt];
		$cpt++;
		$coord_tel = $tab_coord[$cpt];
		$cpt++;
		$coord_mail = $tab_coord[$cpt];
		$cpt++;
		$coord_img = recup_img($tab_coord[$cpt], "coordonnees");
		$cpt++;
		
		//mets des '.' dans le numéro de tel
		$tel = substr($coord_tel, 0, 2).".".substr($coord_tel, 2, 2).".".substr($coord_tel, 4, 2).".".substr($coord_tel, 6, 2).".".substr($coord_tel, 8, 2);
		
		//affichage des différentes informations
		echo "
		<DIV id=\"liens\">
			<CENTER>
				<H1>".$titre."</H1>
				<TABLE>";
		
		//affichage de l'adresse
		echo "		<TR>
						<TD> </TD>
						<TD>
							<H1>Adresse</H1>";
		echo 				$coord_adr."<BR>";
		echo "			</TD>
					</TR>";
		
		//affichage des images
		echo "		<TR>
						<TD> ";
		echo "				<A class='btn btn-link' HREF=\"".$coord_img."\" target=_blank>
								<IMG SRC=\"".$coord_img."\"/ width=200px>
								<CENTER>".$recupCoor[3]['valeurTrad']."</CENTER>
							</A>";
		echo "			</TD>";
		
		//affichage des telephones
		echo "			<TD>
							<H1>Téléphone</H1>";
		echo 				$tel."<BR>";
		echo "			</TD>
					</TR>";
		
		//affichage des mails
		echo "		<TR>
						<TD> </TD>
						<TD>
							<H1>Mail</H1>";
		echo "				<a class='btn btn-link' href=\"mailto:pastourelle.rodez@yahoo.fr\">".$coord_mail."</a><BR>";
		echo "			</TD>
					</TR>
				</TABLE>
			</CENTER>
		</DIV>";

	
	
 
 ?>