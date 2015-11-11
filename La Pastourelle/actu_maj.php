<?php
require_once 'traitement.inc.php';
/*
 * Teste si on a reçu tous les champs, même vide
 * Pour cela, besoin de lister les champs à recevoir
 */
$bdd = new Connection ();
$type = getActuType ();
$langage = getLanguages ();
foreach ( $type as $field ) {
	foreach ( $langage as $lang ) {
		if (!isset ( $_POST [$field ["type"]] [$lang ["id"]] )) {
			exit ( "Au moins un des champs n'a pas été envoyé" );
		}
	}
} // else on a tout bien reçu

// On peut faire la Maj
foreach ( $type as $field ) {
	foreach ( $langage as $lang ) {
		try {
			update_actu($_POST [$field ["type"]] [$lang ["id"]],$field ["type"], $lang ["id"] );
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
}

exit("Mise à jour réussie");