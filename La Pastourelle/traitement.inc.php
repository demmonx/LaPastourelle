<?php
require_once ("Connection.class.php");
require_once ("login.inc.php");

/**
 * Retourne tous les continents dans lesquels un voyages à été effectué par la
 * pastourelle
 */
function getVoyage ()
{
    $bdd = new Connection();
    $return = array();
    $stmt = $bdd->prepare(
            "SELECT *
			FROM logocarte
			JOIN countries P
			ON P.id_pays=pays
			JOIN continent C
			ON C.cont_id= P.code_continent
			ORDER BY code_continent, name_fr");
    $result = $stmt->execute();
    $i = 0;
    while ($row = $stmt->fetch()) {
        $return[$i ++] = extractVoyageFromARow($row);
    }
    
    return $return;
}

/**
 * Récpère les infos sur un voyage
 *
 * @param array $row
 *            Une ligne de BD
 * @return array Les infos du voyage
 */
function extractVoyageFromARow ($row)
{
    $return = array();
    $return["id"] = $row["id_logo"];
    $return["id_continent"] = $row["code_continent"];
    $return["continent"] = $row["cont_name"];
    $return["continent_code"] = $row["cont_name"];
    $return["pays_code"] = $row["code"];
    $return["pays"] = $row["name_fr"];
    $return["id_pays"] = $row["id_pays"];
    $return["titre"] = $row["titre"];
    $return["txt"] = $row["texte"];
    return $return;
}

/**
 * Retourne la liste de tous les pays d'un certain continent passé en paramètre
 *
 * @param integer $continent
 *            Le continent dont on veut les pays
 */
function getPays ($continent = null)
{
    $i = 0;
    $bdd = new Connection();
    $return = array();
    $sql = "SELECT * FROM countries ";
    if ($continent != null)
        $sql .= "WHERE code_continent = ? ";
    $sql .= "ORDER BY name_fr";
    $stmt = $bdd->prepare($sql);
    if ($continent != null) {
        $stmt->bindValue(1, $continent);
    }
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $return[$i]["id"] = $row["id_pays"];
        $return[$i]["name_fr"] = $row['name_fr'];
        $i ++;
    }
    return $return;
}

/**
 * Vérification du captcha par le système reCaptcha
 *
 * @param array $serveur
 *            La variable superglobales serveur
 * @param string $valeur
 *            La valeur du code de sécurité
 * @return boolean true si le code est valide, false sinon
 */
function verifCaptcha ($serveur, $valeur)
{
    if ($serveur['REQUEST_METHOD'] != 'POST') {
        return false;
    }
    $key = '6LdtxxETAAAAAN5MKrpW49AdK_IaEZvkYEZ_UVfU';
    $response = $valeur;
    $ip = $serveur['REMOTE_ADDR'];
    
    $gapi = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $key .
             '&response=' . $response . '&remoteip=' . $ip;
    
    $json = json_decode(file_get_contents($gapi), true);
    
    // if (!$json['success']) {
    // foreach($json['error-codes'] as $error) {
    // Erreurs possibles missing-input-secret The secret parameter is missing.
    // invalid-input-secret The secret parameter is invalid or malformed.
    // missing-input-response The response parameter is missing.
    // invalid-input-response The response parameter is invalid or malformed.
    // echo $error.'<br />';
    // }
    // return false;
    // }
    return $json['success'];
}

/**
 * ************************************
 * Récupération d'un texte dans la BD *
 * ************************************
 */
function getPhraseJour ($lang)
{
    $bdd = new Connection();
    
    // ------------------- TEST CONNECTION PDO ------------------------ //
    $sql = "SELECT phrase_content FROM phrase_jour WHERE phrase_lang=? ORDER BY phrase_id DESC";
    $result = $bdd->prepare($sql);
    $result->bindValue(1, $lang);
    $result->execute();
    
    // Requête sur clé primaire, un seul élément possible
    return $result->fetch()['phrase_content'];
}

/**
 * Récupération des traductions dans la BD pour un titre et une langue donnés
 */
function getTraduction ($titre, $lang)
{
    $bdd = new Connection();
    $sql = "SELECT content FROM traduction 
            JOIN titre ON code_titre=titre_num 
            WHERE titre_link = ? AND code_lang= ? ";
    $result = $bdd->prepare($sql);
    $result->bindValue(1, $titre);
    $result->bindValue(2, $lang);
    $result->execute();
    
    // Requête sur clé primaire, un seul élément possible
    return $result->fetch();
}

/**
 * Récupération des traductions dans la BD pour une langue donné
 */
