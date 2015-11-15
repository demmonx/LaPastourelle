<?php
require_once ("Connection.class.php");

/**
 * ************************************
 * Récupération d'un texte dans la BD *
 * ************************************
 */
function recup_texte ($num, $page, $lang)
{
    $bdd = new Connection();
    
    // ------------------- TEST CONNECTION PDO ------------------------ //
    $sql = "SELECT texte FROM texte WHERE txt_num=? AND txt_page=? AND lang=?";
    $result = $bdd->prepare($sql);
    $result->bindValue(1, $num);
    $result->bindValue(2, $page);
    $result->bindValue(3, $lang);
    $result->execute();
    
    // Requête sur clé primaire, un seul élément possible
    return $result->fetch();
}

/**
 * h
 * ************************************
 * Récupération d'un texte dans la BD *
 * ************************************
 */
function recup_phrasejour ($lang)
{
    $bdd = new Connection();
    
    // ------------------- TEST CONNECTION PDO ------------------------ //
    $sql = "SELECT valeurtrad FROM tradannexe WHERE nomTrad ='phrasejour' AND lang=? ORDER BY nomTrad";
    $result = $bdd->prepare($sql);
    $result->bindValue(1, $lang);
    $result->execute();
    
    // Requête sur clé primaire, un seul élément possible
    return $result->fetch()['valeurtrad'];
}

/**
 * ************************************
 * Récupération d'un titre dans la BD *
 * ************************************
 */
function recup_titre ($lecontent, $lang)
{
    // ------------------- TEST CONNECTION PDO ------------------------ //
    $bdd = new Connection();
    $sql = "SELECT valeurtrad FROM tradannexe WHERE nomtrad= ? AND lang= ?";
    $result = $bdd->prepare($sql);
    $result->bindValue(1, $lecontent);
    $result->bindValue(2, $lang);
    $result->execute();
    
    // Requête sur clé primaire, un seul élément possible
    return $result->fetch();
}

/**
 * ************************************
 * Récupération des fichiers dans la base de données
 * ************************************
 */
function getFile ()
{
    $bdd = new Connection();
    
    $retour = array();
    $cpt = 0;
    
    /**
     * recupération des revues de presse
     */
    $rqt_revue = "SELECT * FROM uploaded_file ORDER BY file_adr";
    
    $result = $bdd->prepare($rqt_revue);
    $result->execute();
    
    while ($row = $result->fetch()) {
        $retour[$cpt]['id'] = $row['file_num'];
        $retour[$cpt]['adr'] = $row['file_adr'];
        $cpt ++;
    }
    
    return $retour;
}

/**
 * *********************************
 * Récupération des liens externes *
 * *********************************
 */
function recup_lienExt ()
{
    $bdd = new Connection();
    
    $retour = array();
    $cpt = 0;
    
    $rqt_lien = "SELECT * FROM lien_ext";
    $result = $bdd->prepare("SELECT * FROM lien_ext");
    
    while ($row = $result->fetch()) {
        $retour[$cpt ++] = extractLinkFromARow($row);
    }
    
    return $retour;
}

/**
 * Extraction des infos d'un lien depuis un champ de BD
 */
function extractLinkFromARow ($row)
{
    $retour = array();
    $retour['id'] = $row['lien_num'];
    $retour['url'] = $row['lien_url'];
    $retour['img'] = $row['lien_img'];
    $retour['content'] = isset($row['lien_content']) ? $row['lien_content'] : "";
    $retour['nom_prive'] = $row['lien_nom_prive'];
    $retour['nom_public'] = $row['lien_nom_admin'];
    
    return $retour;
}

/**
 * ***********************************
 * Récupération des revues de presse *
 * ***********************************
 */
