<?php
require_once ("Connection.class.php");

/**
 * ************************************
 * Récupération d'un texte dans la BD *
 * ************************************
 */
function recup_texte ($txt_num, $txt_page)
{
    $bdd = new Connection();
    
    // ------------------- TEST CONNECTION PDO ------------------------ //
    $sql = "SELECT texte FROM texte WHERE txt_num=\"" . $txt_num .
             "\" AND txt_page=\"" . $txt_page . "\" AND lang='" .
             $_SESSION['lang'] . "'";
    $result = $bdd->select($sql);
    foreach ($result as $row) {
        return $row['texte'] . '<br>';
    }
    return " ";
}

/**
 * ************************************
 * Récupération d'un texte dans la BD *
 * ************************************
 */
function recup_phrasejour ()
{
    $bdd = new Connection();
    
    // ------------------- TEST CONNECTION PDO ------------------------ //
    $sql = "SELECT valeurTrad FROM tradannexe WHERE nomTrad LIKE 'phrasejour' AND lang='fr' ORDER BY nomTrad";
    $result = $bdd->select($sql);
    foreach ($result as $row) {
        return $row['valeurTrad'] . '<br>';
    }
    return " ";
}

/**
 * ************************************
 * Récupération d'un titre dans la BD *
 * ************************************
 */
function recup_titre ($txt_page)
{
    // ------------------- TEST CONNECTION PDO ------------------------ //
    $bdd = new Connection();
    $sql = "SELECT texte FROM texte WHERE txt_num=0 AND txt_page=\"" . $txt_page .
             "\" AND lang='" . $_SESSION['lang'] . "'";
    $result = $bdd->select($sql);
    
    foreach ($result as $row) {
        return $row['texte'] . '<br>';
    }
}

/**
 * ************************************
 * Récupération d'une image dans la BD *
 * ************************************
 */
function recup_img ($img_num, $img_page)
{
    $bdd = new Connection();
    /**
     * récupération de l'image demandée
     */
    $rqt_img = "SELECT img_adr FROM image WHERE img_num='" . $img_num .
             "' AND img_page='" . $img_page . "'";
    
    $result = $bdd->select($rqt_img);
    
    $result = $bdd->selectTableau($rqt_img);
    if (count($result) != 0) {
        foreach ($result as $row) {
            return $row['img_adr'];
        }
    }
    return " ";
}

/**
 * *********************************
 * Récupération des liens externes *
 * *********************************
 */
function recup_lienExt ()
{
    $bdd = new Connection();
    
    $tab_lien = array(); // tableau contenant les informations des liens
                         // sous la forme : lien | descriptif | image |
                         // lien_nom
    $cpt = 0;
    
    /**
     * recupération des liens externes
     */
    $rqt_lien = "SELECT lien, lien_txt, lien_img, lien_nom FROM lien_ext WHERE lang = '" .
             $_SESSION['lang'] . "' ORDER BY id";
    
    $result = $bdd->select($rqt_lien);
    
    foreach ($result as $row) {
        $tab_lien[$cpt] = nl2br(htmlentities($row['lien']));
        $cpt ++;
        $tab_lien[$cpt] = $row['lien_txt'];
        $cpt ++;
        $tab_lien[$cpt] = $row['lien_img'];
        $cpt ++;
        $tab_lien[$cpt] = nl2br(htmlentities($row['lien_nom']));
        $cpt ++;
    }
    
    return $tab_lien;
}

/**
 * ****************************************
 * Récupération des informations de la boutique *
 * ***************************************
 */
function recup_infoPd ()
{
    $bdd = new Connection();
    
    $tab_infoPd = array(); // tableau contenant les informations des liens
                           // sous la forme : image | nom | desc | prix
    $cpt = 0;
    
    /**
     * recupération des liens externes
     */
    $rqt_infoPd = "SELECT pd_img, pd_prix, pd_txt, pd_nom, pd_num FROM boutique WHERE lang='" .
             $_SESSION['lang'] . "'";
    
    $result = $bdd->select($rqt_infoPd);
    
    foreach ($result as $row) {
        $tab_infoPd[$cpt] = $row['pd_img'];
        $cpt ++;
        $tab_infoPd[$cpt] = nl2br(htmlentities($row['pd_nom']));
        $cpt ++;
        $tab_infoPd[$cpt] = $row['pd_txt'];
        $cpt ++;
        $tab_infoPd[$cpt] = $row['pd_prix'];
        $cpt ++;
        $tab_infoPd[$cpt] = $row['pd_num'];
        $cpt ++;
    }
    
    return $tab_infoPd;
}

/**
 * ********************************************************
 * Récuparation des informations pour la page coordonnées *
 * ********************************************************
 */
