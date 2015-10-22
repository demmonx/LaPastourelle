<?php

/*	Fonction pour recuperer un tableau de la playlist courante */
function recup_actuel_playlist() {
	$allAttributs;
	$doc = new DOMDocument();
	$doc->load( 'playlist.xml' );
	  
	$songs = $doc->getElementsByTagName( "song" );
	foreach( $songs as $song )
	{
		$names = $song->getElementsByTagName( "name" );
		$name = $names->item(0)->nodeValue;
	  
		$bands= $song->getElementsByTagName( "band" );
		$band= $bands->item(0)->nodeValue;
	  
		$files = $song->getElementsByTagName( "file" );
		$file = $files->item(0)->nodeValue;
		
		$allAttributs[] = $name;
		$allAttributs[] = $band;
		$allAttributs[] = $file;
	}
if (empty($allAttributs)) {
	return $allAttributs = "Aucune Chanson";
}
return $allAttributs;
}

//Exécution de la fonction de récupération de la playlist courante
$tab = recup_actuel_playlist();
if (isset($_SESSION['pseudo']) AND isset($_SESSION['pass']) AND verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) { 
	//SI UN FICHIER DOIT ETRE AJOUTE
	if(isset($_FILES['fichier'])) { 
		$dossier = 'musics/';
		$fichier = basename($_FILES['fichier']['name']);
		
		if(move_uploaded_file($_FILES['fichier']['tmp_name'], $dossier . $fichier )){
			//AJOUT DANS XML
			  $songs = array();
			  for($i=0; count($tab) > 1 AND $i < count($tab); $i+=3) {
				  $songs [] = array(
				  'name' => $tab[$i],
				  'band' => $tab[$i+1],
				  'file' => $tab[$i+2]
				  );
			  }
			$songs [] = array(
				  'name' => $_POST['nom'],
				  'band' => $_POST['band'],
				  'file' => "musics/".$_FILES['fichier']['name']
			);
			  
			$doc = new DOMDocument();
			$doc->formatOutput = true;
			  
			$r = $doc->createElement( "songs" );
			$doc->appendChild( $r );
			  
			foreach( $songs as $song ) {
				$b = $doc->createElement( "song" );
				$name = $doc->createElement( "name" );
				$name->appendChild($doc->createTextNode( $song['name'] ));
				$b->appendChild( $name );
				  
				$band = $doc->createElement( "band" );
				$band->appendChild($doc->createTextNode( $song['band'] ));
				$b->appendChild( $band );
				  
				$file = $doc->createElement( "file" );
				$file->appendChild($doc->createTextNode( $song['file'] ));
				$b->appendChild( $file );
				  
				$r->appendChild( $b );
			}
			$doc->save("playlist.xml");
			//AFFICHAGE
			echo '<center>Ajout effectué</center>';
			echo "<center><a class='btn btn-link' href='index.php?page=player'>Retour à la page précédente</a></center>";
			exit();
		} else {
			echo '<center>Ajout non effectué</center>';
		}
	}

	//SI UN FICHIER DOIT ETRE SUPPRIME
	if(isset($_GET['del'])) {
		//Suppression du fichier
		unlink($_GET['del']);
		//Suppression XML
		$doc = new DOMDocument();
		$doc->load( 'playlist.xml' );
		$songs = $doc->getElementsByTagName( "song" );
		foreach( $songs as $song ) {
			$files = $song->getElementsByTagName( "file" );
			$file = $files->item(0)->nodeValue;
			if ($file == $_GET['del']) {
						$songs = array();
					for($i=0; $i < count($tab); $i+=3) {
						if ($tab[$i+2] != $_GET['del']) {
						  $songs [] = array(
						  'name' => $tab[$i],
						  'band' => $tab[$i+1],
						  'file' => $tab[$i+2]
						  );
						}
					}
					  
					$doc = new DOMDocument();
					$doc->formatOutput = true;
					  
					$r = $doc->createElement( "songs" );
					$doc->appendChild( $r );
					  
					foreach( $songs as $song ) {
						$b = $doc->createElement( "song" );
						$name = $doc->createElement( "name" );
						$name->appendChild($doc->createTextNode( $song['name'] ));
						$b->appendChild( $name );
						  
						$band = $doc->createElement( "band" );
						$band->appendChild($doc->createTextNode( $song['band'] ));
						$b->appendChild( $band );
						  
						$file = $doc->createElement( "file" );
						$file->appendChild($doc->createTextNode( $song['file'] ));
						$b->appendChild( $file );
						  
						$r->appendChild( $b );
					}
					$doc->save("playlist.xml");
			}
		}
		echo '<center>Suppression effectuée<br />';
		echo "<a class='btn btn-link' href='index.php?page=player'>Retour à la page précédente</a></center>";
		exit();
	}

}
//Récupération des textes annexes de traduction pour cette zone
	$req_recupPlayer = $bdd->prepare("SELECT valeurTrad FROM tradannexe WHERE lang = ? AND nomTrad LIKE 'player%' ");
	$req_recupPlayer->execute(array($_SESSION['lang']));
	$recupPlayer = $req_recupPlayer->fetchAll();
