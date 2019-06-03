<?php
@session_start ();
@header ( 'Content-Type: text/html; charset=utf-8' );
require_once 'inc.function.php';
verifLoginWithArray ( $_SESSION, 1 );

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
			validerArticle ($id);
			exit ( "Le message a bien été validé" );
			break;
		case 2 :
			deleteMessageLivre ($id);
			exit ( "Le message a bien été supprimé" );
			break;
		case 3 :
			activerMembre ($id);
			exit ( "Le membre a bien été validé" );
			break;
		case 4 :
			if ($id == $_SESSION['id']) {
				exit("Impossible de supprimer son propre compte");
			}
			deleteMembre ($id);
			exit ( "Le membre a bien été supprimé" );
			break;
		default :
			exit ( "L'action selectionnée est invalide" );
	}
}