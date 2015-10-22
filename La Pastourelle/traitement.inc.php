<?php

/*********************************
 * Connexion à la base de donnée *
 *********************************/
 function connect_BD()
 {
	/** Connexion à la base de donées*/
	$host = "mysql5-8.bdb";
	//$host="localhost";
	//$user="root";
	//$pwd="";
	$user = "pastourebd1";
	$pwd = "ltIUED83";
	$connet = mysql_connect ($host, $user, $pwd) or die ("Connexion impossible");
	/** selection de la base de données */
	mysql_select_db("pastourebd1");
 }
 function connect_BD_PDO()
 {
    try {
		$bdd = new PDO('mysql:host=mysql5-8.bdb;dbname=pastourebd1', 'pastourebd1', 'ltIUED83');
	} catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
	}
	return $bdd;
 }
  /**************************************
   * Récupération d'un texte dans la BD * 
   **************************************/
   function recup_texte($txt_num, $txt_page)
   {
	$bdd = new Connection();
   
	// ------------------- TEST CONNECTION PDO ------------------------ //
	$sql = "SELECT texte FROM texte WHERE txt_num=\"".$txt_num."\" AND txt_page=\"".$txt_page."\" AND lang='".$_SESSION['lang']."'";
	$result= $bdd->select($sql); 
		foreach ($result as $row) 
		{ 
			return $row['texte'].'<br>'; 
		}
		return " ";
	//------------------- FIN TEST CONNECTION PDO ------------------------ //
   
		/** récupération du texte demandé */
	    //$rqt_txt = "SELECT texte FROM texte WHERE txt_num=\"".$txt_num."\" AND txt_page=\"".$txt_page."\" AND lang='".$_SESSION['lang']."'";  
		//$les_txt = mysql_query($rqt_txt);
		
		//if (($nb_row = mysql_num_rows($les_txt)) != null){
		//	$le_txt = mysql_fetch_object($les_txt) ;
		//	return nl2br(htmlentities($le_txt->texte));
		//}
		//return " ";
		/* PDO 
		$requete = $bdd->prepare("SELECT texte FROM texte WHERE txt_num=\"".$txt_num."\" AND txt_page=\"".$txt_page."\" AND lang='".$_SESSION['lang']."'");
		
		while($row = $requete->fetch(PDO::FETCH_ASSOC)) {
			print_r($row);
		//}
		
		exemple :
		
		$req_menuTrad = $bdd->prepare("SELECT valeurTrad FROM tradannexe WHERE nomTrad LIKE 'menu%' AND lang= ? ORDER BY nomTrad");

						$req_menuTrad->execute(array($_SESSION['lang']));
		
		*/		
	}
	
	/**************************************
   * Récupération d'un texte dans la BD * 
   **************************************/
   function recup_phrasejour()
   {
   
		$bdd = new Connection();
		
		// ------------------- TEST CONNECTION PDO ------------------------ //
		$sql = "SELECT valeurTrad FROM tradannexe WHERE nomTrad LIKE 'phrasejour' AND lang='fr' ORDER BY nomTrad";
		$result= $bdd->select($sql); 
		foreach ($result as $row) 
		{ 
			return $row['valeurTrad'].'<br>'; 
		}
		return " ";
	}	

  /**************************************
   * Récupération d'un titre dans la BD * 
   **************************************/
function recup_titre($txt_page)
	{
		// ------------------- TEST CONNECTION PDO ------------------------ //
		$bdd = new Connection();
		$sql = "SELECT texte FROM texte WHERE txt_num=0 AND txt_page=\"".$txt_page."\" AND lang='".$_SESSION['lang']."'";
		$result= $bdd->select($sql); 
		
		foreach ($result as $row) 
		{ 
			return $row['texte'].'<br>'; 
		}
		//return " ";
		//------------------- FIN TEST CONNECTION PDO ------------------------ //
   
   
		/** récupération du texte demandé */
	    //$rqt_txt = "SELECT texte FROM texte WHERE txt_num=0 AND txt_page=\"".$txt_page."\" AND lang='".$_SESSION['lang']."'";  
		//$les_txt = mysql_query($rqt_txt);
		
		//if (($nb_row = mysql_num_rows($les_txt)) != null){
		//	$le_txt = mysql_fetch_object($les_txt) ;
		//	return nl2br(htmlentities($le_txt->texte));
		//}
		//return " ";
	}
	
  /**************************************
   * Récupération d'une image dans la BD * 
   **************************************/
   function recup_img($img_num, $img_page)
   {
		$bdd = new Connection();
		/** récupération de l'image demandée */
	    $rqt_img = "SELECT img_adr FROM image WHERE img_num='".$img_num."' AND img_page='".$img_page."'";  
	
		$result= $bdd->select($rqt_img); 
		
		$result = $bdd->selectTableau($rqt_img); 
		if (count($result) != 0) {
			foreach ($result as $row) 
			{ 
				return $row['img_adr'];
			}
		}
		return " ";		
		
		//$les_img = mysql_query($rqt_img);
		
		//if (($nb_row = mysql_num_rows($les_img)) != null){
		//	$l_img = mysql_fetch_object($les_img);
		//	return $l_img->img_adr;
		//}
		//return " ";
	}
	
	/****************************************
	 * Récupération des images du diaporama *
	 * à afficher dans le header            *
	 ****************************************/
	function recup_image() {
		$allAttributs;
		$doc = new DOMDocument();
		$doc->load('slider.xml');
		  
		$diaporama = $doc->getElementsByTagName( "img" );
		foreach( $diaporama as $img ) {
			$allAttributs[] = $img->nodeValue;
		}
		if (empty($allAttributs)) {
			return $allAttributs = "Aucune image";
		}
		return $allAttributs;
	}
	
 /***********************************
  * Récupération des liens externes *
  ***********************************/
  function recup_lienExt()
  {
	$bdd = new Connection();
  
	$tab_lien = array(); //tableau contenant les informations des liens 
						 // sous la forme :  lien | descriptif | image | lien_nom
	$cpt = 0;
  
	/** recupération des liens externes */
	$rqt_lien = "SELECT lien, lien_txt, lien_img, lien_nom FROM lien_ext WHERE lang = '".$_SESSION['lang']."' ORDER BY id";
	
	$result= $bdd->select($rqt_lien); 
	
	foreach ($result as $row) 
	{ 
		$tab_lien[$cpt]= nl2br(htmlentities($row['lien']));
		$cpt++;
		$tab_lien[$cpt]= $row['lien_txt'];
		$cpt++;
		$tab_lien[$cpt]= $row['lien_img'];
		$cpt++;
		$tab_lien[$cpt]= nl2br(htmlentities($row['lien_nom']));
		$cpt++;
	}
	
	return $tab_lien;
	
	//$les_liens = mysql_query($rqt_lien);
	
	/** boucle de récupération des données */
	//while ($un_lien = mysql_fetch_object($les_liens))
	//{
	//	$tab_lien[$cpt]= nl2br(htmlentities($un_lien->lien));
	//	$cpt++;
	//	$tab_lien[$cpt]= $un_lien->lien_txt;
	//	$cpt++;
	//	$tab_lien[$cpt]= $un_lien->lien_img;
	//	$cpt++;
	//	$tab_lien[$cpt]= nl2br(htmlentities($un_lien->lien_nom));
	//	$cpt++;
	//}
	
	//return $tab_lien;
  }
  