function recup_infoCoord ()
{
    $bdd = new Connection();
    $tab_coord = array();
    $cpt = 0;
    
    /**
     * recupération des liens externes sous la forme : adr | mail | tel | img
     */
    $rqt_coord = "SELECT coord_adr, coord_mail, coord_tel, coord_img FROM coordonnees";
    
    $result = $bdd->select($rqt_coord);
    
    foreach ($result as $row) {
        $tab_coord[$cpt] = nl2br(htmlentities($row['coord_adr']));
        $cpt ++;
        $tab_coord[$cpt] = nl2br(htmlentities($row['coord_tel']));
        $cpt ++;
        $tab_coord[$cpt] = nl2br(htmlentities($row['coord_mail']));
        $cpt ++;
        $tab_coord[$cpt] = nl2br(htmlentities($row['coord_img']));
        $cpt ++;
    }
    
    return $tab_coord;
}

/**
 * ***********************************
 * Récupération des revues de presse *
 * ***********************************
 */
function recup_revuePresse ()
{
    $bdd = new Connection();
    
    $tab_revue = array(); // tableau contenant les informations des revues de
                          // presse
                          // sous la forme : image | descriptif
    $cpt = 0;
    
    /**
     * recupération des revues de presse
     */
    $rqt_revue = "SELECT presse_img, presse_txt, num_presse FROM revue_presse";
    
    $result = $bdd->select($rqt_revue);
    
    foreach ($result as $row) {
        $tab_revue[$cpt] = $row['presse_img'];
        $cpt ++;
        $tab_revue[$cpt] = nl2br(htmlentities($row['presse_txt']));
        $cpt ++;
        $tab_revue[$cpt] = nl2br(htmlentities($row['num_presse']));
        $cpt ++;
    }
    
    return $tab_revue;
}

/**
 * **************************************
 * Récupération de la liste des membres *
 * **************************************
 */
function recup_annuaire ($recherche, $typeRecherche, $role)
{
    $bdd = new Connection();
    // $tab_annuaire = array();
    $tab_membre = array(); // tableau contenant les informations des revues de
                           // presse
                           // sous la forme : id | pseudo | email | telephone |
                           // nom | prenom |adresse
    /*
     * RECUPERATION DES DONNEES OPTIMISEE
     * @author Pierre Gaboriaud et Yohan Delmas (IUT de Rodez) Années 2009-2011
     */
    /*
     * if ($role==0 AND !empty($recherche)) {
     * //$rqt_membre = " SELECT pseudo, email, telephone, nom, prenom, adresse,
     * etat_annuaire FROM user
     * // WHERE pseudo LIKE '%".$recherche."%' OR email LIKE '%".$recherche."%'
     * // OR nom LIKE '%".$recherche."%' OR prenom LIKE '%".$recherche."%'
     * // OR telephone LIKE '%".$recherche."%' AND etat_validation=1";
     * $rqt_membre = " SELECT pseudo, email, telephone, nom, prenom, adresse,
     * etat_annuaire FROM user
     * WHERE " . $typeRecherche . " LIKE '" . $recherche ."%'
     * AND etat_validation=1";
     * } else if ($role==1){
     * $rqt_membre = "SELECT pseudo, email, telephone, nom, prenom, adresse,
     * etat_annuaire FROM user WHERE etat_validation=1
     * AND EXISTS (SELECT pseudo FROM annuaire WHERE user.pseudo =
     * annuaire.pseudo) ORDER BY ".$recherche;
     * } else{
     * $rqt_membre = "SELECT pseudo, email, telephone, nom, prenom, adresse,
     * etat_annuaire FROM user WHERE etat_validation=1
     * AND EXISTS (SELECT pseudo FROM annuaire WHERE user.pseudo =
     * annuaire.pseudo) ORDER BY nom";
     * }
     */
    
    /*
     * Modification DEMERY 2015 - Suppresion de la table annuaire => Plus de
     * redondance inutile
     * Passage en requêtes préparées pouré viter l'injection SQL
     */
    $rqt_membre = "SELECT id_membre, pseudo, email, telephone, nom, prenom, adresse, etat_annuaire FROM user 
			WHERE etat_validation=1 AND etat_annuaire = 1 ";
    if ($role == 0 && ! empty($recherche)) {
        $rqt_membre .= "AND :typeRecherche LIKE :recherche ORDER BY :recherche";
    } else 
        if ($role == 1) {
            $rqt_membre .= "ORDER BY :recherche";
        } else {
            $rqt_membre .= "ORDER BY nom";
        }
    
    /* Exécution de la bonne requête */
    $stmt = $bdd->prepare($rqt_membre);
    if ($role == 0 && ! empty($recherche)) {
        $stmt->bindValue(':typeRecherche', $typeRecherche, PDO::PARAM_STR);
    } else 
        if ($role == 1 || ($role == 0 && ! empty($recherche))) {
            $stmt->bindValue(':recherche', $recherche, PDO::PARAM_STR);
        }
    
    $result = $stmt->execute();
    $i = 0;
    while ($row = $stmt->fetch()) {
        $tab_membre[$i]['id'] = $row['id_membre'];
        $tab_membre[$i]['pseudo'] = $row['pseudo'];
        $tab_membre[$i]['mail'] = $row['email'];
        $tab_membre[$i]['tel'] = $row['telephone'];
        $tab_membre[$i]['nom'] = $row['nom'];
        $tab_membre[$i]['prenom'] = $row['prenom'];
        $tab_membre[$i]['adresse'] = nl2br($row['adresse']);
        $tab_membre[$i]['etat_annuaire'] = $row['etat_annuaire'];
        $i ++;
    }
    
    return $tab_membre;
}

