<?php
@session_start ();
@header ( 'Content-Type: text/html; charset=utf-8' );
require_once 'inc.function.php';
verifLoginWithArray ( $_SESSION, 1 );

/*
 * Teste si on a reçu tous les champs, même vide
 * Pour cela, besoin de lister les champs à recevoir
 */
$titre = getTitles ();
foreach ( $titre as $field ) {
	if (! isset ( $_POST [$field ["code"]] )) {
		exit ( "Au moins un des champs n'a pas été envoyé" );
	}
	if (strlen ( $_POST [$field ["code"]] ) >= 100) {
		exit ( "La traduction doit faire moins de 100 caractères" );
	}
} // else on a tout bien reçu

$lang = filter_input ( INPUT_POST, 'lang', FILTER_VALIDATE_INT );
if (! ($lang && count ( getLanguage ( $lang ) ) > 0)) {
	exit ( "La langue n'est pas valide" );
}

// On peut faire la Maj
foreach ( $titre as $field ) {
	try {
		
		updateTitle ( $_POST [$field ["code"]], $field ["code"], $lang );
	} catch ( Exception $e ) {
		exit ( $e->getMessage () );
	}
}

exit ( "Mise à jour réussie" );