/******************************************
  * Récupération des informations de la boutique *
  *****************************************/
  function recup_infoPd()
  {
  
	$bdd = new Connection();
	
	$tab_infoPd = array(); //tableau contenant les informations des liens 
						   // sous la forme :  image | nom | desc | prix
	$cpt = 0;
  
	/** recupération des liens externes */
	$rqt_infoPd = "SELECT pd_img, pd_prix, pd_txt, pd_nom, pd_num FROM boutique WHERE lang='".$_SESSION['lang']."'";
	
	$result= $bdd->select($rqt_infoPd); 
	
	foreach ($result as $row) 
	{ 
		$tab_infoPd[$cpt]= $row['pd_img'];
		$cpt++;
		$tab_infoPd[$cpt]= nl2br(htmlentities($row['pd_nom']));
		$cpt++;
		$tab_infoPd[$cpt]= $row['pd_txt'];
		$cpt++;
		$tab_infoPd[$cpt]= $row['pd_prix'];
		$cpt++;
		$tab_infoPd[$cpt]= $row['pd_num'];
		$cpt++;
	}
	
	return $tab_infoPd;
	
	//$les_infoPd = mysql_query($rqt_infoPd);
	
	/** boucle de récupération des données */
	//while ($une_infoPd = mysql_fetch_object($les_infoPd))
	//{
	//	$tab_infoPd[$cpt]= $une_infoPd->pd_img;
	//	$cpt++;
	//	$tab_infoPd[$cpt]= nl2br(htmlentities($une_infoPd->pd_nom));
	//	$cpt++;
	//	$tab_infoPd[$cpt]= $une_infoPd->pd_txt;
	//	$cpt++;
	//	$tab_infoPd[$cpt]= $une_infoPd->pd_prix;
	//	$cpt++;
	//	$tab_infoPd[$cpt]= $une_infoPd->pd_num;
	//	$cpt++;
	//}	
	//return $tab_infoPd;
  }
  