/**
 * ******************************************************
 * Récupération des membres non présent dans l'annuaire *
 * *******************************************************
 */
function recup_non_annuaire ()
{
    $bdd = new Connection();
    $tab_membre = array();
    
    $stmt = $bdd->prepare(
            "SELECT * FROM user WHERE etat_validation = 1 AND etat_annuraire = 0 ORDER BY nom");
    $result = $stmt->execute();
    $i = 0;
    while ($row = $stmt->fetch()) {
        $tab_membre[$i]['id'] = $row['id_membre'];
        $tab_membre[$i]['pseudo'] = $row['pseudo'];
        $tab_membre[$i]['mail'] = $row['email'];
        $tab_membre[$i]['tel'] = $row['telephone'];
        $tab_membre[$i]['nom'] = $row['nom'];
        $tab_membre[$i]['prenom'] = $row['prenom'];
        $tab_membre[$i]['adresse'] = nl2br($row['adresse']);
        $tab_membre[$i]['etat_annuaire'] = $row['etat_annuaire'];
        $i ++;
    }
    
    return $tab_result;
}

/**
 * ***************************************
 * Récupération des info de présentation *
 * ***************************************
 */
function recup_presentation ($page_presentation)
{
    $bdd = new Connection();
    
    $tab_info = array(); // tableau contenant les informations du theatre
                         // sous la forme : texte | image du haut | image du
                         // bas
    $cpt = 0;
    
    /**
     * recupération des revues de presse
     */
    $rqt_txt_info = "SELECT texte FROM texte WHERE txt_page=\"" .
             $page_presentation . "\" AND txt_num !=0 AND lang = '" .
             $_SESSION['lang'] . "'";
    $result = $bdd->select($rqt_txt_info);
    
    foreach ($result as $row) {
        $tab_info[$cpt] = nl2br(htmlentities($row['texte']));
        $cpt ++;
    }
    
    $rqt_img_info = "SELECT img_adr FROM image WHERE img_page=\"" .
             $page_presentation . "\"";
    $result = $bdd->select($rqt_img_info);
    
    foreach ($result as $row) {
        $tab_info[$cpt] = $row['img_adr'];
        $cpt ++;
    }
    
    return $tab_info;
}

/**
 * ***********************************
 * Récupération des info du planning *
 * ***********************************
 */
function recup_planning ()
{
    $bdd = new Connection();
    
    $tab_planning = array(); // tableau contenant les informations du planning
    $cpt = 0;
    
    /**
     * recupération des revues de presse
     */
    $rqt_planning = "SELECT id_planning, pl_jour, pl_date, pl_lieu, pl_musiciens FROM planning ORDER BY pl_date DESC";
    $result = $bdd->select($rqt_planning);
    
    foreach ($result as $row) {
        $tab_planning[$cpt]['jour'] = $row['pl_jour'];
        $tab_planning[$cpt]['date'] = str_replace("-", "/", $row['pl_date']);
        $tab_planning[$cpt]['lieu'] = $row['pl_lieu'];
        $tab_planning[$cpt]['joueur'] = $row['pl_musiciens'];
        $tab_planning[$cpt]['id'] = $row['id_planning'];
        $cpt ++;
    }
    
    return $tab_planning;
}

/**
 * **********************************************
 * Récupération des info d'une date du planning *
 * **********************************************
 */
function recup_datePlanning ($id)
{
    $bdd = new Connection();
    
    $tab_planning = array(); // tableau contenant les informations du planning
    
    /**
     * recupération des revues de presse
     */
    $rqt_planning = "SELECT * FROM planning WHERE id_planning = ?";
    $result = $bdd->prepare($rqt_planning);
    $result->bindValue(1, $id);
    $result->execute();
    
    if ($row = $result->fetch()) {
        $tab_planning['jour'] = $row['pl_jour'];
        $tab_planning['date'] = str_replace("-", "/", $row['pl_date']);
        $tab_planning['lieu'] = $row['pl_lieu'];
        $tab_planning['joueur'] = $row['pl_musiciens'];
        $tab_planning['id'] = $row['id_planning'];
    }
    
    return $tab_planning;
}

/**
 * ************************************
 * Récupération des membres à valider *
 * ************************************
 */
