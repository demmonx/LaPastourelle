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
	

	$chemin = "./image/".$repertoire."/" ;
        
	if(copy($nomTemporaire, $chemin.$nomFinal.".jpg"))
	{
		echo("<CENTER><h3>Le fichier été enregistré avec succès</h3></CENTER>") ;
	}
	else
	{
	   echo("<CENTER><h3>Une erreur c'est produite lors de l'enregistrement du fichier<h3></CENTER>") ;
    }
}

function transfert_pdf()
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
	

	if(copy($nomTemporaire, "./document/bondecommande.pdf"))
	{
		echo("<CENTER><h3>l'upload a réussi</h3></CENTER>") ;
	}
	else
	{
	   echo("<CENTER><h3>l'upload a échoué</h3></CENTER>") ;
    }
}
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
	$chemin = "./image/lien/";
        $random_fichier = $rand."_".$nomFichier; //créé un nom de fichier aléatoire pour éviter les doublons
		$emplacement=$chemin.$random_fichier;
	if(copy($nomTemporaire, $emplacement))
	{
		return($emplacement);
	}
	else
	{
	   return(-1);
    }
}
function new_produit()
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
	$chemin = "./image/boutique/";
        $random_fichier = $rand."_".$nomFichier; //créé un nom de fichier aléatoire pour éviter les doublons
		$emplacement=$chemin.$random_fichier;
	if(copy($nomTemporaire, $emplacement))
	{
		return($emplacement);
	}
	else
	{
	   echo("<br>Problème avec l'image") ;
	   return(-1);
    }
}	
function new_revue ()
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
	$chemin = "./image/revue_presse/";
        $random_fichier = $rand."_".$nomFichier; //créé un nom de fichier aléatoire pour éviter les doublons
		$emplacement=$chemin.$random_fichier;
	if(copy($nomTemporaire, $emplacement))
	{
		return($emplacement);
	}
	else
	{
	   echo("<br />Un erreur c'est produite lors de la reception de l'image") ;
	   return(-1);
    }
}

?>