/**********************************************************
   * Récuparation des informations pour la page coordonnées *
   **********************************************************/
   function recup_infoCoord()
   {
   
		$bdd = new Connection();
		$tab_coord = array();							  
		$cpt = 0;
   
		/** recupération des liens externes sous la forme :  adr | mail | tel | img  */
		$rqt_coord = "SELECT coord_adr, coord_mail, coord_tel, coord_img FROM coordonnees";
		
		$result= $bdd->select($rqt_coord); 
	
		foreach ($result as $row) 
		{ 
			$tab_coord[$cpt]= nl2br(htmlentities($row['coord_adr']));
			$cpt++;
			$tab_coord[$cpt]= nl2br(htmlentities($row['coord_tel']));
			$cpt++;
			$tab_coord[$cpt]= nl2br(htmlentities($row['coord_mail']));
			$cpt++;
			$tab_coord[$cpt]= nl2br(htmlentities($row['coord_img']));
			$cpt++;
		}
		
		return $tab_coord;
		
		
		
		
		//$les_coord = mysql_query($rqt_coord);
		
		/** boucle de récupération des données */
		//while ($une_coord = mysql_fetch_object($les_coord))
		//{
		//	$tab_coord[$cpt]= nl2br(htmlentities($une_coord->coord_adr));
		//	$cpt++;
		//	$tab_coord[$cpt]= nl2br(htmlentities($une_coord->coord_tel));
		//	$cpt++;
		//	$tab_coord[$cpt]= nl2br(htmlentities($une_coord->coord_mail));
		//	$cpt++;
		//	$tab_coord[$cpt]= nl2br(htmlentities($une_coord->coord_img));
		//	$cpt++;
		//}
	
		//return $tab_coord;
   }
   
 /*************************************
  * Récupération des revues de presse *
  *************************************/
  function recup_revuePresse()
  {
  
	$bdd = new Connection();
	
	$tab_revue = array(); //tableau contenant les informations des revues de presse 
						  // sous la forme :  image | descriptif 
	$cpt = 0;
  
	/** recupération des revues de presse */
	$rqt_revue = "SELECT presse_img, presse_txt, num_presse FROM revue_presse";
	
	$result= $bdd->select($rqt_revue); 
	
		foreach ($result as $row) 
		{ 
			$tab_revue[$cpt]= $row['presse_img'];
			$cpt++;
			$tab_revue[$cpt]= nl2br(htmlentities($row['presse_txt']));
			$cpt++;
			$tab_revue[$cpt]= nl2br(htmlentities($row['num_presse']));
			$cpt++;
		}
		
		return $tab_revue;
	
	
	//$les_revues = mysql_query($rqt_revue);
	
	/** boucle de récupération des données */
	//while ($une_revue = mysql_fetch_object($les_revues))
	//{
	//	$tab_revue[$cpt]= $une_revue->presse_img;
	//	$cpt++;
	//	$tab_revue[$cpt]= nl2br(htmlentities($une_revue->presse_txt));
	//	$cpt++;
	//	$tab_revue[$cpt]= nl2br(htmlentities($une_revue->num_presse));
	//	$cpt++;
	//}
	
	//return $tab_revue;
  }
  
 /****************************************
  * Récupération de la liste des membres *
  ****************************************/
  function recup_annuaire($recherche,$typeRecherche,$role)
  {
  
	$bdd= new Connection();
	//$tab_annuaire = array();
	$tab_membre = array(); //tableau contenant les informations des revues de presse 
						   // sous la forme :  pseudo | email | telephone | nom | prenom |adresse
	/* RECUPERATION DES DONNEES OPTIMISEE 
	 * @author Pierre Gaboriaud et Yohan Delmas (IUT de Rodez) Années 2009-2011
	 */
	if ($role==0 AND !empty($recherche)) {
		//$rqt_membre = " SELECT pseudo, email, telephone, nom, prenom, adresse, etat_annuaire FROM user
		//				WHERE pseudo LIKE '%".$recherche."%' OR email LIKE '%".$recherche."%'
		//				OR nom LIKE '%".$recherche."%' OR prenom LIKE '%".$recherche."%'
		//				OR telephone LIKE '%".$recherche."%' AND etat_validation=1";
		$rqt_membre = "	SELECT pseudo, email, telephone, nom, prenom, adresse, etat_annuaire FROM user
						WHERE " . $typeRecherche . " LIKE '" . $recherche ."%'
						AND etat_validation=1";
	} else if ($role==1){
		$rqt_membre = "SELECT pseudo, email, telephone, nom, prenom, adresse, etat_annuaire FROM user WHERE etat_validation=1
					   AND EXISTS (SELECT pseudo FROM annuaire WHERE user.pseudo = annuaire.pseudo) ORDER BY ".$recherche;
	} else{
		$rqt_membre = "SELECT pseudo, email, telephone, nom, prenom, adresse, etat_annuaire FROM user WHERE etat_validation=1
					  AND EXISTS (SELECT pseudo FROM annuaire WHERE user.pseudo = annuaire.pseudo) ORDER BY nom";
	}
	$index = 0;
	$result= $bdd->select($rqt_membre); 
	$i = 0;
	foreach ($result as $row) 
		{ 
			$tab_membre[$index] = nl2br(htmlentities($row['pseudo']));
			$tab_membre[$index+1] = nl2br(htmlentities($row['email']));
			$tab_membre[$index+2] = nl2br(htmlentities($row['telephone']));
			$tab_membre[$index+3] = nl2br(htmlentities($row['nom']));
			$tab_membre[$index+4] = nl2br(htmlentities($row['prenom']));
			$tab_membre[$index+5] = nl2br(htmlentities($row['adresse']));
			$tab_membre[$index+6] = nl2br(htmlentities($row['etat_annuaire']));
			$index += 7;
			$i++;
		}
		
		return $tab_membre;
	
	//$Allmembre = mysql_query($rqt_membre);
	//$i=0;
	//while ($donnees = mysql_fetch_array($Allmembre)) {
	//	$tab_membre[$index] = nl2br(htmlentities($donnees['pseudo']));
	//	$tab_membre[$index+1] = nl2br(htmlentities($donnees['email']));
	//	$tab_membre[$index+2] = nl2br(htmlentities($donnees['telephone']));
	//	$tab_membre[$index+3] = nl2br(htmlentities($donnees['nom']));
	//	$tab_membre[$index+4] = nl2br(htmlentities($donnees['prenom']));
	//	$tab_membre[$index+5] = nl2br(htmlentities($donnees['adresse']));
	//	$tab_membre[$index+6] = nl2br(htmlentities($donnees['etat_annuaire']));
	//	$index += 7;
	//	$i++;
	//}
	//return $tab_membre;
  }
  
  /********************************************************
  * Récupération des membres non présent dans l'annuaire  *
  *********************************************************/
  function recup_non_annuaire()
  {
  
	$bdd = new Connection();
	
	$tab_annuaire = array();
	$tab_membre = array(); 
	$tab_non_annuaire = array();
	$tab_result = array(); //tableau contenant les informations des revues de presse 
						   // sous la forme :  pseudo | email | telephone | nom | prenom |adresse
	$cpt_membre = 0;
	$cpt_annuaire = 0;
	$cpt_non_annuaire = 0;
		
	/** récuparation des nom de l'annuaire */
	$rqt_annuaire = "SELECT pseudo FROM annuaire";
	
	$result= $bdd->select($rqt_annuaire);
	foreach ($result as $row) 
	{ 
		$tab_annuaire[$cpt_annuaire]= $row['pseudo'];
		$cpt_annuaire++;
	}
	
	//$les_annuaires = mysql_query($rqt_annuaire);
	//while ($un_annuaire = mysql_fetch_object($les_annuaires))
	//{
	//	$tab_annuaire[$cpt_annuaire]= $un_annuaire->pseudo;
	//	$cpt_annuaire++;
	//}
	$taille_tab_annuaire = count($tab_annuaire);
	
	/** recupération de tous les membres */
	$rqt_membre = "SELECT pseudo FROM user WHERE etat_validation=1 AND etat_annuaire=1";
	$result= $bdd->select($rqt_membre);
	foreach ($result as $row) 
	{ 
		$tab_membre[$cpt_membre]= $un_membre['pseudo'];
		$cpt_membre++;
	}
	
	
	//$les_membre = mysql_query($rqt_membre);
	//while ($un_membre = mysql_fetch_object($les_membre))
	//{
	//	$tab_membre[$cpt_membre]= $un_membre->pseudo;
	//	$cpt_membre++;
	//}
	$taille_tab_membre = count($tab_membre);
	
	/** recupération des membres non présent dans l'annuaire*/
	for($i=0; $i<$taille_tab_membre; $i++)
	{
		if (!in_array($tab_membre[$i], $tab_annuaire))
		{
			$tab_non_annuaire[$cpt_non_annuaire]=$tab_membre[$i];
			$cpt_non_annuaire++;
		}
	}
	
	/** récupération des information de ces membres */
	$cpt = 0;
	$cpt_result = 0;
	$taille_tab = count($tab_non_annuaire);
	while ($cpt < $taille_tab)
	{
		$rqt_non_annuaire = "SELECT pseudo, email, telephone, nom, prenom, adresse FROM user WHERE pseudo=\"".$tab_non_annuaire[$cpt]."\" ORDER BY pseudo";
		$les_non_annuaire = $bdd->select($rqt_non_annuaire);
		//$un_non_annuaire = mysql_fetch_object($les_non_annuaire);
		
		foreach ($un_non_annuaire as $row) 
		{ 
			$cpt++;
	
			$tab_result[$cpt_result]= nl2br(htmlentities($row['pseudo']));
			$cpt_result++;
			$tab_result[$cpt_result]= nl2br(htmlentities($row['email']));
			$cpt_result++;
			$tab_result[$cpt_result]= nl2br(htmlentities($row['telephone']));
			$cpt_result++;
			$tab_result[$cpt_result]= nl2br(htmlentities($row['nom']));
			$cpt_result++;
			$tab_result[$cpt_result]= nl2br(htmlentities($row['prenom']));
			$cpt_result++;
			$tab_result[$cpt_result]= nl2br(htmlentities($row['adresse']));
			$cpt_result++;
		}
		//$cpt++;
	
		//$tab_result[$cpt_result]= nl2br(htmlentities($un_non_annuaire->pseudo));
		//$cpt_result++;
		//$tab_result[$cpt_result]= nl2br(htmlentities($un_non_annuaire->email));
		//$cpt_result++;
		//$tab_result[$cpt_result]= nl2br(htmlentities($un_non_annuaire->telephone));
		//$cpt_result++;
		//$tab_result[$cpt_result]= nl2br(htmlentities($un_non_annuaire->nom));
		//$cpt_result++;
		//$tab_result[$cpt_result]= nl2br(htmlentities($un_non_annuaire->prenom));
		//$cpt_result++;
		//$tab_result[$cpt_result]= nl2br(htmlentities($un_non_annuaire->adresse));
		//$cpt_result++;
	}
	
	return $tab_result;
  }
  
 /*****************************************
  * Récupération des info de présentation *
  *****************************************/
  function recup_presentation( $page_presentation )
  {
  
	$bdd = new Connection();
	
	$tab_info = array(); //tableau contenant les informations du theatre
						    // sous la forme :  texte | image du haut | image du bas
	$cpt = 0;
  
	/** recupération des revues de presse */
	$rqt_txt_info = "SELECT texte FROM texte WHERE txt_page=\"".$page_presentation."\" AND txt_num !=0 AND lang = '".$_SESSION['lang']."'";
	$result = $bdd->select($rqt_txt_info);
	
	foreach ($result as $row) {
		$tab_info[$cpt]= nl2br(htmlentities($row['texte']));
		$cpt++;
	}
	
	//$les_txt = mysql_query($rqt_txt_info);
	//$le_txt = mysql_fetch_object($les_txt);
	//$tab_info[$cpt]= nl2br(htmlentities($le_txt->texte));
	//$cpt++;
	
	$rqt_img_info = "SELECT img_adr FROM image WHERE img_page=\"".$page_presentation."\"";
	$result = $bdd->select($rqt_img_info);
	
	foreach($result as $row) {
		$tab_info[$cpt]= $row['img_adr'];
		$cpt++;
	}
	
	//$les_img = mysql_query($rqt_img_info);
	//while ($une_img = mysql_fetch_object($les_img))
	//{
	//	$tab_info[$cpt]= $une_img->img_adr;
	//	$cpt++;
	//}
	
	return $tab_info;
  }
  
 /*************************************
  * Récupération des info du planning *
  *************************************/
  function recup_planning()
  {
	$bdd = new Connection();
	
	$tab_planning = array(); //tableau contenant les informations du planning
	$cpt = 0;
  
	/** recupération des revues de presse */
	$rqt_planning = "SELECT pl_jour, pl_date, pl_lieu, pl_musiciens FROM planning";
	$result = $bdd->select($rqt_planning);
	
	foreach($result as $row) {
		$tab_planning[$cpt]= $row['pl_jour'];
		$cpt++;
		$tab_planning[$cpt]= $row['pl_date'];
		$cpt++;
		$tab_planning[$cpt]= $row['pl_lieu'];
		$cpt++;
		$tab_planning[$cpt]= $row['pl_musiciens'];
		$cpt++;
	}
	
	//$les_info_planning = mysql_query($rqt_planning);
	
	//while ($une_info = mysql_fetch_object($les_info_planning))
	//{
	//	$tab_planning[$cpt]= $une_info->pl_jour;
	//	$cpt++;
	//	$tab_planning[$cpt]= $une_info->pl_date;
	//	$cpt++;
	//	$tab_planning[$cpt]= $une_info->pl_lieu;
	//	$cpt++;
	//	$tab_planning[$cpt]= $une_info->pl_musiciens;
	//	$cpt++;
	//}
	
	return $tab_planning;
  }
  
 /************************************************
  * Récupération des info d'une date du planning *
  ************************************************/
  function recup_datePlanning($date, $lieu)
  {
  
	$bdd = new Connection();
	
	$tab_date = array(); //tableau contenant les informations du planning
	$cpt = 0;
  
	/** recupération des revues de presse */
	$rqt_date = "SELECT pl_jour, pl_date, pl_lieu, pl_musiciens FROM planning WHERE pl_date=\"".$date."\" AND pl_lieu=\"".$lieu."\"";
	$result = $bdd->select($rqt_date);
	
	foreach($result as $row) {
		$tab_date[$cpt]= $row['pl_jour'];
		$cpt++;
		$tab_date[$cpt]= $row['pl_date'];
		$cpt++;
		$tab_date[$cpt]= $row['pl_lieu'];
		$cpt++;
		$tab_date[$cpt]= $row['pl_musiciens'];
		$cpt++;
	}
	
	//$les_dates = mysql_query($rqt_date);
	
	//$une_date = mysql_fetch_object($les_dates);
	//$tab_date[$cpt]= $une_date->pl_jour;
	//$cpt++;
	//$tab_date[$cpt]= $une_date->pl_date;
	//$cpt++;
	//$tab_date[$cpt]= $une_date->pl_lieu;
	//$cpt++;
	//$tab_date[$cpt]= $une_date->pl_musiciens;
	//$cpt++;
	
	return $tab_date;
  }
 

 /**************************************
  * Récupération des membres à valider *
  **************************************/
  function recup_membre_valider()
  {
  
	$bdd = new Connection();
	
	$tab_aValider = array(); //tableau contenant les informations des membres a recuperer
	$cpt = 0;
  
	/** recupération des membre à validere */
	$rqt_aValider = "SELECT pseudo, email, telephone, nom, prenom, adresse
						FROM user WHERE etat_validation=0 ORDER BY nom";
	$result = $bdd->select($rqt_aValider);
	
	foreach($result as $row) {
		$tab_aValider[$cpt]= nl2br(htmlentities($row['pseudo']));
		$cpt++;
		$tab_aValider[$cpt]= nl2br(htmlentities($row['email']));
		$cpt++;
		$tab_aValider[$cpt]= nl2br(htmlentities($row['telephone']));
		$cpt++;
		$tab_aValider[$cpt]= nl2br(htmlentities($row['nom']));
		$cpt++;
		$tab_aValider[$cpt]= nl2br(htmlentities($row['prenom']));
		$cpt++;
		$tab_aValider[$cpt]= nl2br(htmlentities($row['adresse']));
		$cpt++;
	}
						
	//$les_aValider = mysql_query($rqt_aValider);
	
	//while ($une_aValider = mysql_fetch_object($les_aValider))
	//{
	//	$tab_aValider[$cpt]= nl2br(htmlentities($une_aValider->pseudo));
	//	$cpt++;
	//	$tab_aValider[$cpt]= nl2br(htmlentities($une_aValider->email));
	//	$cpt++;
	//	$tab_aValider[$cpt]= nl2br(htmlentities($une_aValider->telephone));
	//	$cpt++;
	//	$tab_aValider[$cpt]= nl2br(htmlentities($une_aValider->nom));
	//	$cpt++;
	//	$tab_aValider[$cpt]= nl2br(htmlentities($une_aValider->prenom));
	//	$cpt++;
	//	$tab_aValider[$cpt]= nl2br(htmlentities($une_aValider->adresse));
	//	$cpt++;
	//}
	
	return $tab_aValider;
  }
  
