<?php
function transfert ()
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
	
	//repertoire ou placer le fichier
	$repertoire = $_POST["repertoire"];
	//nom sous lequel placer le fichier
	$nomFinal = $_POST["nom"];
	
	//$rand = rand(5, 50000);
	$chemin = "./image/blog/" ;
        //$random_fichier = $rand."_".$nomFichier; //créé un nom de fichier aléatoire pour éviter les doublons
	if(copy($nomTemporaire, $chemin.$nomFinal.".jpg"))
	{
		echo("<CENTER><h3>l'upload a réussi</h3></CENTER>") ;
	}
	else
	{
	   echo("<CENTER><h3>l'upload a échoué</h3></CENTER>") ;
    }
}
?>