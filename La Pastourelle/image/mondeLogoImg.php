<?php
	
	// On charge d'abord les images
	$source = imagecreatefrompng("mondeLogo/logosolo.png"); // Le logo est la source
	$destination = imagecreatefromjpeg("mondeLogo/".$_GET['continent'].".jpg"); // La photo est la destination
	
	// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
	$largeur_source = imagesx($source);
	$hauteur_source = imagesy($source);
	$largeur_destination = imagesx($destination);
	$hauteur_destination = imagesy($destination);
	
	// On veut placer le logo en bas à droite, on calcule les coordonnées où on doit placer le logo sur la photo
	$destination_x = $largeur_destination - $largeur_source;
	$destination_y =  $hauteur_destination - $hauteur_source;
	
	// on applique une transparence  
	$transparence = imagecolorallocate($source, 0, 0, 0);  
	imagefill($source, 0, 0, $transparence);  
	imagecolortransparent($source, $transparence);  

	include("../traitement.inc.php");
	$bdd = new Connection();
	$req_coord = $bdd->prepare('SELECT x, y
							  FROM logoCarte
							  WHERE continent = ?');
	$req_coord->execute(array($_GET['continent'])); 
	$coords = $req_coord->fetchAll();
	$req_coord->closeCursor();
	
	for ($i = 0; $i < count($coords); $i++) {
		$coordX = $coords[$i]['x']-12;
		$coordY = $coords[$i]['y']-68;
		// On met le logo (source) dans l'image de destination (la photo)
		imagecopymerge($destination, $source, $coordX, $coordY, 0, 0, $largeur_source, $hauteur_source, 100);
	}
	
	// On affiche l'image de destination qui a été fusionnée avec le logo
	header("Content-type: image/png");
	imagepng($destination);
	imagedestroy($destination);  
	imagedestroy($source);

?>