function getTraductionLang ($lang)
{
    $bdd = new Connection();
    $sql = "SELECT content FROM traduction
            WHERE code_lang= ? ";
    $result = $bdd->prepare($sql);
    $result->bindValue(1, $lang);
    $result->execute();
    
    // Requête sur clé primaire, un seul élément possible
    return $result->fetch();
}

/**
 * Renvoie le titre de la page ou une chaine vide si pas de titre
 *
 * @param string $titre
 *            Le titre voulu
 * @param integer $lang
 *            La langue dans laquelle on veut le titre
 */
function getTitre ($titre, $lang)
{
    $titre = getTraduction($titre, $lang);
    return isset($titre["content"]) ? $titre["content"] : null;
}

/**
 * Renvoie la liste de tous les titres disponibles
 */
function getTitles ()
{
    $bdd = new Connection();
    $retour = array();
    
    $stmt = $bdd->prepare("SELECT * FROM titre ORDER BY titre_nom");
    $result = $stmt->execute();
    $i = 0;
    while ($row = $stmt->fetch()) {
        $retour[$i]['id'] = $row['titre_num'];
        $retour[$i]['nom'] = $row['titre_nom'];
        $retour[$i]['code'] = $row['titre_link'];
        $i ++;
    }
    
    return $retour;
}

/**
 * Met à jour un titre pour une langue donnée
 *
 * @param integer $lang
 *            L'identifiant de la langue du titre
 * @param integer $titre
 *            Le code du titre
 * @param string $valeur
 *            Le nouveau contenu du titre
 */
function updateTitle ($valeur, $titre, $lang)
{
    $bdd = new Connection();
    
    // On regarde si la valeur existe déjà
    $stmt1 = $bdd->prepare(
            "SELECT * FROM traduction 
			JOIN titre 
			ON titre_num = code_titre 
			WHERE  titre_link = :titre 
			AND code_lang = :lang");
    $stmt1->bindValue(":lang", $lang);
    $stmt1->bindValue(":titre", $titre);
    $stmt1->execute();
    
    // Si pas d'objet on insère à condition que le contenu ne soit pas vide,
    // sinon inutile
    if ($stmt1->rowCount() == 0 && ! empty(trim($valeur))) {
        $stmt2 = $bdd->prepare(
                "INSERT INTO traduction
			(code_lang, code_titre, content) 
             VALUES (:lang, (SELECT titre_num FROM titre WHERE titre_link = :titre), :valeur)");
        $stmt2->bindValue(":valeur", $valeur);
        $stmt2->bindValue(":lang", $lang);
        $stmt2->bindValue(":titre", $titre);
        $stmt2->execute();
        return true;
    } else 
        if ($stmt1->rowCount() > 1) { // Plusieurs items avec même clé =
                                      // table corrompue
            throw new InvalidArgumentException(
                    "Au moins une donnée est corrompue");
        } // sinon on update
    
    $stmt2 = $bdd->prepare(
            "UPDATE traduction 
			SET content = :valeur
			WHERE trad_num = :id");
    $stmt2->bindValue(":valeur", $valeur);
    $stmt2->bindValue(":id", $stmt1->fetch()["trad_num"]);
    $stmt2->execute();
    return true;
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
function getLinks ()
{
    $bdd = new Connection();
    
    $retour = array();
    $cpt = 0;
    
    $result = $bdd->prepare("SELECT * FROM lien_ext");
    $result->execute();
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
    $retour['nom'] = $row['lien_nom'];
    
    return $retour;
}

/**
 * ***********************************
 * Récupération des revues de presse *
 * ***********************************
 */
function getRevuePresse ()
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
function getAnnuaire ($recherche, $typeRecherche, $role)
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
 * ***********************************
 * Récupération des info du planning *
 * ***********************************
 */
function getPlanning ()
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
        $tab_planning[$cpt ++] = extractDatePlanningFromARow($row);
    }
    
    return $tab_planning;
}

/**
 * **********************************************
 * Récupération des info d'une date du planning *
 * **********************************************
 */
function getDatePlanning ($id)
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
        $tab_planning = extractDatePlanningFromARow($row);
    }
    
    return $tab_planning;
}

/**
 * Récupère les infos du planning à partir d'une ligne de BD
 */
function extractDatePlanningFromARow ($row)
{
    $tab_planning = array();
    $tab_planning['jour'] = $row['pl_jour'];
    $tab_planning['date'] = str_replace("-", "/", $row['pl_date']);
    $tab_planning['lieu'] = $row['pl_lieu'];
    $tab_planning['joueur'] = $row['pl_musiciens'];
    $tab_planning['id'] = $row['id_planning'];
    return $tab_planning;
}

/**
 * ************************************
 * Récupération des membres à valider *
 * ************************************
 */
