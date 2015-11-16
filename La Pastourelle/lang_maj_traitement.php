<?php
@session_start ();
header ( 'Content-Type: text/html; charset=utf-8' );
require_once "traitement.inc.php";
if (! isset ( $_SESSION ['pseudo'] ) || ! isset ( $_SESSION ['pass'] ) || ! verifLoAdmin ( $_SESSION ['pseudo'], $_SESSION ['pass'] )) {
	exit ( "Vous n'avez pas les droits requis" );
} // else

$action = filter_input ( INPUT_GET, 'ac', FILTER_VALIDATE_INT );
$id = filter_input ( INPUT_GET, 'id', FILTER_VALIDATE_INT );
$code = filter_input ( INPUT_POST, 'code', FILTER_SANITIZE_SPECIAL_CHARS );
$nom = filter_input ( INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS );

/* Cas d'erreur */
if (! ($action && $id || $code && $nom && $_FILES ["fichier"]))
	exit ( "L'action choisit n'est pas valide" );

/**
 * On traite les suppressions
 */
// else
if ($action) {
	// On met à jour les infos
	switch ($action) {
		case 1 :
			if (deleteLang ( $id )) {
				exit ( "Suppression effectuée avec succès" );
			} else {
				exit ( "Erreur lors de la suppression" );
			}
			break;
		default :
			exit ( "L'action selectionnée est invalide" );
	}
} // else

/**
 * On traite l'ajout d'une photo
 */
if ($code) {
	$file = $_FILES ["fichier"];
	try {
		// Ajout du fichier sur le serveur
		$image = upload_file ( "image/lang/", array (
				"image/png",
				"image/x-png",
				"image/jpeg",
				"image/pjpeg",
				"image/gif" 
		), $file );
		// Insertion dans la BD
		if (addLang ( $code, $nom, $image )) {
			exit ( "Ajout effectué avec succès" );
		} else {
			exit ( "Erreur lors de l'ajout" );
		}
	} catch ( Exception $e ) {
		exit ( $e->getMessage () );
	}
}

