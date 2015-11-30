<?php
@session_start();
header('Content-Type: text/html; charset=utf-8');
require 'traitement.inc.php';
verifLoginWithArray($_SESSION, 1);
/*
 * Teste si on a reçu tous les champs, même vide
 * Pour cela, besoin de lister les champs à recevoir
 */
$langage = getLanguages ();
foreach ( $langage as $lang ) {
	if (! isset ( $_POST ["phrase"][$lang ["id"]] )) {
		exit ( "Au moins un des champs n'a pas été envoyé" );
	}
} // else on a tout bien reçu
  
// On peut faire la Maj
foreach ( $langage as $lang ) {
	try {
		updatePhraseJour ( $_POST  ["phrase"][$lang ["id"]], $lang ["id"] );
	} catch ( Exception $e ) {
		exit ( $e->getMessage () );
	}
}
exit("Mise à jour des informations réussie");