function getUnvalitedMember ()
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
function getMembers ()
{
    $tab_membre = array(); // tableau contenant les informations des membres a
                           // recuperer
    
    $bdd = new Connection();
    
    $stmt = $bdd->prepare(
            "SELECT * FROM tuser WHERE etat_validation = 1 AND niveau=0 ORDER BY nom");
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
function getMember ($pseudo)
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
 * @return array Le tableau de toutes les actualités disponibles pour cette
 *         langue
 */
function getActu ($lang)
{
    $return = array(); // tableau contenant les informations des actualitées a
                       // recuperer
    $cpt = 0;
    
    $types = getActuType();
    foreach ($types as $type) {
        $return[$cpt] = getActuAdmin($lang, $type["id"]);
        $return[$cpt]['img'] = $type['img'];
        $cpt ++;
    }
    
    return $return;
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
function getActuAdmin ($lang, $type)
{
    $bdd = new Connection();
    
    $tab_act = array(); // tableau contenant les informations des actualitées a
                        // recuperer
    $cpt = 0;
    
    /**
     * recupération de toute l'actualite
     */
    $rqt_act = 'SELECT * FROM actu_content RIGHT OUTER JOIN actualite ON act_id = actu WHERE actu=? AND lang = ?';
    
    $result = $bdd->prepare($rqt_act);
    $result->bindValue(1, $type);
    $result->bindValue(2, $lang);
    $result->execute();
    
    if ($row = $result->fetch()) {
        $tab_act = extractActuFromARow($row);
    }
    
    return $tab_act;
}

/**
 * Renvoie la liste des produits disponibles pour cette langue
 *
 * @param int $lang
 *            L'identifiant de la langue
 * @return array Le tableau de toutes les produits pour cette
 *         langue
 */
function getBoutique ($lang)
{
    $return = array(); // tableau contenant les informations des actualitées a
                       // recuperer
    $cpt = 0;
    
    $products = getProducts();
    foreach ($products as $prod) {
        $return[$cpt] = getBoutiqueAdmin($lang, $prod["id"]);
        $return[$cpt]["prix"] = $prod["prix"];
        $return[$cpt]['img'] = $prod['img'];
        $cpt ++;
    }
    
    return $return;
}

/**
 * Renvoie la liste des produits disponibles pour cette langue
 *
 * @param int $lang
 *            L'identifiant de la langue
 * @param int $type
 *            L'identifiant du produit
 * @return array Le tableau de toutes les produits pour cette
 *         langue
 */
function getBoutiqueAdmin ($lang, $type)
{
    $bdd = new Connection();
    
    $tab_act = array(); // tableau contenant les informations des actualitées a
                        // recuperer
    
    /**
     * recupération de toute l'actualite
     */
    $rqt_act = 'SELECT * FROM produits_contenu RIGHT OUTER JOIN produits ON bt_prod = pd_num WHERE bt_prod=?  AND bt_lang = ?';
    
    $result = $bdd->prepare($rqt_act);
    $result->bindValue(1, $type);
    $result->bindValue(2, $lang);
    $result->execute();
    
    if ($row = $result->fetch()) {
        $tab_act = extractProductFromARow($row);
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
    $rqt_act = 'SELECT * FROM actualite ORDER BY act_nom';
    
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
    $tab_act['img'] = isset($row["act_img"]) ? $row["act_img"] : null;
    $tab_act['txt'] = isset($row["content"]) ? $row["content"] : null;
    return $tab_act;
}

/**
 *
 * @return La liste de tous les produits disponibles
 */
function getProducts ()
{
    $bdd = new Connection();
    
    $tab_act = array();
    $cpt = 0;
    
    /**
     * recupération de l'actualite
     */
    $rqt_act = 'SELECT * FROM produits ORDER BY pd_nom_admin';
    
    $result = $bdd->prepare($rqt_act);
    $result->execute();
    
    while ($row = $result->fetch()) {
        $tab_act[$cpt ++] = extractProductFromARow($row);
    }
    
    return $tab_act;
}

/**
 * Récupère les infos d'actualité à partir d'un champ de BD
 */
function extractProductFromARow ($row)
{
    $tab_act = array();
    $tab_act['id'] = $row["pd_num"];
    $tab_act['produit'] = $row["pd_nom_prive"];
    $tab_act['name_admin'] = $row["pd_nom_admin"];
    $tab_act['prix'] = $row["pd_prix"];
    $tab_act['name'] = isset($row["bt_nom_public"]) ? $row["bt_nom_public"] : null;
    $tab_act['img'] = isset($row["pd_img"]) ? $row["pd_img"] : null;
    $tab_act['txt'] = isset($row["bt_content"]) ? stripnl2br($row["bt_content"]) : null;
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
function getCoordonnees ()
{
    $bdd = new Connection();
    $tab_coord = array();
    /**
     * recupération des liens externes sous la forme : adr | mail | tel | img
     */
    $rqt_coord = "SELECT * FROM coordonnees";
    
    $result = $bdd->prepare($rqt_coord);
    $result->execute();
    
    if ($row = $result->fetch()) {
        $tab_coord['adr'] = $row['coord_adr'];
        $tab_coord['tel'] = $row['coord_tel'];
        $tab_coord['mail'] = $row['coord_mail'];
        $tab_coord['img'] = $row['coord_img'];
        $tab_coord['id'] = $row['coord_num'];
    }
    
    return $tab_coord;
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
function getPlaylist ()
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
function getMusics ()
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
function getActiveDiapos ()
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
function getDiapos ()
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
 * Renvoi les langages pour lesquels le site web est utilisable avec les détails
 *
 * @return array La liste des langages disponibles
 */
function getSupportedLanguagesFull ()
{
    $i = 0;
    $bdd = new Connection();
    $return = array();
    $stmt = $bdd->prepare(
            "SELECT * FROM lang JOIN languages_world ON lang_code=id
            WHERE NOT EXISTS(
             
            (SELECT titre_num 
            FROM titre
            WHERE titre_num NOT IN (SELECT code_titre 
            FROM traduction 
            WHERE code_lang = lang_id)))");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $return[$i ++] = extractLanguageFromARow($row);
    }
    return $return;
}

/**
 * Récupère les informations d'une langue
 *
 * @param array $row
 *            Un ligne de base de donnée
 */
function extractLanguageFromARow ($row)
{
    $return = array();
    $return["id"] = $row["lang_id"];
    $return["name"] = $row['nom_fr'];
    $return["name_en"] = $row['nom_en'];
    $return["img"] = $row['lang_img'];
    $return["code"] = $row['locale'];
    return $return;
}

/**
 * Renvoi les langages pour lesquels les fonctionnalites du site sont
 * partiellement ou totalement définie
 *
 * @return array La liste des langages disponibles
 */
function getLanguages ()
{
    $i = 0;
    $bdd = new Connection();
    $return = array();
    $stmt = $bdd->prepare(
            "SELECT * FROM lang JOIN languages_world ON lang_code = id");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $return[$i ++] = extractLanguageFromARow($row);
    }
    return $return;
}

/**
 * Renvoi les codes des langages supportés totalement
 *
 * @return array La liste des langages disponibles
 */
function getSupportedLanguages ()
{
    $i = 0;
    $bdd = new Connection();
    $return = array();
    $stmt = $bdd->prepare(
            "SELECT * FROM lang 
            WHERE NOT EXISTS(
             
            (SELECT titre_num 
            FROM titre
            WHERE titre_num NOT IN (SELECT code_titre 
            FROM traduction 
            WHERE code_lang = lang_id)))");
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
    $stmt = $bdd->prepare(
            "SELECT lang_id FROM lang JOIN languages_world ON lang_code=id WHERE locale=?");
    $stmt->bindValue(1, $code);
    $stmt->execute();
    
    return $stmt->rowCount() > 0 ? $stmt->fetch()[0] : - 1;
}

/**
 * Retourne les informations d'un language donné
 *
 * @param integer $id
 *            L'identifiant de la langue
 * @return array Les informations de la langue
 */
function getLanguage ($id)
{
    $bdd = new Connection();
    $return = array();
    $stmt = $bdd->prepare(
            "SELECT * FROM lang JOIN languages_world ON lang_code=id WHERE lang_id=? ");
    $stmt->bindValue(1, $id);
    $stmt->execute();
    if ($row = $stmt->fetch()) {
        $return["id"] = $row["lang_id"];
        $return["name"] = $row['nom_fr'];
        $return["name_en"] = $row['nom_en'];
        $return["img"] = $row['lang_img'];
        $return["code"] = $row['locale'];
    }
    return $return;
}

/**
 * Retourne la liste de toutes les langues disponibles au niveau mondiale
 * et des locales associées
 */
function getAllLanguages ()
{
    $i = 0;
    $bdd = new Connection();
    $return = array();
    $stmt = $bdd->prepare("SELECT * FROM languages_world ORDER BY nom_en");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $return[$i]["id"] = $row["id"];
        $return[$i]["name"] = $row['nom_fr'];
        $return[$i]["name_en"] = $row['nom_en'];
        $return[$i]["code"] = $row['locale'];
        $i ++;
    }
    return $return;
}

/**
 * Met à jour les infos du produit pour un produit et une langue selectionnée
 *
 * @param string $nom
 *            Le nom du produit
 * @param string $desc
 *            La description du produit
 * @param string $type
 *            Le produit à mettre à jour
 * @param int $langue
 *            La langue du produit
 */
function updateProduct ($nom, $desc, $produit, $langue)
{
    $bdd = new Connection();
    
    // On regarde si la valeur existe déjà
    $stmt1 = $bdd->prepare(
            "SELECT * FROM produits_contenu
			JOIN produits
			ON pd_num = bt_prod
			WHERE pd_nom_prive = :prod
			AND bt_lang = :lang");
    $stmt1->bindValue(":lang", $langue);
    $stmt1->bindValue(":prod", $produit);
    $stmt1->execute();
    
    // Si pas d'objet on insère à condition que le contenu ne soit pas vide,
    // sinon inutile
    if ($stmt1->rowCount() == 0 && ! empty(trim($nom))) {
        $stmt2 = $bdd->prepare(
                "INSERT INTO produits_contenu
			(bt_content, bt_nom_public, bt_lang, bt_prod) VALUES (:desc, :nom, :lang, (SELECT pd_num FROM produits WHERE pd_nom_prive=:prod))");
        $stmt2->bindValue(":desc", ! empty($desc) ? $desc : null);
        $stmt2->bindValue(":nom", $nom);
        $stmt2->bindValue(":lang", $langue);
        $stmt2->bindValue(":prod", $produit);
        $stmt2->execute();
        return true;
    } else 
        if ($stmt1->rowCount() > 1) { // Plusieurs items avec même clé =
                                      // table corrompue
            throw new InvalidArgumentException(
                    "Au moins une donnée est corrompue");
        } // sinon on update
    
    $stmt2 = $bdd->prepare(
            "UPDATE produits_contenu
			SET bt_content = :desc,
            bt_nom_public = :nom
			WHERE bt_num = :id");
    $stmt2->bindValue(":desc", ! empty($desc) ? $desc : null);
    $stmt2->bindValue(":nom", $nom);
    $stmt2->bindValue(":id", $stmt1->fetch()["bt_num"]);
    $stmt2->execute();
    return true;
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
function updateActu ($valeur, $type, $langue)
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
    return true;
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
    return true;
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
    
    // Si pas d'objet on insère à condition que le contenu ne soit pas vide,
    // sinon inutile
    if (! empty(trim($content))) {
        $stmt2 = $bdd->prepare(
                "INSERT INTO phrase_jour
			(phrase_content, phrase_lang) VALUES (:valeur, :lang)");
        $stmt2->bindValue(":valeur", $content);
        $stmt2->bindValue(":lang", $lang);
        $stmt2->execute();
    }
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
    $type = preg_replace("#[^!_a-z]+#", '', strtolower($nom));
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
 * Ajoute un nouveau produit à la boutique
 *
 * @param string $nom
 *            Le nom du nouveau produit
 * @param float $prix
 *            Le prix du nouveau produit
 */
function addProduct ($nom, $prix)
{
    // Type en minuscule, sans accent et sans espace qui sera utilisé dans les
    // requêtes
    $type = preg_replace("#[^!_a-z]+#", '', strtolower($nom));
    $bdd = new Connection();
    
    // On regarde si le type existe déjà
    $stmt = $bdd->prepare("SELECT * FROM produits WHERE pd_nom_prive = ?");
    $stmt->bindValue(1, $type);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        throw new Exception("Un produit identique existe déjà");
    } // else on ajoute
    $stmt->closeCursor();
    
    $stmt = $bdd->prepare(
            "INSERT INTO produits (pd_nom_prive, pd_nom_admin, pd_prix) VALUES(?,?,?)");
    $stmt->bindValue(1, $type);
    $stmt->bindValue(2, $nom);
    $stmt->bindValue(3, $prix);
    $stmt->execute();
}

/**
 * Créé un nouveau lien
 *
 * @param string $nom
 *            Le nom du nouveau lien
 * @param string $url
 *            l'url du lien
 */
function addLink ($nom, $url)
{
    $bdd = new Connection();
    
    // On regarde si l'url existe déjà
    $stmt = $bdd->prepare("SELECT * FROM lien_ext WHERE lien_url = ?");
    $stmt->bindValue(1, $url);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        throw new Exception("Un lien avec la même URL existe déjà");
    } // else on ajoute
    $stmt->closeCursor();
    
    $stmt = $bdd->prepare(
            "INSERT INTO lien_ext (lien_url, lien_nom) VALUES(?,?)");
    $stmt->bindValue(1, $url);
    $stmt->bindValue(2, $nom);
    $stmt->execute();
}

/**
 * Supprime l'image relative à un produit de la BD et du disque
 *
 * @param intger $id
 *            L'id du produit concerné
 */
function deleteImageProduct ($id)
{
    $bdd = new Connection();
    $stmt1 = $bdd->prepare("SELECT * FROM produits WHERE pd_num = ?");
    $stmt1->bindValue(1, $id);
    $stmt1->execute();
    // Vérifie si le champ existe
    if ($stmt1->rowCount() == 1) {
        $row = $stmt1->fetch();
        // Vérifie si l'image existe
        if (isset($row['pd_img'])) {
            $stmt2 = $bdd->prepare(
                    "UPDATE produits SET pd_img = null WHERE pd_num = ?");
            $stmt2->bindValue(1, $id);
            $stmt2->execute();
            @unlink($row['pd_img']);
        }
        return true;
    }
    return false;
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
 * Supprime l'image relative à un lien de la BD et du disque
 *
 * @param intger $id
 *            L'id du lien concerné
 */
function deleteImageLink ($id)
{
    $bdd = new Connection();
    $stmt1 = $bdd->prepare("SELECT * FROM lien_ext WHERE lien_num = ?");
    $stmt1->bindValue(1, $id);
    $stmt1->execute();
    // Vérifie si le champ existe
    if ($stmt1->rowCount() == 1) {
        $row = $stmt1->fetch();
        // Vérifie si l'image existe
        if (isset($row['lien_img'])) {
            $stmt2 = $bdd->prepare(
                    "UPDATE lien_ext SET lien_img = null WHERE lien_num = ?");
            $stmt2->bindValue(1, $id);
            $stmt2->execute();
            @unlink($row['lien_img']);
        }
        return true;
    }
    return false;
}

/**
 * Supprime le produit de la base de donnée, supprime l'éventuelle image
 * associé du disque
 *
 * @param integer $id
 *            L'id du produit concerné
 */
function deleteProduct ($id)
{
    $bdd = new Connection();
    if (deleteImageProduct($id)) {
        $stmt2 = $bdd->prepare("DELETE FROM produits WHERE pd_num = ?");
        $stmt2->bindValue(1, $id);
        $stmt2->execute();
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
 * Supprime le lien de la base de donnée, supprime l'éventuelle image
 * associé du disque
 *
 * @param integer $id
 *            L'id du lien concerné
 */
function deleteLink ($id)
{
    $bdd = new Connection();
    if (deleteImageLink($id)) {
        $stmt2 = $bdd->prepare("DELETE FROM lien_ext WHERE lien_num = ?");
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
 * Change le prix d'un produit
 *
 * @param
 *            float Le nouveau prix du produit
 * @param intger $id
 *            L'id du produit concerné
 */
function updateProductPrice ($price, $id)
{
    $bdd = new Connection();
    $stmt2 = $bdd->prepare("UPDATE produits SET pd_prix = ? WHERE pd_num = ?");
    $stmt2->bindValue(1, $price);
    $stmt2->bindValue(2, $id);
    $stmt2->execute();
    return true;
}

/**
 * Change l'image relative à un produit, supprime l'ancienne du disque
 * si elle existe
 *
 * @param
 *            string Le chemin de la nouvelle image
 * @param intger $id
 *            L'id du produit concerné
 */
function insertImageProduct ($image, $id)
{
    $bdd = new Connection();
    deleteImageProduct($id);
    $stmt2 = $bdd->prepare("UPDATE produits SET pd_img = ? WHERE pd_num = ?");
    $stmt2->bindValue(1, $image);
    $stmt2->bindValue(2, $id);
    $stmt2->execute();
    return true;
}

/**
 * Change l'image relative à un lien, supprime l'ancienne du disque
 * si elle existe
 *
 * @param
 *            string Le chemin de la nouvelle image
 * @param intger $id
 *            L'id du lien concerné
 */
function insertImageLink ($image, $id)
{
    $bdd = new Connection();
    deleteImageLink($id);
    $stmt2 = $bdd->prepare(
            "UPDATE lien_ext SET lien_img = ? WHERE lien_num = ?");
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
    
    $stmt = $bdd->prepare("SELECT * FROM tuser WHERE niveau=1 ORDER BY nom");
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
 * @param integer $niveau
 *            Le niveau d'accès autorisé
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
        $return[$i]["txt"] = $row["cr_text"];
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
						VALUES (:pseudo, :pass, :mail, 0, 0, :tel, :nom, :prenom, :adresse, :annuaire)";
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

/**
 * Suppression d'une langue
 *
 * @param integer $id
 *            L'id de la langue à supprimer
 */
function deleteLang ($id)
{
    $bdd = new Connection();
    $stmt1 = $bdd->prepare("SELECT * FROM lang WHERE lang_id = ?");
    $stmt1->bindValue(1, $id);
    $stmt1->execute();
    if ($stmt1->rowCount() == 1) {
        $stmt2 = $bdd->prepare("DELETE FROM lang WHERE lang_id = ?");
        $stmt2->bindValue(1, $id);
        $stmt2->execute();
        @unlink($stmt1->fetch()['lang_img']);
        return true;
    }
    return false;
}

/**
 * Ajout d'une langue
 */
function addLang ($code, $img)
{
    $bdd = new Connection();
    $sql = "INSERT INTO lang (lang_code, lang_img) VALUES (:code,  :img)";
    
    $insert = $bdd->prepare($sql);
    $insert->bindValue(":code", $code);
    $insert->bindValue(":img", $img);
    $insert->execute();
    
    return true;
}

/**
 * Affiche ou masque un membre de l'annuaire
 *
 * @param integer $id
 *            L'id du membre à modifier
 * @param boolean $val
 *            true si le membre doit figurer dans l'annuaire, false sinon
 */
function setMemberToAnnuaire ($id, $val = true)
{
    $bdd = new Connection();
    $req_del = $bdd->prepare(
            "UPDATE tuser SET etat_annuaire = ? WHERE id_membre=?");
    $req_del->bindValue(1, ($val ? 1 : 0));
    $req_del->bindValue(2, $id);
    $req_del->execute();
}

/**
 * Modifie les informations personnelles d'un membre
 *
 * @param array $info
 *            La liste des informations personnelles
 */
function updatePersonnalInfo ($info)
{
    $bdd = new Connection();
    
    // Si pas le bon nombre d'arguments
    if (! (count($info) == 7 || count($info) == 8)) {
        return false;
    }
    
    // Cas où l'on change le password
    if (isset($info["pass"])) {
        $sql = "UPDATE tuser SET motdepasse=:pass, email=:mail, telephone=:tel, nom=:nom, 
				prenom=:prenom, adresse=:adresse, etat_annuaire=:annuaire 
				WHERE id_membre=:id";
        $stmt = $bdd->prepare($sql);
        $stmt->bindValue(':pass', $info["pass"], PDO::PARAM_STR);
    } else {
        $sql = "UPDATE tuser SET email=:mail, telephone=:tel, nom=:nom, prenom=:prenom, 
				adresse=:adresse, etat_annuaire=:annuaire 
				WHERE id_membre=:id";
        $stmt = $bdd->prepare($sql);
    }
    
    $stmt->bindValue(':mail', $info["mail"], PDO::PARAM_STR);
    $stmt->bindValue(':tel', $info["tel"], PDO::PARAM_INT);
    $stmt->bindValue(':nom', $info["nom"], PDO::PARAM_STR);
    $stmt->bindValue(':prenom', $info["prenom"], PDO::PARAM_STR);
    $stmt->bindValue(':adresse', $info["adresse"], PDO::PARAM_STR);
    $stmt->bindValue(':annuaire', $info["annuaire"], PDO::PARAM_INT);
    $stmt->bindValue(':id', $info["id"], PDO::PARAM_INT);
    $stmt->execute();
    return true;
}

/**
 * Supprime un évènement du planning
 *
 * @param integer $id
 *            L'identifiant de l'évènement à supprimer
 */
function deleteFromPlanning ($id)
{
    $bdd = new Connection();
    $req_suppr = $bdd->prepare("DELETE FROM planning WHERE id_planning =? ");
    $req_suppr->bindValue(1, $id);
    $req_suppr->execute();
    return true;
}

/**
 * Envoie un mail
 *
 * @param string $nom
 *            Le nom de l'auteur du mail
 * @param string $email
 *            Son adresse mail
 * @param string $message
 *            Le message à envoyer
 */
function sendMail ($nom, $email, $message)
{
    // Pour définir chaque input du formulaire, ajouter le signe de dollar
    // devant
    $msg = "Nom:\t$nom\n";
    $msg .= "E-Mail:\t$email\n";
    $msg .= "Message:\t$message\n\n";
    
    // Pourrait continuer ainsi jusqu'à la fin du formulaire
    $coord = getCoordonnees();
    $recipient = isset($coord["mail"]) ? $coord["mail"] : "pastourelle.rodez@yahoo.fr";
    $subject = "Formulaire de contact";
    $mailheaders = "From:formulaire votre avis nous interesse // contact<> \n";
    $mailheaders .= "Reply-To: $email\n\n";
    mail($recipient, $subject, $msg, $mailheaders);
}

/**
 * Convertit un format de télpéhone 0101010101 en 01 01 01 01 01
 *
 * @param String $tel
 *            Le numéro à convertir
 * @return string le téléphone convertit si possible, ou la chaine d'entrée si
 *         erreur
 */
function convertPhoneNumber ($tel)
{
    if (preg_match('/^(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})$/', $tel, $matches)) {
        return $matches[1] . ' ' . $matches[2] . ' ' . $matches[3] . ' ' .
                 $matches[4] . ' ' . $matches[5];
    }
    return $tel;
}

/**
 * Met à jour les informations de contact de la pastourelle
 *
 * @param string $tel
 *            Le numéro de téléphone où l'association est joignable
 * @param string $adresse
 *            L'adresse de l'association
 * @param string $mail
 *            L'adresse mail utilisée par l'association
 * @param string $image
 *            L'image de la localisation des bureaux
 */
function updateCoor ($tel, $adresse, $mail, $image = null)
{
    $bdd = new Connection();
    $sql = "UPDATE coordonnees SET coord_adr=:adr, coord_mail=:mail, coord_tel=:tel";
    // Si on a l'image on change un peu la requete
    if ($image != null) {
        $sql .= ", coord_img=:img";
        // On récup l'ancienne image et on la supprime du disque
        $coord = getCoordonnees();
        @unlink($coord["img"]);
    }
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(':tel', $tel);
    $stmt->bindValue(':adr', $adresse);
    $stmt->bindValue(':mail', $mail);
    if ($image != null) {
        $stmt->bindValue(':img', $image);
    }
    $stmt->execute();
}

/**
 * Ajoute un évènement au planning
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
 */
function addDatePlanning ($jour, $date, $lieu, $musiciens)
{
    $bdd = new Connection();
    $stmt = $bdd->prepare(
            "INSERT INTO planning (pl_jour, pl_date, pl_lieu, pl_musiciens) 
            VALUES (:jour, :date, :lieu, :music)");
    $stmt->bindValue(':jour', $jour);
    $stmt->bindValue(':date', $date);
    $stmt->bindValue(':lieu', $lieu);
    $stmt->bindValue(':music', $musiciens);
    $stmt->execute();
    return true;
}

/**
 * Ajoute un message au livre d'or
 *
 * @param $nom Le
 *            nom de l'auteur du message
 * @param $message Le
 *            contenu du message
 */
function addMessageToLivre ($nom, $message)
{
    $bdd = new Connection();
    $addMess = $bdd->prepare(
            "INSERT INTO livreor (date, nom, message, validation)
				VALUES(NOW(), ?, ?, 0)");
    $addMess->bindValue(1, $nom);
    $addMess->bindValue(2, $message);
    $addMess->execute();
}

/**
 * Ajoute un voyage dans la base de données
 *
 * @param $continent continent
 *            du voyage
 * @param $pays pays
 *            du voyage
 * @param $lieu lieu
 *            du voyage
 * @param $titre titre
 *            du voyage
 * @param $texte description/comentaire
 *            du voyage
 */
function addVoyage ($pays, $titre, $texte)
{
    $bdd = new Connection();
    $addVoy = $bdd->prepare(
            "INSERT INTO logocarte (pays, titre, texte)
				VALUES(?, ?, ?)");
    $addVoy->bindValue(1, $pays);
    $addVoy->bindValue(2, $titre);
    $addVoy->bindValue(3, $texte);
    
    $addVoy->execute();
    
    return true;
}

/**
 * Suppression d'un voyage dans la table
 *
 * @param integer $id
 *            L'id du voyage à supprimer
 */
function deleteVoyage ($id)
{
    $bdd = new Connection();
    $stmt1 = $bdd->prepare("DELETE FROM logocarte WHERE id_logo = ?");
    $stmt1->bindValue(1, $id);
    $stmt1->execute();
    return true;
}

/**
 * Retourne la liste de touts les continents
 */
function getContinents ()
{
    $i = 0;
    $bdd = new Connection();
    $return = array();
    $stmt = $bdd->prepare("SELECT * FROM continent ORDER BY cont_id");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $return[$i]["id"] = $row["id_cont"];
        $return[$i]["code"] = $row["code"];
        $return[$i]["nom"] = $row["nom"];
        $i ++;
    }
    return $return;
}

/**
 * Retourne les détails d'un voyage donné
 */
function getVoyageDetail ($id)
{
    $bdd = new Connection();
    $return = array();
    $stmt = $bdd->prepare(
            "SELECT *
			FROM logocarte
			JOIN countries P
			ON P.id_pays=pays
			JOIN continent C
			ON C.cont_id= P.code_continent
			WHERE id_logo = ?");
    $stmt->bindValue(1, $id);
    $result = $stmt->execute();
    if ($row = $stmt->fetch()) {
        $return = extractVoyageFromARow($row);
    }
    
    return $return;
}