function recup_membre_valider ()
{
    $bdd = new Connection();
    
    $tab_aValider = array(); // tableau contenant les informations des membres
                             // a recuperer
    $cpt = 0;
    
    /**
     * recupération des membre à validere
     */
    $rqt_aValider = "SELECT pseudo, email, telephone, nom, prenom, adresse
						FROM user WHERE etat_validation=0 ORDER BY nom";
    $result = $bdd->select($rqt_aValider);
    
    foreach ($result as $row) {
        $tab_aValider[$cpt] = nl2br(htmlentities($row['pseudo']));
        $cpt ++;
        $tab_aValider[$cpt] = nl2br(htmlentities($row['email']));
        $cpt ++;
        $tab_aValider[$cpt] = nl2br(htmlentities($row['telephone']));
        $cpt ++;
        $tab_aValider[$cpt] = nl2br(htmlentities($row['nom']));
        $cpt ++;
        $tab_aValider[$cpt] = nl2br(htmlentities($row['prenom']));
        $cpt ++;
        $tab_aValider[$cpt] = nl2br(htmlentities($row['adresse']));
        $cpt ++;
    }
    
    return $tab_aValider;
}

/**
 * ************************
 * Récupération des membres *
 * ************************
 */
function recup_membre ()
{
    $tab_membre = array(); // tableau contenant les informations des membres a
                           // recuperer
    
    $bdd = new Connection();
    
    $stmt = $bdd->prepare(
            "SELECT * FROM user WHERE etat_validation = 1 AND niveau='membre' ORDER BY nom");
    $result = $stmt->execute();
    $i = 0;
    while ($row = $stmt->fetch()) {
        $tab_membre[$i]['id'] = $row['id_membre'];
        $tab_membre[$i]['pseudo'] = $row['pseudo'];
        $tab_membre[$i]['mail'] = $row['email'];
        $tab_membre[$i]['tel'] = $row['telephone'];
        $tab_membre[$i]['nom'] = $row['nom'];
        $tab_membre[$i]['prenom'] = $row['prenom'];
        $tab_membre[$i]['adresse'] = nl2br($row['adresse']);
        $tab_membre[$i]['etat_annuaire'] = $row['etat_annuaire'];
        $i ++;
    }
    
    return $tab_membre;
}

/**
 * ******************************************
 * Récupération d'un membre avec son pseudo *
 * ******************************************
 */
function recup_un_membre ($pseudo)
{
    $bdd = new Connection();
    
    $tab_membre = array(); // tableau contenant les informations des membres a
                           // recuperer
    
    /**
     * recupération des membre
     */
    $rqt_membre = "SELECT pseudo, email, telephone, nom, prenom, adresse, etat_annuaire
						FROM user WHERE etat_validation=1 AND pseudo=? ORDER BY pseudo";
    $result = $bdd->prepare($rqt_membre);
    $result->bindValue(1, $pseudo);
    $result->execute();
    
    if ($result->rowCount() <= 0) {
        return null;
    }
    
    while ($row = $result->fetch()) {
        $tab_membre['pseudo'] = $row['pseudo'];
        $tab_membre["email"] = $row['email'];
        $tab_membre["telephone"] = $row['telephone'];
        $tab_membre["nom"] = $row['nom'];
        $tab_membre["prenom"] = $row['prenom'];
        $tab_membre["adresse"] = $row['adresse'];
        $tab_membre["etat_annuaire"] = $row['etat_annuaire'];
    }
    
    return $tab_membre;
}

/**
 * Renvoie la liste des actus disponibles pour cette langue
 *
 * @param int $lang            
 * @return array Le tableau de toutes les actualités disponibles pour cette
 *         langue
 */
function getActu ($lang, $type = null)
{
    $bdd = new Connection();
    
    $tab_act = array(); // tableau contenant les informations des actualitées a
                        // recuperer
    $cpt = 0;
    
    /**
     * recupération de l'actualite
     */
    $rqt_act = 'SELECT * FROM actu_content RIGHT OUTER JOIN actualite ON act_id = actu ';
    if ($type != null) {
        $rqt_act .= " WHERE actu=?";
    }
    
    $result = $bdd->prepare($rqt_act);
    if ($type != null) {
        $result->bindValue(1, $type);
    }
    $result->execute();
    
    // Si pas de résulktat on renvoie quand même l'image et les types
    if ($result->rowCount() <= 0) {
        $result = $bdd->prepare("SELECT * FROM actualite");
        $result->execute();
    }
    
    while ($row = $result->fetch()) {
        $tab_act[$cpt]['type'] = $row["act_type"];
        $tab_act[$cpt]['lang'] = isset($row["lang"]) ? $row["lang"] : "";
        $tab_act[$cpt]['txt'] = isset($row["content"]) &&
                 $tab_act[$cpt]['lang'] == $lang ? $row["content"] : "";
        $tab_act[$cpt]['img'] = isset($row["act_img"]) ? $row["act_img"] : "";
        $cpt ++;
    }
    
    return $tab_act;
}

/**
 *
 * @return La liste de tous les types d'actualités disponibles
 */
function getActuType ()
{
    $bdd = new Connection();
    
    $tab_act = array(); // tableau contenant les informations des actualitées a
                        // recuperer
    $cpt = 0;
    
    /**
     * recupération de l'actualite
     */
    $rqt_act = 'SELECT * FROM actualite';
    
    $result = $bdd->prepare($rqt_act);
    $result->execute();
    
    while ($row = $result->fetch()) {
        $tab_act[$cpt]['id'] = $row["act_id"];
        $tab_act[$cpt]['type'] = $row["act_type"];
        $tab_act[$cpt]['name'] = $row["act_nom"];
        $tab_act[$cpt]['img'] = isset($row["act_img"]) ? $row["act_img"] : "";
        $cpt ++;
    }
    
    return $tab_act;
}

