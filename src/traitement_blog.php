<?php
@session_start();
header('Content-Type: text/html; charset=utf-8');
require_once "inc.function.php";

// Vérification de la connexion
verifLoginWithArray($_SESSION, 0);

			
// Teste les entrées
$choix = filter_input ( INPUT_POST, 'ac', FILTER_VALIDATE_INT );
$action = filter_input ( INPUT_GET, 'ac', FILTER_VALIDATE_INT );
$id = filter_input ( INPUT_GET, 'id', FILTER_VALIDATE_INT );
$photo = filter_input ( INPUT_POST, 'photo', FILTER_VALIDATE_INT );
$description = filter_input ( INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS );
$content = filter_input ( INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS );

// cas d'erreur
if (! (($action && $id) || (isset ( $_FILES ["fichier"] ) && $choix) || ($choix && $photo && $content))) {
	exit ( "Erreur lors de la réalisation de l'action" );
}

// else
if ($action) {
	verifLoginWithArray($_SESSION, 1);
	// On met à jour les infos
	switch ($action) {
		case 1 :
			// Suppression de commentaire
			deleteBlogComment ( $id );
			exit ( "Suppression effectuée avec succès" );
			break;
		case 2 :
			// Suppression de photo
			if (deleteBlogPic ( $id )) {
				exit ( "Suppression effectuée avec succès" );
			} else {
				exit ( "Erreur lors de la suppression" );
			}
			break;
		
		default :
			exit ( "L'action selectionnée est invalide" );
	}
} // else
  
// On ajoute des infos
if ($choix) {
	
	switch ($choix) {
		
		// Ajout des photos
		case 1 :
			verifLoginWithArray($_SESSION, 1);
			$file = $_FILES ["fichier"];
			
			// On ajoute une musique
			try {
				// Ajout du fichier sur le serveur
				$path = upload_file ( "image/blog/", array (
						"image/png",
						"image/x-png",
						"image/jpeg",
						"image/pjpeg",
						"image/gif" 
				), $file, rand ( 5, 50000 ) );
				
				// Création des champs facultatifs
				$description = isset ( $description ) && $description ? $description : null;
				
				// Insertion dans la BD
				if (addBlogPic ( $path, $description )) {
					exit ( "Ajout effectué avec succès" );
				} else {
					exit ( "Erreur lors de l'ajout" );
				}
			} catch ( Exception $e ) {
				exit ( $e->getMessage () );
			}
			break;
			
			// Ajout de commentaires
		case 2 :
			addBlogComment($content, $_SESSION['id'], $photo);
			exit ( "Ajout effectuée avec succès" );
			break;
		
		default :
			exit ( "L'action selectionnée est invalide" );
	}
} // else