/**************************
  * Récupération des membres  *
  **************************/
  function recup_membre()
  {
  
	$bdd = new Connection();
	
	$tab_membre = array(); //tableau contenant les informations des membres a recuperer
	$cpt = 0;
  
	/** recupération des membre */
	$rqt_membre = "SELECT pseudo, email, telephone, nom, prenom, adresse
						FROM user WHERE etat_validation=1 AND niveau=\"membre\" ORDER BY nom";
	$result = $bdd->select($rqt_membre);
	foreach($result as $row) {
		$tab_membre[$cpt]= nl2br(htmlentities($row['pseudo']));
		$cpt++;
		$tab_membre[$cpt]= nl2br(htmlentities($row['email']));
		$cpt++;
		$tab_membre[$cpt]= nl2br(htmlentities($row['telephone']));
		$cpt++;
		$tab_membre[$cpt]= nl2br(htmlentities($row['nom']));
		$cpt++;
		$tab_membre[$cpt]= nl2br(htmlentities($row['prenom']));
		$cpt++;
		$tab_membre[$cpt]= nl2br(htmlentities($row['adresse']));
		$cpt++;
	}
	
	//$les_membre = mysql_query($rqt_membre);

	
	//while ($un_membre = mysql_fetch_object($les_membre))
	//{
	//	$tab_membre[$cpt]= nl2br(htmlentities($un_membre->pseudo));
	//	$cpt++;
	//	$tab_membre[$cpt]= nl2br(htmlentities($un_membre->email));
	//	$cpt++;
	//	$tab_membre[$cpt]= nl2br(htmlentities($un_membre->telephone));
	//	$cpt++;
	//	$tab_membre[$cpt]= nl2br(htmlentities($un_membre->nom));
	//	$cpt++;
	//	$tab_membre[$cpt]= nl2br(htmlentities($un_membre->prenom));
	//	$cpt++;
	//	$tab_membre[$cpt]= nl2br(htmlentities($un_membre->adresse));
	//	$cpt++;
	//}
	
	return $tab_membre;
  }
  
    
 /********************************************
  * Récupération d'un membre avec son pseudo *
  ********************************************/
  function recup_un_membre($pseudo)
  {
  
	$bdd = new Connection();
	
	$tab_membre = array(); //tableau contenant les informations des membres a recuperer
	$cpt = 0;
  
	/** recupération des membre */
	$rqt_membre = "SELECT pseudo, email, telephone, nom, prenom, adresse, etat_annuaire
						FROM user WHERE etat_validation=1 AND pseudo=\"".$pseudo."\" ORDER BY pseudo";
	$result = $bdd->select($rqt_membre);
	
	foreach($result as $row) {
		$tab_membre[$cpt]= nl2br(htmlentities($row['pseudo']));
		$cpt++;
		$tab_membre[$cpt]= nl2br(htmlentities($row['email']));
		$cpt++;
		$tab_membre[$cpt]= nl2br(htmlentities($row['telephone']));
		$cpt++;
		$tab_membre[$cpt]= nl2br(htmlentities($row['nom']));
		$cpt++;
		$tab_membre[$cpt]= nl2br(htmlentities($row['prenom']));
		$cpt++;
		$tab_membre[$cpt]= nl2br(htmlentities($row['adresse']));
		$cpt++;
		$tab_membre[$cpt]= nl2br(htmlentities($row['etat_annuaire']));
		$cpt++;
	}
	
	
	//$les_membre = mysql_query($rqt_membre);
	//while ($un_membre = mysql_fetch_object($les_membre))
	//{
	//	$tab_membre[$cpt]= nl2br(htmlentities($un_membre->pseudo));
	//	$cpt++;
	//	$tab_membre[$cpt]= nl2br(htmlentities($un_membre->email));
	//	$cpt++;
	//	$tab_membre[$cpt]= nl2br(htmlentities($un_membre->telephone));
	//	$cpt++;
	//	$tab_membre[$cpt]= nl2br(htmlentities($un_membre->nom));
	//	$cpt++;
	//	$tab_membre[$cpt]= nl2br(htmlentities($un_membre->prenom));
	//	$cpt++;
	//	$tab_membre[$cpt]= nl2br(htmlentities($un_membre->adresse));
	//	$cpt++;
	//	$tab_membre[$cpt]= nl2br(htmlentities($un_membre->etat_annuaire));
	//	$cpt++;
	//}
	
	return $tab_membre;
  }
  