function recup_revuePresse ()
{
    $bdd = new Connection();
    
    $tab_revue = array();
    $cpt = 0;
    
    /**
     * recupération des revues de presse
     */
    $rqt_revue = "SELECT * FROM revue_presse ORDER BY presse_num DESC";
    
    $result = $bdd->prepare($rqt_revue);
    $result->execute();
    
    while ($row = $result->fetch()) {
        $tab_revue[$cpt]['id'] = $row['presse_num'];
        $tab_revue[$cpt]['img'] = $row['presse_img'];
        $tab_revue[$cpt]['titre'] = $row['presse_titre'];
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
     * Modification DEMERY 2015 - Suppresion de la table annuaire => Plus de
     * redondance inutile
     * Passage en requêtes préparées pouré viter l'injection SQL
     */
    $rqt_membre = "SELECT id_membre, pseudo, email, telephone, nom, prenom, adresse, etat_annuaire FROM tuser 
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
            "SELECT * FROM tuser WHERE etat_validation = 1 AND etat_annuraire = 0 ORDER BY nom");
    $result = $stmt->execute();
    $i = 0;
    while ($row = $stmt->fetch()) {
        $tab_membre[$i ++] = extractMembreFromARow($row);
    }
    
    return $tab_membre;
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
    $result = $bdd->prepare($rqt_planning);
    $result->execute();
    
    while ($row = $result->fetch()) {
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
        $tab_planning['date'] = date("j/m/Y", strtotime($row['pl_date']));
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
    
    $retour = array(); // tableau contenant les informations des membres
                       // a recuperer
    $cpt = 0;
    
    /**
     * recupération des membre à validere
     */
    $rqt_aValider = "SELECT *
						FROM tuser WHERE etat_validation=0 ORDER BY nom";
    $result = $bdd->prepare($rqt_aValider);
    $result->execute();
    
    while ($row = $result->fetch()) {
        $retour[$cpt ++] = extractMembreFromARow($row);
    }
    
    return $retour;
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
            "SELECT * FROM tuser WHERE etat_validation = 1 AND niveau='membre' ORDER BY nom");
    $result = $stmt->execute();
    $i = 0;
    while ($row = $stmt->fetch()) {
        $tab_membre[$i ++] = extractMembreFromARow($row);
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
    $rqt_membre = "SELECT *
						FROM tuser WHERE etat_validation=1 AND pseudo=? ORDER BY pseudo";
    $result = $bdd->prepare($rqt_membre);
    $result->bindValue(1, $pseudo);
    $result->execute();
    
    if ($row = $result->fetch()) {
        $tab_membre = extractMembreFromARow($row);
    }
    
    return $tab_membre;
}

/**
 * Extrait les infos d'un membre depuis un champ de BD
 */
function extractMembreFromARow ($row)
{
    $retour = array();
    $retour['id'] = $row['id_membre'];
    $retour['pseudo'] = $row['pseudo'];
    $retour["email"] = $row['email'];
    $retour["telephone"] = $row['telephone'];
    $retour["nom"] = $row['nom'];
    $retour["prenom"] = $row['prenom'];
    $retour["adresse"] = nl2br($row['adresse']);
    $retour["etat_annuaire"] = $row['etat_annuaire'];
    return $retour;
}

/**
 * Renvoie la liste des actus disponibles pour cette langue
 *
 * @param int $lang
 *            L'identifiant de la langue
 * @param int $type
 *            L'identifiant du type d'actualité
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
     * recupération de toute l'actualite
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
        $tab_act[$cpt]['id'] = $row["act_id"];
        $tab_act[$cpt]['type'] = $row["act_type"];
        $tab_act[$cpt]['name'] = $row["act_nom"];
        $tab_act[$cpt]['img'] = isset($row["act_img"]) ? $row["act_img"] : "";
        if (isset($row["lang"]) && $row['lang'] == $lang) {
            $tab_act[$cpt]['txt'] = isset($row["content"]) ? stripnl2br(
                    $row["content"]) : "";
        }
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
        $tab_act[$cpt ++] = extractActuFromARow($row);
    }
    
    return $tab_act;
}

/**
 * Récupère les infos d'actualité à partir d'un champ de BD
 */
function extractActuFromARow ($row)
{
    $tab_act = array();
    $tab_act['id'] = $row["act_id"];
    $tab_act['type'] = $row["act_type"];
    $tab_act['name'] = $row["act_nom"];
    $tab_act['img'] = isset($row["act_img"]) ? $row["act_img"] : "";
    $tab_act['txt'] = isset($row["content"]) ? stripnl2br($row["content"]) : "";
    return $tab_act;
}

/**
 * Supprime les \n indésirables
 */
function stripnl2br ($string)
{
    return str_replace("\n", '', nl2br($string));
}

/**
 * Supprime les <br /> indésirables
 */
function stripnl2br2 ($string)
{
    return str_replace("<br />", '', nl2br($string));
}

/**
 * Récupération des coordonnées
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
    
    $result = $bdd->prepare($rqt_coord);
    $result = $bdd->execute();
    
    while ($row = $stmt->fetch()) {
        $tab_coord[$cpt]['adr'] = $row['coord_adr'];
        $tab_coord[$cpt]['tel'] = $row['coord_tel'];
        $tab_coord[$cpt]['mail'] = $row['coord_mail'];
        $tab_coord[$cpt]['img'] = $row['coord_img'];
        $tab_coord[$cpt]['id'] = $row['coord_num'];
        $cpt ++;
    }
    
    return $tab_coord;
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
            'SELECT * FROM tuser WHERE etat_validation = 1 AND pseudo = ? AND motdepasse = ?');
    $req_connect->bindValue(1, $login);
    $req_connect->bindValue(2, $pass);
    $req_connect->execute();
    
    // Si on a rien recupéré false sinon true
    return $req_connect->rowCount() == 1;
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
            "SELECT * FROM tuser WHERE etat_validation = 1 AND pseudo = ? AND motdepasse = ? AND niveau = 'administrateur'");
    $req_connect->bindValue(1, $login);
    $req_connect->bindValue(2, $pass);
    $req_connect->execute();
    
    // Si on a rien recupéré false sinon true
    return $req_connect->rowCount() == 1;
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

/**
 * Renvoie l'identifiant d'un membre en fonction de son pseudo
 */
function getId ($pseudo)
{
    $bdd = new Connection();
    $stmt = $bdd->prepare("SELECT * FROM tuser WHERE pseudo=?");
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
 * Retourne la traduction des infos pour une langue donnée et pour une partie du
 * site donnée
 */
function getTrad ($lang, $nom)
{
    $retour = array();
    $bdd = new Connection();
    // Recupération des textes pour le lectuer sur une autre page
    $stmt = $bdd->prepare(
            "SELECT valeurtrad FROM tradannexe WHERE lang = ? AND nomTrad LIKE ? ORDER BY nomTrad");
    $stmt->bindValue(1, $lang);
    $stmt->bindValue(2, $nom . '%');
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $retour[] = $row["valeurtrad"];
    }
    return $retour;
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
    
    // Créé le dossier s'il n'existe pas
    if (! file_exists($basedir)) {
        mkdir($basedir, 0777, true);
    }
    
    // On préfixe comme il faut
    if (! empty($prefixe))
        $prefix = $prefix . "_";
        
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
        @unlink($row["music_lien"]);
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
        @unlink($row["diapo_lien"]);
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
        $return[] = $row["lang_id"];
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

/**
 * Met à jour l'actualité pour un type et une langue selectionnée
 *
 * @param string $valeur
 *            La nouvelle valeur de l'actualité
 * @param string $type
 *            Le type d'actualité à mettre à jour
 * @param int $langue
 *            La langue de l'actualité
 */
function update_actu ($valeur, $type, $langue)
{
    $bdd = new Connection();
    
    // On regarde si la valeur existe déjà
    $stmt1 = $bdd->prepare(
            "SELECT * FROM actu_content 
			JOIN actualite 
			ON act_id = actu 
			WHERE act_type = :type 
			AND lang = :lang");
    $stmt1->bindValue(":lang", $langue);
    $stmt1->bindValue(":type", $type);
    $stmt1->execute();
    
    // Si pas d'objet on insère à condition que le contenu ne soit pas vide,
    // sinon inutile
    if ($stmt1->rowCount() == 0 && ! empty(trim($valeur))) {
        $stmt2 = $bdd->prepare(
                "INSERT INTO actu_content
			(content, lang, actu) VALUES (:valeur, :lang, (SELECT act_id FROM actualite WHERE act_type=:actu))");
        $stmt2->bindValue(":valeur", $valeur);
        $stmt2->bindValue(":lang", $langue);
        $stmt2->bindValue(":actu", $type);
        $stmt2->execute();
        return true;
    } else 
        if ($stmt1->rowCount() > 1) { // Plusieurs items avec même clé =
                                      // table corrompue
            throw new InvalidArgumentException(
                    "Au moins une donnée est corrompue");
        } // sinon on update
    
    $stmt2 = $bdd->prepare(
            "UPDATE actu_content 
			SET content = :valeur
			WHERE id = :id");
    $stmt2->bindValue(":valeur", $valeur);
    $stmt2->bindValue(":id", $stmt1->fetch()["id"]);
    $stmt2->execute();
    return true;
}

/**
 * Supprime le message du livre d'or qui possède cet ID
 */
function deleteMessageLivre ($id)
{
    $bdd = new Connection();
    $stmt = $bdd->prepare("DELETE FROM livreor WHERE id =?");
    $stmt->bindValue(1, $id);
    $stmt->execute();
}

/**
 * Supprime le membre qui possède cet ID
 */
function deleteMembre ($id)
{
    $bdd = new Connection();
    $stmt = $bdd->prepare("DELETE FROM tuser WHERE id_membre =?");
    $stmt->bindValue(1, $id);
    $stmt->execute();
}

/**
 * Retourne les messages actifs du livre d'or
 */
function getMessageActifLivre ()
{
    $bdd = new Connection();
    $stmt = $bdd->prepare(
            'SELECT * FROM livreor WHERE validation = 1 ORDER BY date');
    $stmt->execute();
    $retour = array();
    $i = 0;
    while ($row = $stmt->fetch()) {
        $retour[$i ++] = extractLivreFromARow($row);
    }
    return $retour;
}

/**
 * Retourne les messages en attente de validation du livre d'or
 */
function getMessageValidationLivre ()
{
    $bdd = new Connection();
    $stmt = $bdd->prepare(
            'SELECT * FROM livreor WHERE validation = 0 ORDER BY date');
    $stmt->execute();
    $retour = array();
    $i = 0;
    while ($row = $stmt->fetch()) {
        $retour[$i ++] = extractLivreFromARow($row);
    }
    return $retour;
}

/**
 * Retourne de manière unifié les champs du livre d'or
 */
function extractLivreFromARow ($row)
{
    $retour = array();
    $retour['id'] = $row['id'];
    $retour['date'] = $row['date'];
    $retour['nom'] = $row['nom'];
    $retour['message'] = $row['message'];
    $retour['validation'] = $row['validation'];
    return $retour;
}

/**
 * Valide un membre et autorise sa connexion
 *
 * @param int $id
 *            L'id du membre à activer
 */
function activerMembre ($id)
{
    $bdd = new Connection();
    $stmt = $bdd->prepare(
            "UPDATE tuser SET etat_validation = 1 WHERE id_membre = :id");
    $stmt->bindValue(1, $id);
    $stmt->execute();
}

/**
 * Valide un message du livre d'or et autorise son affichage
 *
 * @param int $id
 *            L'id de l'article à valider
 */
function validerArticle ($id)
{
    $bdd = new Connection();
    $stmt = $bdd->prepare("UPDATE livreor SET validation = 1 WHERE id = :id");
    $stmt->bindValue(1, $id);
    $stmt->execute();
}

/**
 * Ajoute un commentaire sur le blog
 *
 * @param string $msg
 *            Le message à ajouter
 * @param int $auteur
 *            L'id de l'auteur du message
 * @param int $auteur
 *            L'id de la photo commentée
 */
function addBlogComment ($msg, $auteur, $photo)
{
    $bdd = new Connection();
    $sql = "INSERT INTO commentaire (texte, num_photo, auteur) VALUES (:txt, :photo,:auteur)";
    
    $insert = $bdd->prepare($sql);
    $insert->bindValue(":txt", $msg);
    $insert->bindValue(":auteur", $auteur);
    $insert->bindValue(":photo", $photo);
    $insert->execute();
}

/**
 * Récupère les commentaires du blog
 *
 * @param int $photo
 *            L'id de l'auteur du message
 */
function getBlogComment ($photo)
{
    $retour = array();
    $sql = "SELECT C.*, U.pseudo FROM commentaire C 
			JOIN  tuser U
			ON C.auteur = U.id_membre
			WHERE num_photo = ?";
    $bdd = new Connection();
    $i = 0;
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(1, $photo);
    $stmt->execute();
    
    while ($row = $stmt->fetch()) {
        $retour[$i]['id'] = $row['id_commentaire'];
        $retour[$i]['txt'] = $row['texte'];
        $retour[$i]['photo'] = $row['num_photo'];
        $retour[$i]['auteur'] = $row['auteur'];
        $retour[$i]['pseudo'] = $row['pseudo'];
        $i ++;
    }
    return $retour;
}

/**
 * Suppression d'un commentaire de blog
 *
 * @param int $id
 *            L'id du commentaire à supprimer
 */
function deleteBlogComment ($id)
{
    $bdd = new Connection();
    $stmt = $bdd->prepare("DELETE FROM commentaire WHERE id_commentaire = ?");
    $stmt->bindValue(1, $id);
    $stmt->execute();
}

/**
 * Supprime la photo avec l'id indiqué de la base de donnée et du disque
 *
 * @param integer $id
 *            L'id de la photo a supprimer
 */
function deleteBlogPic ($id)
{
    $bdd = new Connection();
    $stmt1 = $bdd->prepare("SELECT adr_photo FROM photo WHERE id_photo = ?");
    $stmt1->bindValue(1, $id);
    $stmt1->execute();
    if ($stmt1->rowCount() == 1) {
        $stmt2 = $bdd->prepare("DELETE FROM photo WHERE id_photo = ?");
        $stmt2->bindValue(1, $id);
        $stmt2->execute();
        @unlink($stmt1->fetch()['adr_photo']);
        return true;
    }
    return false;
}

/**
 * Retourne le nombre de photos disponibles sur le blog
 */
function getNbPic ()
{
    $bdd = new Connection();
    $stmt = $bdd->prepare("SELECT COUNT(*) AS total FROM photo");
    $stmt->execute();
    return $stmt->fetch()['total'];
}

/**
 * Retourne nb photos à partir de la première
 *
 * @param integer $begin
 *            La photo initiale
 * @param integer $end
 *            Le nombre de photos
 */
function getPicByRange ($first, $nb)
{
    $retour = array();
    $sql = "SELECT * FROM photo ORDER BY date_photo DESC OFFSET ? LIMIT ?";
    $bdd = new Connection();
    $i = 0;
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(1, $first);
    $stmt->bindValue(2, $nb);
    $stmt->execute();
    
    while ($row = $stmt->fetch()) {
        $retour[$i]['id'] = $row['id_photo'];
        $retour[$i]['txt'] = $row['description'];
        $retour[$i]['adr'] = $row['adr_photo'];
        $retour[$i]['date'] = $row['date_photo'];
        $i ++;
    }
    return $retour;
}

/**
 * Ajoute une photo sur le blog avec sa description
 *
 * @param string $path
 *            Le chemin de la photo
 * @param string $description
 *            Sa description
 */
function addBlogPic ($path, $description = null)
{
    $bdd = new Connection();
    $insertion_photo = "INSERT INTO photo (adr_photo, date_photo, description) VALUES (:path,NOW(),:desc)";
    
    $insert = $bdd->prepare($insertion_photo);
    $insert->bindValue(":path", $path);
    $insert->bindValue(":desc", $description);
    $insert->execute();
    return true;
}

/**
 * MEt à jour la phrase de la semaine pour une langue donnée
 *
 * @param string $content
 *            La nouvelle phrase
 * @param integer $lang
 *            La langue
 */
function updatePhraseJour ($content, $lang)
{
    $bdd = new Connection();
    
    // On regarde si la valeur existe déjà
    $stmt1 = $bdd->prepare(
            "SELECT * FROM tradannexe
			WHERE nomTrad = 'phrasejour'
			AND lang = :lang");
    $stmt1->bindValue(":lang", $lang);
    $stmt1->execute();
    
    // Si pas d'objet on insère à condition que le contenu ne soit pas vide,
    // sinon inutile
    if ($stmt1->rowCount() == 0 && ! empty(trim($content))) {
        $stmt2 = $bdd->prepare(
                "INSERT INTO tradannexe
			(valeurtrad, lang, nomtrad) VALUES (:valeur, :lang, 'phrasejour')");
        $stmt2->bindValue(":valeur", $content);
        $stmt2->bindValue(":lang", $lang);
        $stmt2->execute();
        return true;
    } else 
        if ($stmt1->rowCount() > 1) { // Plusieurs items avec même clé =
                                      // table corrompue
            throw new InvalidArgumentException(
                    "Au moins une donnée est corrompue");
        } // sinon on update
    
    $modif_phrasejour = $bdd->prepare(
            "UPDATE tradannexe SET valeurTrad = ?
											  WHERE lang = ?
												AND nomTrad = 'phrasejour'");
    $modif_phrasejour->bindValue(1, $content);
    $modif_phrasejour->bindValue(2, $lang);
    $modif_phrasejour->execute();
    return true;
}

/**
 * Créé un nouveau type d'actualité
 *
 * @param string $nom
 *            Le nom du nouveau type
 */
function addActuType ($nom)
{
    // Type en minuscule, sans accent et sans espace qui sera utilisé dans les
    // requêtes
    $type = preg_replace("#[^!_a-z]+#", '', $nom);
    $bdd = new Connection();
    
    // On regarde si le type existe déjà
    $stmt = $bdd->prepare("SELECT * FROM actualite WHERE act_type = ?");
    $stmt->bindValue(1, $type);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        throw new Exception("Un type identique existe déjà");
    } // else on ajoute
    $stmt->closeCursor();
    
    $stmt = $bdd->prepare(
            "INSERT INTO actualite (act_type, act_nom) VALUES(?,?)");
    $stmt->bindValue(1, $type);
    $stmt->bindValue(2, $nom);
    $stmt->execute();
}

/**
 * Supprime l'image relative à un type d'actualité de la BD et du disque
 *
 * @param intger $id
 *            L'id du type concerné
 */
function deleteImageActu ($id)
{
    $bdd = new Connection();
    $stmt1 = $bdd->prepare("SELECT * FROM actualite WHERE act_id = ?");
    $stmt1->bindValue(1, $id);
    $stmt1->execute();
    // Vérifie si le champ existe
    if ($stmt1->rowCount() == 1) {
        $row = $stmt1->fetch();
        // Vérifie si l'image existe
        if (isset($row['act_img'])) {
            $stmt2 = $bdd->prepare(
                    "UPDATE actualite SET act_img = null WHERE act_id = ?");
            $stmt2->bindValue(1, $id);
            $stmt2->execute();
            @unlink($row['act_img']);
        }
        return true;
    }
    return false;
}

/**
 * Supprime le type d'actu de la base de donnée, supprime l'éventuelle image
 * associé du disque
 *
 * @param integer $id
 *            L'id du type concerné
 */
function deleteTypeActu ($id)
{
    $bdd = new Connection();
    if (deleteImageActu($id)) {
        $stmt2 = $bdd->prepare("DELETE FROM actualite WHERE act_id = ?");
        $stmt2->bindValue(1, $id);
        $stmt2->execute();
        return true;
    }
    return false;
}

/**
 * Change l'image relative à un type d'actualité, supprime l'ancienne du disque
 * si elle existe
 *
 * @param
 *            string Le chemin de la nouvelle image
 * @param intger $id
 *            L'id du type concerné
 */
function insertImageActu ($image, $id)
{
    $bdd = new Connection();
    deleteImageActu($id);
    $stmt2 = $bdd->prepare("UPDATE actualite SET act_img = ? WHERE act_id = ?");
    $stmt2->bindValue(1, $image);
    $stmt2->bindValue(2, $id);
    $stmt2->execute();
    return true;
}

/**
 * Retourne tous les administrateurs du site
 */
function getAdmin ()
{
    $bdd = new Connection();
    $tab_membre = array();
    
    $stmt = $bdd->prepare(
            "SELECT * FROM tuser WHERE niveau='administrateur' ORDER BY nom");
    $result = $stmt->execute();
    $i = 0;
    while ($row = $stmt->fetch()) {
        $tab_membre[$i ++] = extractMembreFromARow($row);
    }
    
    return $tab_membre;
}

/**
 * Passe le statut d'un membre inscrit à niveau, quelque soit son niveau
 * précédent
 *
 * @param integer $id
 *            L'id du membre à modifier
 */
function setNiveauMembre ($id, $niveau)
{
    $bdd = new Connection();
    $sql = "UPDATE tuser SET niveau = ? WHERE id_membre = ?";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(1, $niveau);
    $stmt->bindValue(2, $id);
    $stmt->execute();
}

/**
 * Récupère la liste des comptes rendus
 */
function getCompteRendu ()
{
    $bdd = new Connection();
    $return = array();
    
    $stmt = $bdd->prepare("SELECT * FROM compte_rendu ORDER BY cr_date DESC");
    $result = $stmt->execute();
    $i = 0;
    while ($row = $stmt->fetch()) {
        $return[$i]["txt"] = decodeREGEX($row["cr_text"]);
        $return[$i]["date"] = $row["cr_date"];
        $return[$i]["id"] = $row["cr_num"];
        $i ++;
    }
    
    return $return;
}

/**
 * Récupère le contenu de la page
 *
 * @param
 *            integer page L'id de la page concernée
 * @param
 *            intger lang La langue d'affichage
 */
function getContent ($page, $lang)
{
    $bdd = new Connection();
    $retour = array();
    
    $stmt = $bdd->prepare("SELECT * FROM texte WHERE lang=? AND txt_page =  ?");
    $stmt->bindValue(1, $lang);
    $stmt->bindValue(2, $page);
    $result = $stmt->execute();
    if ($row = $stmt->fetch()) {
        $retour['txt'] = $row['texte'];
        $retour['page'] = $row['txt_page'];
        $retour['id'] = $row['txt_num'];
        $retour['lang'] = $row['lang'];
    }
    
    return $retour;
}

/**
 * Retourne la liste des pages
 */
function getPage ()
{
    $bdd = new Connection();
    $retour = array();
    
    $stmt = $bdd->prepare("SELECT * FROM page ORDER BY page_nom");
    $result = $stmt->execute();
    $i = 0;
    while ($row = $stmt->fetch()) {
        $retour[$i]['id'] = $row['page_id'];
        $retour[$i]['code'] = $row['page_code'];
        $retour[$i]['nom'] = $row['page_nom'];
        $i ++;
    }
    
    return $retour;
}

/**
 * Créé une nouvelle page
 *
 * @param string $nom
 *            Le nom public de la nouvelle page
 */
function addPage ($nom)
{
    // Type en minuscule, sans accent et sans espace qui sera utilisé dans les
    // requêtes
    $code = preg_replace("#[^!_a-z]+#", '', $nom);
    $bdd = new Connection();
    
    // On regarde si le type existe déjà
    $stmt = $bdd->prepare("SELECT * FROM page WHERE page_code = ?");
    $stmt->bindValue(1, $code);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        throw new Exception("Une page identique existe déjà");
    } // else on ajoute
    $stmt->closeCursor();
    
    $stmt = $bdd->prepare("INSERT INTO page (page_code, page_nom) VALUES(?,?)");
    $stmt->bindValue(1, $code);
    $stmt->bindValue(2, $nom);
    $stmt->execute();
    return true;
}

/**
 * Supprime la page avec l'id mentionné
 *
 * @param integer $id
 *            L'identifiant de la page à supprimer
 */
function deletePage ($id)
{
    $bdd = new Connection();
    $stmt = $bdd->prepare("DELETE FROM page WHERE page_id = ?");
    $stmt->bindValue(1, $id);
    $stmt->execute();
    return true;
}

/**
 * Décode tous les tags insérables dans une chaine et les convertit en balise
 * html
 *
 * @param string $str
 *            La chaine à convertir
 * @return string La chaine convertie
 */
function decodeREGEX ($str)
{
    $str = preg_replace('`\{image}(.+)\{/image\}`iUs', 
            '<img src="$1" alt="Image" /> ', $str);
    $str = preg_replace('`\{b}(.+)\{/b\}`iUs', '<b>$1</b>', $str);
    $str = preg_replace('`\{i}(.+)\{/i\}`iUs', '<i>$1</i>', $str);
    $str = preg_replace('`\{titre1}(.+)\{/titre1\}`iUs', '<h1>$1</h1>', $str);
    $str = preg_replace('`\{titre2}(.+)\{/titre2\}`iUs', '<h2>$1</h2>', $str);
    $str = preg_replace('`\{video}(.+)\{/video\}`iUs', 
            "<video controls src='$1'></video>", $str);
    
    return $str;
}

/**
 * Met à jour le contenu d'une page
 *
 * @param
 *            integer page L'id de la page concernée
 * @param
 *            intger lang La langue d'affichage
 * @param string $content
 *            Le nouveau contenu de la page
 */
function setContent ($page, $lang, $content)
{
    $bdd = new Connection();
    
    // On regarde si la valeur existe déjà
    $stmt1 = $bdd->prepare(
            "SELECT * FROM texte
			JOIN page
			ON txt_page = page_id
			WHERE page_id = :page
			AND lang = :lang");
    $stmt1->bindValue(":lang", $lang);
    $stmt1->bindValue(":page", $page);
    $stmt1->execute();
    
    // Si pas d'objet on insère à condition que le contenu ne soit pas vide,
    // sinon inutile
    if ($stmt1->rowCount() == 0 && ! empty(trim($content))) {
        $stmt2 = $bdd->prepare(
                "INSERT INTO texte
			(txt_page, lang, texte) VALUES (:page, :lang, :content)");
        $stmt2->bindValue(":page", $page);
        $stmt2->bindValue(":lang", $lang);
        $stmt2->bindValue(":content", $content);
        $stmt2->execute();
        return true;
    } else 
        if ($stmt1->rowCount() > 1) { // Plusieurs items avec même clé =
                                      // table corrompue
            throw new InvalidArgumentException(
                    "Au moins une donnée est corrompue");
        } // sinon on update
    
    $stmt2 = $bdd->prepare(
            "UPDATE texte
			SET texte = :valeur
			WHERE txt_num = :id");
    $stmt2->bindValue(":valeur", $content);
    $stmt2->bindValue(":id", $stmt1->fetch()["txt_num"]);
    $stmt2->execute();
    return true;
}

/**
 * Met à jour le contenu d'une page
 *
 * @param
 *            integer page L'id du compte rendu concerné
 * @param string $content
 *            Le nouveau contenu du compte rendu
 */
function setCompteRendu ($id, $content)
{
    $bdd = new Connection();
    $stmt = $bdd->prepare(
            "UPDATE compte_rendu
			SET cr_text = :valeur
			WHERE cr_num = :id");
    $stmt->bindValue(":valeur", $content);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    return true;
}

/**
 * Inscrit un nouveau membre dans la base de données
 *
 * @param array $var
 *            Les informations du membre à inscrire
 */
function inscriptionBDD ($var)
{
    $bdd = new Connection();
    
    // récupération des données du formulaire
    $pseudo = $var["pseudo"];
    $mdp = sha1($var["mdp"]);
    $email = $var["email"];
    $tel = $var["tel"];
    $nom = strtoupper($var["nom"]);
    $prenom = ucfirst($var["prenom"]);
    $adresse = $var["adresse"];
    $etat_annuaire = 0;
    if (isset($var["etat_annuaire"]) && $var["etat_annuaire"] == "true") {
        $etat_annuaire = 1;
    }
    
    // regarde si l'user existe deja
    $rqt_user = "SELECT pseudo FROM tuser WHERE pseudo=?";
    $les_user = $bdd->prepare($rqt_user);
    $les_user->bindValue(1, $pseudo, PDO::PARAM_STR);
    $les_user->execute();
    
    // Regarde si le membre existe déjà
    if ($les_user->rowCount() != 0) {
        return false;
    }
    // insertion dans la base de données du nouvel user
    $sql = "INSERT INTO tuser (pseudo, motdepasse, email, etat_validation, niveau, telephone, nom, prenom, adresse, etat_annuaire)
						VALUES (:pseudo, :pass, :mail, 0, 'membre', :tel, :nom, :prenom, :adresse, :annuaire)";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $stmt->bindValue(':pass', $mdp, PDO::PARAM_STR);
    $stmt->bindValue(':mail', $email, PDO::PARAM_STR);
    $stmt->bindValue(':tel', $tel, PDO::PARAM_INT);
    $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $stmt->bindValue(':adresse', $adresse, PDO::PARAM_STR);
    $stmt->bindValue(':annuaire', $etat_annuaire, PDO::PARAM_INT);
    $stmt->execute();
    
    // message de confirmation d'inscription et retour à l'accueil
    return true;
}

/**
 * Ajoute un nouveau compte rendu dans la base de données
 *
 * @param string $content
 *            Le contenu du compte rendu
 * @param string $date
 *            La date de la réunion du compte rendu
 * @return boolean true si ajout effectué, false si la date est invalide
 */
function addCompteRendu ($content, $date)
{
    // Date invalide
    try {
        new DateTime($date);
    } catch (Exception $e) {
        return false;
    }
    
    $bdd = new Connection();
    $stmt = $bdd->prepare(
            "INSERT INTO compte_rendu (cr_text, cr_date) VALUES (:content, :date)");
    $stmt->bindValue(":content", $content);
    $stmt->bindValue(":date", $date);
    $stmt->execute();
    return true;
}

/**
 * Supprime un compte rendu de la base de données
 *
 * @param integer $id
 *            L'identifiant du compte rendu à supprimer
 */
function deleteCompteRendu ($id)
{
    $bdd = new Connection();
    $stmt = $bdd->prepare("DELETE FROM compte_rendu WHERE cr_num=?");
    $stmt->bindValue(1, $id);
    $stmt->execute();
}

/**
 * Modifie les informations d'un évènement du planning
 *
 * @param string $jour
 *            Le jour de la semaine
 * @param string $musiciens
 *            Les musiciens qui vont jouer
 * @param string $date
 *            La date de l'évènement
 * @param string $lieu
 *            Le lieu de l'évènement
 * @param integer $id
 *            L'identifiant de l'évènement
 * @return boolean true si la modification a pu se faire, false sinon
 */
function setDatePlanning ($jour, $musiciens, $date, $lieu, $id)
{
    // Date invalide
    try {
        new DateTime($date);
    } catch (Exception $e) {
        return false;
    }
    $bdd = new Connection();
    // MAJ de la BD
    $sql = "UPDATE planning SET pl_jour=:jour, pl_musiciens=:music, pl_date=:date, pl_lieu=:lieu
				 WHERE id_planning = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(":jour", $jour);
    $stmt->bindValue(":music", $musiciens);
    $stmt->bindValue(":date", $date);
    $stmt->bindValue(":lieu", $lieu);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    return true;
}

/**
 * Ajoute un fichier sur le site
 *
 * @param string $path
 *            Le chemin de l'image à ajouter
 */
function addFile ($path)
{
    $bdd = new Connection();
    $sql = "INSERT INTO uploaded_file (file_adr) VALUES (:path)";
    
    $insert = $bdd->prepare($sql);
    $insert->bindValue(":path", $path);
    $insert->execute();
    return true;
}

/**
 * Supprime le fichier avec l'id indiqué de la BD et du disque
 *
 * @param integer $id
 *            L'id de la photo a supprimer
 */
function deleteFile ($id)
{
    $bdd = new Connection();
    $stmt1 = $bdd->prepare(
            "SELECT file_adr FROM uploaded_file WHERE file_num = ?");
    $stmt1->bindValue(1, $id);
    $stmt1->execute();
    if ($stmt1->rowCount() == 1) {
        $stmt2 = $bdd->prepare("DELETE FROM uploaded_file WHERE file_num = ?");
        $stmt2->bindValue(1, $id);
        $stmt2->execute();
        @unlink($stmt1->fetch()['file_adr']);
        return true;
    }
    return false;
}

/**
 * Ajoute une nouvelle revue
 *
 * @param string $titre
 *            Son titre
 * @param string $img
 *            Son image
 */
function addRevue ($titre, $img)
{
    $bdd = new Connection();
    $sql = "INSERT INTO revue_presse (presse_titre, presse_img) VALUES (:titre, :path)";
    
    $insert = $bdd->prepare($sql);
    $insert->bindValue(":titre", $titre);
    $insert->bindValue(":path", $img);
    $insert->execute();
    return true;
}

/**
 * Supprime la revue avec l'id indiqué de la BD et du disque
 *
 * @param integer $id
 *            L'id de la revue a supprimer
 */
function deleteRevue ($id)
{
    $bdd = new Connection();
    $stmt1 = $bdd->prepare(
            "SELECT presse_img FROM revue_presse WHERE presse_num = ?");
    $stmt1->bindValue(1, $id);
    $stmt1->execute();
    if ($stmt1->rowCount() == 1) {
        $stmt2 = $bdd->prepare("DELETE FROM revue_presse WHERE presse_num = ?");
        $stmt2->bindValue(1, $id);
        $stmt2->execute();
        @unlink($stmt1->fetch()['presse_img']);
        return true;
    }
    return false;
}
?>