/**
 * ***********************************************
 * Récupération du texte de la page compte rendu *
 * ***********************************************
 */
function recup_compteRendu ()
{
    $bdd = new Connection();
    
    /**
     * recupération du texte
     */
    $rqt_compteRendu = "SELECT texte FROM texte WHERE txt_page=\"compte_rendu\" ";
    $result = $bdd->select($rqt_compteRendu);
    
    if ($result != null) {
        foreach ($result as $row) {
            return nl2br(htmlentities($row['texte']));
        }
    }
    
    return false;
}

/*
 * Fonction verifLo Langage : PHP
 *
 * Fonction de vérification de l'existance d'un membre actif avec un pseudo
 * $login et un mot de passe $pass donné
 *
 * @author Pierre Gaboriaud et Yohan Delmas (IUT de Rodez) Années 2009-2011
 * @param $login Login à vérifié
 * @param $pass Mot de passe à vérifié
 *
 * @return True si le membre existe
 * False s'il n'existe pas
 */
function verifLo ($login, $pass)
{
    // Vérification de l'existance d'un membre avec le pseudo $login et le mot
    // de passe $pass
    $bdd = new Connection();
    $req_connect = $bdd->prepare(
            'SELECT pseudo FROM user WHERE etat_validation = 1 AND pseudo = ? AND motdepasse = ?');
    $req_connect->execute(array(
            $login,
            $pass
    ));
    
    $connect = $req_connect->fetchAll();
    $req_connect->closeCursor();
    
    // Si on a rien recupéré false sinon true
    return (count($connect) != 0);
}

/*
 * Fonction verifLoAdmin Langage : PHP
 *
 * Fonction de vérification de l'existance d'un ADMIN avec un pseudo $login et
 * un mot de passe $pass donné
 *
 * @author Pierre Gaboriaud et Yohan Delmas (IUT de Rodez) Années 2009-2011
 * @param $login Login à vérifié
 * @param $pass Mot de passe à vérifié
 *
 * @return True si le membre existe
 * False s'il n'existe pas
 */
function verifLoAdmin ($login, $pass)
{
    // Vérification de l'existance d'un membre avec le pseudo $login et le mot
    // de passe $pass
    $bdd = new Connection();
    $req_connect = $bdd->prepare(
            'SELECT pseudo FROM user WHERE pseudo = ? AND motdepasse = ? AND niveau = "administrateur"');
    $req_connect->execute(array(
            $login,
            $pass
    ));
    
    $connect = $req_connect->fetchAll();
    $req_connect->closeCursor();
    
    // Si on a rien recupéré false sinon true
    return (count($connect) != 0);
}

/*
 * Fonction redirect Langage : PHP
 *
 * Fonction de redirection après un temps donné
 *
 * @author Pierre Gaboriaud et Yohan Delmas (IUT de Rodez) Années 2009-2011
 * @param lien La page à attendre lors de la redirection
 * @param sec Le nombre de secondes avant la redirection
 *
 */
function redirect ($lien, $sec)
{
    // Fait planter si suivit par un exit
    // header('Refresh:'.$sec.'; URL='.$lien);
}

/*
 * Fonction ajoutLang Langage : PHP
 *
 * Fonction d'ajout de langue dans la base de données
 *
 * @author Pierre Gaboriaud et Yohan Delmas (IUT de Rodez) Années 2009-2011
 * @param ini Initiales de la nouvelle langue
 *
 */