/*******************
  * Les actualites *
  ******************/
  function recup_act($type)
  {
  
	$bdd = new Connection();
	
	$tab_act = array(); //tableau contenant les informations des actualitées a recuperer
	$cpt = 0;
  
	/** recupération de l'actualite*/
	$rqt_act = 'SELECT act_lieu, act_date, act_heure, act_txt, act_img FROM actualite WHERE act_type="'.$type.'" AND lang="'.$_SESSION['lang'].'"';
	
	$result= $bdd->select($rqt_act); 
	
	foreach ($result as $row) 
	{ 
		$tab_act[$cpt]= nl2br(htmlentities($row['act_lieu']));
		$cpt++;
		$tab_act[$cpt]= nl2br(htmlentities($row['act_date']));
		$cpt++;
		$tab_act[$cpt]= nl2br(htmlentities($row['act_heure']));
		$cpt++;
		$tab_act[$cpt]= nl2br(htmlentities($row['act_txt']));
		$cpt++;
		$tab_act[$cpt]= nl2br(htmlentities($row['act_img']));
		$cpt++;
	}
	
	return $tab_act;
	
	
	
	//$les_act = mysql_query($rqt_act);
	
	//while ($l_act = mysql_fetch_object($les_act))
	//{
	//	$tab_act[$cpt]= nl2br(htmlentities($l_act->act_lieu));
	//	$cpt++;
	//	$tab_act[$cpt]= nl2br(htmlentities($l_act->act_date));
	//	$cpt++;
	//	$tab_act[$cpt]= nl2br(htmlentities($l_act->act_heure));
	//	$cpt++;
	//	$tab_act[$cpt]= nl2br(htmlentities($l_act->act_txt));
	//	$cpt++;
	//	$tab_act[$cpt]= nl2br(htmlentities($l_act->act_img));
	//	$cpt++;
	//}

	//return $tab_act;
  }
  
 /*************************************************
  * Récupération du texte de la page compte rendu *
  *************************************************/
  function recup_compteRendu()
  {
  
	$bdd = new Connection();
	
	/** recupération du texte */
	$rqt_compteRendu = "SELECT texte FROM texte WHERE txt_page=\"compte_rendu\" ";
	$result = $bdd->select($rqt_compteRendu);
	
	if ($result != null) {
		foreach($result as $row) {
			return nl2br(htmlentities($row['texte']));
		}
	}
	
	return false;
	
	//$les_compteRendu = mysql_query($rqt_compteRendu);
	
	//if (($nb_row = mysql_num_rows($les_compteRendu)) != null){
	//		$le_compteRendu = mysql_fetch_object($les_compteRendu);
	//		return nl2br(htmlentities($le_compteRendu->texte));
	//}
	//return false;
  }
  