?>

<p style="text-align:right;">
	<center><?php echo $recupPlayer[0]['valeurTrad']; ?> :
    <a class="btn btn-link" href="#" onClick="javascript:window.open('player.html','popup','width=182,height=102')"><?php echo $recupPlayer[1]['valeurTrad']; ?></a></center>
</p>

<center><br />
	<!--Affichage du player-->
	<div id="flashContent" style="text-align:center;background-color:black;">
		<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="182" height="102" id="player" align="middle">
			<param name="movie" value="player.swf" />
			<param name="quality" value="best" />
			<param name="bgcolor" value="#ffffff" />
			<param name="play" value="true" />
			<param name="loop" value="true" />
			<param name="wmode" value="transparent" />
			<param name="scale" value="showall" />
			<param name="menu" value="true" />
			<param name="devicefont" value="false" />
			<param name="salign" value="" />
			<param name="allowScriptAccess" value="sameDomain" />
			<!--[if !IE]>-->
			<object type="application/x-shockwave-flash" data="player.swf" width="182" height="102">
				<param name="movie" value="player.swf" />
				<param name="quality" value="best" />
				<param name="bgcolor" value="#ffffff" />
				<param name="play" value="true" />
				<param name="loop" value="true" />
				<param name="wmode" value="transparent" />
				<param name="scale" value="showall" />
				<param name="menu" value="true" />
				<param name="devicefont" value="false" />
				<param name="salign" value="" />
				<param name="allowScriptAccess" value="sameDomain" />
			<!--<![endif]-->
				<a href="http://www.adobe.com/go/getflash">
					<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Obtenir Adobe Flash Player" />
				</a>
			<!--[if !IE]>-->
			</object>
			<!--<![endif]-->
		</object>
	</div><?php

	//LISTE DES CHANSONS PRESENTES DANS LE XML
	$adminOK = false;
	if (isset($_SESSION['pseudo']) AND isset($_SESSION['pass']) AND verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
		$adminOK = true;
	}
	echo "<h1>".$recupPlayer[2]['valeurTrad']." : </h1>";
	if ($tab != "Aucune Chanson") {
		for ($i=0;$i<count($tab);$i+=3) {
			echo utf8_decode($tab[$i])." - ".utf8_decode($tab[$i+1]);
			if ($adminOK) { 
				echo "&nbsp&nbsp&nbsp<a class='btn btn-link' href='index.php?page=player&del=".$tab[$i+2]."'>Supprimer</a>"; 
			}
			echo "<br/>";
		}
	} else {
		echo $recupPlayer[3]['valeurTrad'];
	}
	
if (isset($_SESSION['pseudo']) AND isset($_SESSION['pass']) AND verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) { ?>
	<!--Formulaire d'ajout d'une musique-->
	<h1>Ajout d'une chanson : </h1></center>
	<form action="index.php?page=player" method="post" enctype="multipart/form-data" class="formS" style="margin-left: 200px;">    
          <label for="fichier">Musique à ajouter : </label><input type="file" name="fichier"><br />
		  <label for="nom">Titre : </label><input type="text" name="nom"><br />
		  <label for="band">Chanteur/Groupe : </label><input type="text" name="band"><br />
          <center><input type="submit" value="Ajouter">
	</form><?php
}
?>