function ajoutLang ($ini)
{
    $bdd = new Connection();
    // Ajout des textes
    $req_add = $bdd->prepare(
            "INSERT INTO texte  VALUES
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
    $req_add->execute(
            array(
                    $ini,
                    $ini,
                    $ini,
                    $ini,
                    $ini,
                    $ini,
                    $ini,
                    $ini,
                    $ini,
                    $ini,
                    $ini,
                    $ini,
                    $ini,
                    $ini
            ));
    // Ajout de la boutique
    // Récupération des informations sur les articles
    $req_nbB = $bdd->query('SELECT * FROM boutique WHERE lang = "fr"');
    $nbB = $req_nbB->fetchAll();
    // Ajout du bon nombre de description d'articles pour la langue
    for ($i = 1; $i <= count($nbB); $i ++) {
        $req_addB = $bdd->prepare(
                "INSERT INTO texte  VALUES(?, 'boutique', ?, 'Traduction non faite\r\n')");
        $req_addB->execute(
                array(
                        $i,
                        $ini
                ));
    }
    // Ajout du bon nombre de details des articles en boutique
    for ($i = 0; $i < count($nbB); $i ++) {
        $req_addD = $bdd->prepare(
                "INSERT INTO boutique VALUES(?, ?, ?, ?, ?, 'Traduction non faite\r\n')");
        $req_addD->execute(
                array(
                        $nbB[$i]['pd_num'],
                        $ini,
                        $nbB[$i]['pd_prix'],
                        $nbB[$i]['pd_img'],
                        $nbB[$i]['pd_txt']
                ));
    }
    // Ajout des liens
    // Récupération des informations sur les liens
    $req_nbL = $bdd->query('SELECT * FROM lien_ext WHERE lang = "fr"');
    $nbL = $req_nbL->fetchAll();
    // Ajout du bon nombre de description de liens pour la langue
    for ($i = 1; $i <= count($nbL) + 1; $i ++) {
        $req_addL = $bdd->prepare(
                "INSERT INTO texte  VALUES(?, 'lien', ?, 'Traduction non faite\r\n')");
        $req_addL->execute(
                array(
                        $i,
                        $ini
                ));
    }
    // Ajout du bon nombre de details des liens
    for ($i = 0; $i < count($nbL); $i ++) {
        $req_addDL = $bdd->prepare(
                "INSERT INTO lien_ext VALUES(?, ?, ?, ?, ?, 'Traduction non faite\r\n')");
        $req_addDL->execute(
                array(
                        $nbL[$i]['id'],
                        $ini,
                        $nbL[$i]['lien'],
                        $nbL[$i]['lien_img'],
                        $nbL[$i]['lien_txt']
                ));
    }
    // Ajout des revues de presse
    // Récupération des informations sur les revues de presse
    $req_nbR = $bdd->query('SELECT * FROM revue_presse');
    $nbR = $req_nbR->fetchAll();
    // Ajout du bon nombre de description de liens pour la langue
    for ($i = 1; $i <= count($nbR); $i ++) {
        $req_addL = $bdd->prepare(
                "INSERT INTO texte  VALUES(?, 'revue_presse', ?, 'Traduction non faite\r\n')");
        $req_addL->execute(
                array(
                        $i,
                        $ini
                ));
    }
    // Pas d'ajout de details (car pas de texte a traduire)
    // Ajout de l'actualité
    // Récupération des informations sur les actualités
    $req_nbA = $bdd->query('SELECT * FROM actualite WHERE lang = "fr"');
    $nbA = $req_nbA->fetchAll();
    
    // Ajout des informations sur les actualités
    $req_addA = $bdd->prepare(
            "INSERT INTO actualite  VALUES 
								  ('danse', ?, ?, ?, ?, 'Traduction pas faite', ?),
								  ('theatre', ?, ?, ?, ?, 'Traduction pas faite', ?)");
    $req_addA->execute(
            array(
                    $ini,
                    $nbA[0]['act_lieu'],
                    $nbA[0]['act_date'],
                    $nbA[0]['act_heure'],
                    $nbA[0]['act_img'],
                    $ini,
                    $nbA[1]['act_lieu'],
                    $nbA[1]['act_date'],
                    $nbA[1]['act_heure'],
                    $nbA[1]['act_img']
            ));
    // Ajout des expressions pour parfaire la traduction
    // Récupération des informations sur les traductions annexes
    $req_nbT = $bdd->query('SELECT * FROM tradannexe WHERE lang = "fr"');
    $nbT = $req_nbT->fetchAll();
    // Ajout des traductions annexes
    for ($i = 0; $i < count($nbT); $i ++) {
        $req_addT = $bdd->prepare(
                "INSERT INTO tradannexe  VALUES(?, ?, 'A traduire')");
        $req_addT->execute(
                array(
                        $ini,
                        $nbT[$i]['nomTrad']
                ));
    }
}

/*
 * Fonction supprLang Langage : PHP
 *
 * Fonction de suppression de langue dans la base de données
 *
 * @author Pierre Gaboriaud et Yohan Delmas (IUT de Rodez) Années 2009-2011
 * @param ini Initiales de la nouvelle langue
 *
 */
function supprLang ($ini)
{
    $bdd = new Connection();
    // Suppression des textes de la langue
    $requete = "DELETE FROM texte WHERE lang = " . $ini;
    $result = $bdd->select($requete);
    
    // Suppression de la boutique de la langue
    $requete = "DELETE FROM boutique WHERE lang = " . $ini;
    $result = $bdd->select($requete);
    
    // Suppression des liens de la langue
    $requete = "DELETE FROM lien_ext WHERE lang =" . $ini;
    $result = $bdd->select($requete);
    
    // Suppression de l'actualité de la langue
    $requete = "DELETE FROM actualite WHERE lang = " . $ini;
    $result = $bdd->select($requete);
    
    // Suppressiion des traductions annexes
    $requete = "DELETE FROM tradannexe WHERE lang = " . $ini;
    $result = $bdd->select($requete);
}

/**
 * Renvoie l'identifiant d'un membre en fonction de son pseudo
 */
function getId ($pseudo)
{
    $bdd = new Connection();
    $stmt = $bdd->prepare("SELECT * FROM user WHERE pseudo=?");
    $stmt->bindValue(1, $pseudo);
    $stmt->execute();
    return $stmt->rowCount() == 1 ? $stmt->fetch()["id_membre"] : - 1;
}

/* Fonction pour recuperer un tableau de la playlist courante */
function recup_actuel_playlist ()
{
    $bdd = new Connection();
    $i = 0;
    $retour = array();
    $sql = "SELECT * FROM playlist WHERE music_active = 'A'
            ORDER BY music_nom";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    
    while ($row = $stmt->fetch()) {
        $retour[$i ++] = extractMusicFromARow($row);
    }
    return $retour;
}

/* Fonction pour recuperer un tableau de toutes les musiques disponibles */
function recup_all_music ()
{
    $bdd = new Connection();
    $i = 0;
    $retour = array();
    $sql = "SELECT * FROM playlist ORDER BY music_nom";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    
    while ($row = $stmt->fetch()) {
        $retour[$i ++] = extractMusicFromARow($row);
    }
    return $retour;
}

/**
 * function pour récupérer de manière unifiée les infos sur les musiques
 */
function extractMusicFromARow ($row)
{
    $retour = array();
    $retour["id"] = $row["music_id"];
    $retour["titre"] = $row["music_nom"];
    $retour["lien"] = $row["music_lien"];
    $retour["statut"] = $row["music_active"];
    $retour["groupe"] = isset($row["music_groupe"]) ? $row["music_groupe"] : 'Inconnu';
    return $retour;
}

/**
 * Retourne la traduction des infos pour le lecteur
 */
function getPlayerTrad ()
{
    $bdd = new Connection();
    // Recupération des textes pour le lectuer sur une autre page
    $req_recupPlayer = $bdd->prepare(
            "SELECT valeurTrad FROM tradannexe WHERE lang = ? AND nomTrad LIKE 'player%' ");
    $req_recupPlayer->execute(
            array(
                    $_SESSION['lang']
            ));
    return $req_recupPlayer->fetchAll();
}

/**
 * Ajoute un fichier sur le serveur
 *
 * @param String $basedir
 *            Repertoire dans lequel ajouté le fichier
 * @param String $prefix
 *            Prefixe à ajouter au fichier
 * @param array $format
 *            Format de fichiers autorisés
 * @param array $file
 *            Le fichier à upload
 */
function upload_file ($basedir, $format, $file, $prefix = "")
{
    // nom du fichier choisi:
    $nomFichier = str_replace(' ', '', $file["name"]);
    // nom temporaire sur le serveur:
    $nomTemporaire = str_replace(' ', '', $file["tmp_name"]);
    // type du fichier choisi:
    $typeFichier = $file["type"];
    // poids en octets du fichier choisit:
    $poidsFichier = $file["size"];
    // code de l'erreur si jamais il y en a une:
    $codeErreur = $file["error"];
    
    // Supression des caractères accentués
    $nom_fichier = strtr(trim($nomFichier), 
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
    
    $emplacement = $basedir . $prefix . $nom_fichier;
    
    // Vérification du format de fichier
    if ($format[array_search($typeFichier, $format)] != $typeFichier) {
        throw new InvalidArgumentException("Type invalide");
    }
    
    // Cas où le fichier est déjà là
    if (file_exists($emplacement)) {
        throw new InvalidArgumentException(
                "Un fichier avec le même nom existe déjà");
    }
    
    // Vérification de l'ajout
    if (move_uploaded_file($nomTemporaire, $emplacement)) {
        return ($emplacement);
    } else {
        throw new Exception("Erreur lors de la création du fichier");
    }
}

/**
 * Inverse le statut d'une musique : actif => inactif & inversement
 *
 * @param Integer $id
 *            L'id de la musique concerné
 */
function toggleStatutMusic ($id)
{
    // Récupère les infos dans la BD
    $bdd = new Connection();
    $stmt = $bdd->prepare("SELECT * FROM playlist WHERE music_id = ?");
    $stmt->bindValue(1, $id);
    $stmt->execute();
    if ($row = $stmt->fetch()) {
        // Maj dans la BD
        $stmt2 = $bdd->prepare(
                "UPDATE playlist SET music_active=:stat WHERE music_id=:id");
        $stmt2->bindValue(":stat", $row["music_active"] == 'A' ? 'F' : 'A');
        $stmt2->bindValue(":id", $id);
        $stmt2->execute();
        return true;
    } else {
        return false;
    }
}

/**
 * Supprime une musique de la base de donnée et du serveur
 *
 * @param Integer $id
 *            L'id de la musique concerné
 */
function deleteMusic ($id)
{
    // Récupère les infos dans la BD
    $bdd = new Connection();
    $stmt = $bdd->prepare("SELECT * FROM playlist WHERE music_id = ?");
    $stmt->bindValue(1, $id);
    $stmt->execute();
    if ($row = $stmt->fetch()) {
        // Maj dans la BD
        $stmt2 = $bdd->prepare("DELETE FROM playlist WHERE music_id=:id");
        $stmt2->bindValue(":id", $id);
        $stmt2->execute();
        unlink($row["music_lien"]);
        return true;
    } else {
        return false;
    }
}

/**
 * Ajoute une musique dans la base de donnée
 *
 * @param String $path
 *            Chemin du fichier audio
 * @param String $band
 *            Nom de l'artiste
 * @param String $nom
 *            Titre de la musique
 */
function insertMusic ($path, $band, $nom)
{
    $bdd = new Connection();
    $sql = "INSERT INTO playlist (music_nom, music_lien, music_groupe, music_active)
            VALUES(:nom, :lien, :groupe, 'A')";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(":nom", $nom);
    $stmt->bindValue(":lien", $path);
    $stmt->bindValue(":groupe", $band);
    $stmt->execute();
    return $stmt;
}

/* Fonction pour recuperer un tableau du diaporama courant */
function recup_actuel_diapos ()
{
    $bdd = new Connection();
    $i = 0;
    $retour = array();
    $sql = "SELECT * FROM diaporama WHERE diapo_active = 'A'";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    
    while ($row = $stmt->fetch()) {
        $retour[$i ++] = extractDiapoFromARow($row);
    }
    return $retour;
}

/* Fonction pour recuperer un tableau de toutes les diapositives disponibles */
function recup_all_diapos ()
{
    $bdd = new Connection();
    $i = 0;
    $retour = array();
    $sql = "SELECT * FROM diaporama";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    
    while ($row = $stmt->fetch()) {
        $retour[$i ++] = extractDiapoFromARow($row);
    }
    return $retour;
}

/**
 * function pour récupérer de manière unifiée les infos sur les diapositives
 */
function extractDiapoFromARow ($row)
{
    $retour = array();
    $retour["id"] = $row["diapo_id"];
    $retour["lien"] = $row["diapo_lien"];
    $retour["statut"] = $row["diapo_active"];
    return $retour;
}

/**
 * Inverse le statut d'une diapositive : actif => inactif & inversement
 *
 * @param Integer $id
 *            L'id de la diapositive concerné
 */
function toggleStatutDiapo ($id)
{
    // Récupère les infos dans la BD
    $bdd = new Connection();
    $stmt = $bdd->prepare("SELECT * FROM diaporama WHERE diapo_id = ?");
    $stmt->bindValue(1, $id);
    $stmt->execute();
    if ($row = $stmt->fetch()) {
        // Maj dans la BD
        $stmt2 = $bdd->prepare(
                "UPDATE diaporama SET diapo_active=:stat WHERE diapo_id=:id");
        $stmt2->bindValue(":stat", $row["diapo_active"] == 'A' ? 'F' : 'A');
        $stmt2->bindValue(":id", $id);
        $stmt2->execute();
        return true;
    } else {
        return false;
    }
}

/**
 * Supprime une diapositive de la base de donnée et du serveur
 *
 * @param Integer $id
 *            L'id de la photo concerné
 */
function deleteDiapo ($id)
{
    // Récupère les infos dans la BD
    $bdd = new Connection();
    $stmt = $bdd->prepare("SELECT * FROM diaporama WHERE diapo_id = ?");
    $stmt->bindValue(1, $id);
    $stmt->execute();
    if ($row = $stmt->fetch()) {
        // Maj dans la BD
        $stmt2 = $bdd->prepare("DELETE FROM diaporama WHERE diapo_id=:id");
        $stmt2->bindValue(":id", $id);
        $stmt2->execute();
        unlink($row["diapo_lien"]);
        return true;
    } else {
        return false;
    }
}

/**
 * Ajoute une photo au diaporama
 *
 * @param String $path
 *            Chemin du fichier image
 */
function insertDiapo ($path)
{
    $bdd = new Connection();
    $sql = "INSERT INTO diaporama (diapo_lien, diapo_active)
            VALUES(:lien, 'A')";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(":lien", $path);
    $stmt->execute();
    return $stmt;
}

/**
 * Renvoi les langages pour lesquels le site web est utilisable
 *
 * @return array La liste des langages disponibles
 */
function getLanguages ()
{
    $i = 0;
    $bdd = new Connection();
    $return = array();
    $stmt = $bdd->prepare("SELECT * FROM lang");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $return[$i]["id"] = $row["lang_id"];
        $return[$i]["name"] = $row['lang_nom'];
        $return[$i]["code"] = $row['lang_code'];
        $i ++;
    }
    return $return;
}

/**
 * Renvoi les codes des langages supportés
 *
 * @return array La liste des langages disponibles
 */
function getSupportedLanguages ()
{
    $i = 0;
    $bdd = new Connection();
    $return = array();
    $stmt = $bdd->prepare("SELECT * FROM lang");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $return[] = $row["lang_code"];
    }
    return $return;
}

/**
 * Effectue la conversion entre le code d'une langue et son identifiant
 *
 * @param String $code
 *            Le code international de la langue
 * @return int L'identifiant de la langue ou -1 si inconnu
 */
function reverseLanguage ($code)
{
    $bdd = new Connection();
    $stmt = $bdd->prepare("SELECT lang_id FROM lang WHERE lang_code=?");
    $stmt->bindValue(1, $code);
    $stmt->execute();
    
    return $stmt->rowCount() > 0 ? $stmt->fetch()[0] : - 1;
}
?>