/*
 * Fonction verifLo								Langage : PHP
 *
 * Fonction de vérification de l'existance d'un membre avec un pseudo $login et un mot de passe $pass donné
 *
 * @author Pierre Gaboriaud et Yohan Delmas (IUT de Rodez) Années 2009-2011
 * @param $login		Login à vérifié
 * @param $pass			Mot de passe à vérifié
 *
 * @return 				True si le membre existe
 *						False s'il n'existe pas
 */
function verifLo($login, $pass) {
	//Vérification de l'existance d'un membre avec le pseudo $login et le mot de passe $pass

	$bdd = connect_BD_PDO();
	$req_connect = $bdd->prepare('SELECT pseudo FROM user WHERE pseudo = ? AND motdepasse = ?');
	$req_connect->execute(array($login, $pass));

	$connect = $req_connect->fetchAll();
	$req_connect->closeCursor();

	//Si on a rien recupéré false sinon true
	return (count($connect) != 0);
}

/*
 * Fonction verifLoAdmin						Langage : PHP
 *
 * Fonction de vérification de l'existance d'un ADMIN avec un pseudo $login et un mot de passe $pass donné
 *
 * @author Pierre Gaboriaud et Yohan Delmas (IUT de Rodez) Années 2009-2011
 * @param $login		Login à vérifié
 * @param $pass			Mot de passe à vérifié
 *
 * @return 				True si le membre existe
 *						False s'il n'existe pas
 */
