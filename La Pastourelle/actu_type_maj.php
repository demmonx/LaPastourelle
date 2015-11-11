<?php
@session_start();
header('Content-Type: text/html; charset=utf-8');
require_once "traitement.inc.php";
if (! isset($_SESSION['pseudo']) or ! isset($_SESSION['pass']) or
		! verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
			exit("Vous n'avez pas les droits requis");
		} // else
			
$nom = filter_input ( INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS );
if($nom) {
	try {
		addActuType($nom);
		exit("Ajout effectué avec succès");
	} catch(Exception $e) {
		exit($e->getMessage());
	}
}