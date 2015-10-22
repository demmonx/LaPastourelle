<?php

function new_lien ()
{
	//nom du fichier choisi:
	$nomFichier    = $_FILES["fichier_choisi"]["name"] ;
	//nom temporaire sur le serveur:
	$nomTemporaire = $_FILES["fichier_choisi"]["tmp_name"] ;
	//type du fichier choisi:
	$typeFichier   = $_FILES["fichier_choisi"]["type"] ;
	//poids en octets du fichier choisit:
	$poidsFichier  = $_FILES["fichier_choisi"]["size"] ;
	//code de l'erreur si jamais il y en a une:
	$codeErreur    = $_FILES["fichier_choisi"]["error"] ;
	
	$rand = rand(5, 50000);
	$chemin = "./image/blog/";
        $random_fichier = $rand."_".$nomFichier; //créé un nom de fichier aléatoire pour éviter les doublons
		$emplacement=$chemin.$random_fichier;
	if(copy($nomTemporaire, $emplacement))
	{
		return($emplacement);
	}
	else
	{
	   echo("<br>Probleme avec l'image") ;
	   return(-1);
    }
}	

?>