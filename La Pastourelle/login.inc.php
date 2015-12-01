<?php
require_once 'footer.inc.php';
/**
 * Vérifie la connexion d'un membre
 * 
 * @param string $login
 *        	Le pseudo du membre
 * @param string $pass
 *        	Le mot de passe du membre
 * @param integer $level
 *        	Le niveau d'accès requis par la page
 * @throws Exception si les informations de connexion n'ont pas permises d'identifier le membre
 *         Si son compte n'a pas été validé ou si son niveau d'accès est insuffisant
 * @return boolean true dans le cas nominal
 */
function checkLogin($login, $pass, $level) {
	// Vérification de l'existance d'un membre avec le pseudo $login et le mot
	// de passe $pass
	$bdd = new Connection ();
	$req_connect = $bdd->prepare ( 'SELECT * FROM tuser WHERE pseudo = ? AND motdepasse = ?' );
	$req_connect->bindValue ( 1, $login );
	$req_connect->bindValue ( 2, $pass );
	$req_connect->execute ();
	
	// Si on a rien recupéré false sinon true
	if ($req_connect->rowCount () != 1) {
		throw new Exception ( "Les informations saisies n'ont pas permises de vous identifier" );
	} // else
	  // On récupềre les infos du résultat
	$row = $req_connect->fetch ();
	$valid = $row ["etat_validation"];
	$niveau = $row ["niveau"];
	
	// Regarde le statut de validation
	if ($valid != 1) {
		throw new Exception ( "Votre compte doit être validé par un administrateur pour pouvoir vous connecter" );
	}
	
	// Regarde le niveau d'accès du membre
	if ($niveau < $level) {
		throw new Exception ( "Vous n'avez pas des accès suffisant pour accéder à cette page" );
	}
	return true;
}

/**
 * Vérifie la connexion d'un membre
 * 
 * @param array $infos
 *        	Les informations de connexion du membre : pseudo + pass
 * @param integer $level
 *        	Le niveau d'accès requis par la page
 * @throws Exception si les informations de connexion n'ont pas permises d'identifier le membre
 *         Si son compte n'a pas été validé ou si son niveau d'accès est insuffisant
 * @return boolean true dans le cas nominal
 */
function checkLoginWithArray($infos, $level) {
	$pseudo = isset ( $infos ["pseudo"] ) ? $infos ["pseudo"] : null;
	$pass = isset ( $infos ["pass"] ) ? $infos ["pass"] : null;
	return checkLogin ( $pseudo, $pass, $level );
}

/**
 * Vérifie la connexion d'un membre, en cas d'erreur affiche le message et arrête le programme
 * 
 * @param string $login
 *        	Le pseudo du membre
 * @param string $pass
 *        	Le mot de passe du membre
 * @param integer $level
 *        	Le niveau d'accès requis par la page
 * @param boolean $footer
 *        	Active ou désactive l'affichage du pied de page dans l'erreur
 */
function verifLogin($pseudo, $pass, $level, $footer = false) {
	try {
		checkLogin ( $pseudo, $pass, $level );
	} catch ( Exception $e ) {
		if ($footer)
			exit ( $e->getMessage () . footer () );
		else
			exit ( $e->getMessage () );
	}
}

/**
 * Vérifie la connexion d'un membre, en cas d'erreur affiche le message et arrête le programme
 * 
 * @param array $infos
 *        	Les informations de connexion du membre : pseudo + pass
 * @param integer $level
 *        	Le niveau d'accès requis par la page
 * @param boolean $footer
 *        	Active ou désactive l'affichage du pied de page dans l'erreur
 */
function verifLoginWithArray($infos, $level, $footer = false) {
	try {
		checkLoginWithArray ( $infos, $level );
	} catch ( Exception $e ) {
		if ($footer)
			exit ( $e->getMessage () . footer () );
		else
			exit ( $e->getMessage () );
	}
}