function verifLoAdmin($login, $pass) {
	//Vérification de l'existance d'un membre avec le pseudo $login et le mot de passe $pass
	$bdd = connect_BD_PDO();
	$req_connect = $bdd->prepare('SELECT pseudo FROM user WHERE pseudo = ? AND motdepasse = ? AND niveau = "administrateur"');
	$req_connect->execute(array($login, $pass));

	$connect = $req_connect->fetchAll();
	$req_connect->closeCursor();

	//Si on a rien recupéré false sinon true
	return (count($connect) != 0);
}
/*
 * Fonction redirect					Langage : PHP
 *
 * Fonction de redirection après un temps donné
 *
 * @author Pierre Gaboriaud et Yohan Delmas (IUT de Rodez) Années 2009-2011
 * @param lien	La page à attendre lors de la redirection
 * @param sec 	Le nombre de secondes avant la redirection
 *
 */
function redirect($lien, $sec) {
		header('Refresh:'.$sec.'; URL='.$lien);
}
/*
 * Fonction ajoutLang					Langage : PHP
 *
 * Fonction d'ajout de langue dans la base de données
 *
 * @author Pierre Gaboriaud et Yohan Delmas (IUT de Rodez) Années 2009-2011
 * @param ini	Initiales de la nouvelle langue
 *
 */
