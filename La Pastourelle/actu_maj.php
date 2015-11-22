<?php
@session_start();
header('Content-Type: text/html; charset=utf-8');
require_once 'traitement.inc.php';
if (! isset($_SESSION['pseudo']) or ! isset($_SESSION['pass']) or
		! verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
			exit("Vous n'avez pas les droits requis");
		} // else
/*
 * Teste si on a reçu tous les champs, même vide
 * Pour cela, besoin de lister les champs à recevoir
 */
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
			updateActu($_POST [$field ["type"]] [$lang ["id"]],$field ["type"], $lang ["id"] );
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
}

exit("Mise à jour réussie");