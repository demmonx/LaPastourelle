<?php
@session_start ();
@header ( 'Content-Type: text/html; charset=utf-8' );
require_once "traitement.inc.php";
if (! isset ( $_SESSION ['pseudo'] ) || ! isset ( $_SESSION ['pass'] ) || ! verifLoAdmin ( $_SESSION ['pseudo'], $_SESSION ['pass'] )) {
	exit ( "Vous n'avez pas les droits requis" );
} // else

$action = filter_input ( INPUT_GET, 'ac', FILTER_VALIDATE_INT );
$id = filter_input ( INPUT_GET, 'id', FILTER_VALIDATE_INT );

/* Cas d'erreur */
if (! ($action && $id))
	exit ( "L'action choisit n'est pas valide" );

/**
 * On traite les suppressions
 */
	// else
if ($action) {
	// On met à jour les infos
	switch ($action) {
		case 1 :
			setNiveauMembre ( $id, 'membre' );
			exit ( "Le membre a bien été retiré du groupe administrateur" );
			break;
		case 2 :
			setNiveauMembre ( $id, 'administrateur' );
			exit ( "Le membre a bien été promu administrateur" );
			break;
		default :
			exit ( "L'action selectionnée est invalide" );
	}
}