function ajoutLang($ini) {
	$bdd = connect_BD_PDO();
	//Ajout des textes
	$req_add = $bdd->prepare("INSERT INTO texte  VALUES
							(0, 'accueil', ?, 'Traduction non faite\r\n'),
							(0, 'avis', ?, 'Traduction non faite'),
							(0, 'boutique', ?, 'Traduction non faite'),
							(0, 'coordonnees', ?, 'Traduction non faite'),
							(0, 'danse', ?, 'Traduction non faite'),
							(0, 'ecole', ?, 'Traduction non faite'),
							(0, 'historique', ?, 'Traduction non faite'),
							(0, 'lien', ?, 'Traduction non faite'),
							(0, 'revue_presse', ?, 'Traduction non faite'),
							(0, 'theatre', ?, 'Traduction non faite'),
							(1, 'danse', ?, 'Traduction non faite\r\n'),
							(1, 'ecole', ?, 'Traduction non faite\r\n\r\n'),
							(1, 'historique', ?, 'Traduction non faite\r\n\r\n\r\n'),
							(1, 'theatre', ?, 'Traduction non faite\r\n\r\n\r\n')");
	$req_add->execute(array($ini, $ini, $ini, $ini, $ini, $ini, $ini, $ini, $ini, $ini, $ini, $ini, $ini, $ini));
	//Ajout de la boutique
		//Récupération des informations sur les articles
		$req_nbB = $bdd->query('SELECT * FROM boutique WHERE lang = "fr"');
		$nbB = $req_nbB->fetchAll();
		//Ajout du bon nombre de description d'articles pour la langue
		for ($i = 1; $i <= count($nbB); $i++) {
			$req_addB = $bdd->prepare("INSERT INTO texte  VALUES(?, 'boutique', ?, 'Traduction non faite\r\n')");
			$req_addB->execute(array($i, $ini));
		}
		//Ajout du bon nombre de details des articles en boutique
		for ($i = 0; $i < count($nbB); $i++) {
			$req_addD = $bdd->prepare("INSERT INTO boutique VALUES(?, ?, ?, ?, ?, 'Traduction non faite\r\n')");
			$req_addD->execute(array($nbB[$i]['pd_num'], $ini, $nbB[$i]['pd_prix'], $nbB[$i]['pd_img'], $nbB[$i]['pd_txt']));
		}
	//Ajout des liens
		//Récupération des informations sur les liens
		$req_nbL = $bdd->query('SELECT * FROM lien_ext WHERE lang = "fr"');
		$nbL = $req_nbL->fetchAll();
		//Ajout du bon nombre de description de liens pour la langue
		for ($i = 1; $i <= count($nbL)+1; $i++) {
			$req_addL = $bdd->prepare("INSERT INTO texte  VALUES(?, 'lien', ?, 'Traduction non faite\r\n')");
			$req_addL->execute(array($i, $ini));
		}
		//Ajout du bon nombre de details des liens
		for ($i = 0; $i < count($nbL); $i++) {
			$req_addDL = $bdd->prepare("INSERT INTO lien_ext VALUES(?, ?, ?, ?, ?, 'Traduction non faite\r\n')");
			$req_addDL->execute(array($nbL[$i]['id'], $ini, $nbL[$i]['lien'], $nbL[$i]['lien_img'], $nbL[$i]['lien_txt']));
		}
	//Ajout des revues de presse
		//Récupération des informations sur les revues de presse
		$req_nbR = $bdd->query('SELECT * FROM revue_presse');
		$nbR = $req_nbR->fetchAll();
		//Ajout du bon nombre de description de liens pour la langue
		for ($i = 1; $i <= count($nbR); $i++) {
			$req_addL = $bdd->prepare("INSERT INTO texte  VALUES(?, 'revue_presse', ?, 'Traduction non faite\r\n')");
			$req_addL->execute(array($i, $ini));
		}
		//Pas d'ajout de details (car pas de texte a traduire)
	//Ajout de l'actualité
		//Récupération des informations sur les actualités
		$req_nbA = $bdd->query('SELECT * FROM actualite WHERE lang = "fr"');
		$nbA = $req_nbA->fetchAll();

		//Ajout des informations sur les actualités
		$req_addA = $bdd->prepare("INSERT INTO actualite  VALUES 
								  ('danse', ?, ?, ?, ?, 'Traduction pas faite', ?),
								  ('theatre', ?, ?, ?, ?, 'Traduction pas faite', ?)");
		$req_addA->execute(array($ini, $nbA[0]['act_lieu'], $nbA[0]['act_date'], $nbA[0]['act_heure'], $nbA[0]['act_img'],
								 $ini, $nbA[1]['act_lieu'], $nbA[1]['act_date'], $nbA[1]['act_heure'], $nbA[1]['act_img']));
	//Ajout des expressions pour parfaire la traduction
		//Récupération des informations sur les traductions annexes
		$req_nbT = $bdd->query('SELECT * FROM tradannexe WHERE lang = "fr"');
		$nbT = $req_nbT->fetchAll();
		//Ajout des traductions annexes
		for ($i = 0; $i < count($nbT); $i++) {
			$req_addT = $bdd->prepare("INSERT INTO tradannexe  VALUES(?, ?, 'A traduire')");
			$req_addT->execute(array($ini, $nbT[$i]['nomTrad']));
		}
}
/*
 * Fonction supprLang					Langage : PHP
 *
 * Fonction de suppression de langue dans la base de données
 *
 * @author Pierre Gaboriaud et Yohan Delmas (IUT de Rodez) Années 2009-2011
 * @param ini	Initiales de la nouvelle langue
 *
 */
function supprLang($ini) {
	$bdd = new Connection();
	//Suppression des textes de la langue
	$requete = "DELETE FROM texte WHERE lang = " .$ini ;
	$result = $bdd->select($requete);
	
	//Suppression de la boutique de la langue
	$requete = "DELETE FROM boutique WHERE lang = " .$ini ;
	$result = $bdd->select($requete);
	
	//Suppression des liens de la langue
	$requete = "DELETE FROM lien_ext WHERE lang =" .$ini ;
	$result = $bdd->select($requete);
	
	//Suppression de l'actualité de la langue
	$requete = "DELETE FROM actualite WHERE lang = " .$ini ;
	$result = $bdd->select($requete);
	
	//Suppressiion des traductions annexes
	$requete = "DELETE FROM tradannexe WHERE lang = " .$ini ;
	$result = $bdd->select($requete);

	//$bdd = connect_BD_PDO();
	//Suppression des textes de la langue
	//$req_del = $bdd->prepare("DELETE FROM texte WHERE lang = ?");
	//$req_del->execute(array($ini));
	//Suppression de la boutique de la langue
	//$req_del2 = $bdd->prepare("DELETE FROM boutique WHERE lang = ?");
	//$req_del2->execute(array($ini));
	//Suppression des liens de la langue
	//$req_del3 = $bdd->prepare("DELETE FROM lien_ext WHERE lang = ?");
	//$req_del3->execute(array($ini));
	//Suppression de l'actualité de la langue
	//$req_del4 = $bdd->prepare("DELETE FROM actualite WHERE lang = ?");
	//$req_del4->execute(array($ini));
	//Suppressiion des traductions annexes
	//$req_del5 = $bdd->prepare("DELETE FROM tradannexe WHERE lang = ?");
	//$req_del5->execute(array($ini));
}
?>