<?php
define ("SLIDER", "ressources/slider.xml");
define("BASE", 'diaporama/');
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accéder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	exit(0);
} else {
	//ExÃ©cution de la fonction de rÃ©cupÃ©ration de la playlist courante
	$tab = recup_image();
	//SI UN FICHIER DOIT ETRE AJOUTE
	if(isset($_FILES['fichier'])) {
		$extensions = array('.png', '.gif', '.jpg', '.jpeg');
		$extension = strrchr($_FILES['fichier']['name'], '.');
		if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
		{
			echo '<center>Ajout NON effectué car vous devez ajouter des fichiers de type png, gif, jpg ou jpeg uniquement</center>';
			echo "extension : ".$extension;
			echo "<center><a class='btn btn-link' href='index.php?page=slider'>Retour à la page d'accueil</a></center>";
			exit();
		} else {
			$dossier = BASE;
			$fichier = basename($_FILES['fichier']['name']);
			$fichier = str_replace(' ', '', $fichier);
			$name = str_replace(' ', '', $_FILES['fichier']['tmp_name']);
			
			if(move_uploaded_file($_FILES['fichier']['tmp_name'], $dossier . $fichier )){
				//REDIMENSION APRES AJOUT  PHP
					$image=$dossier . $fichier;
					$dimension=getimagesize($image);

					$coef_l=380;
					$coef_h=255;
					if ($extension == '.jpg' || $extension == '.jpeg')
						$chemin = imagecreatefromjpeg($image);
					if ($extension == '.png')
						$chemin = imagecreatefrompng($image);
					if ($extension == '.gif')
						$chemin = imagecreatefromgif($image);
					$nouvelle =imagecreatetruecolor ($coef_l, $coef_h);
					imagecopyresampled($nouvelle,$chemin,0,0,0,0,$coef_l,$coef_h,$dimension[0],$dimension[1]);
					imagejpeg($nouvelle,$image);
					imagedestroy ($chemin);
					
				//AJOUT DANS XML
				$songs = array();
				for($i=0; $i < count($tab) AND $tab != "Aucune image"; $i++) {
					$songs[] = array('name' => $tab[$i]);
				}
				$songs[] = array('name' => $fichier);
				$doc = new DOMDocument();
				$doc->formatOutput = true;

				$r = $doc->createElement( "diaporama" );
				$doc->appendChild( $r );
				
				foreach( $songs as $img ) {
					$name = $doc->createElement( "img" );
					$name->appendChild($doc->createTextNode( $img['name'] ));
					$r->appendChild( $name );
				}
				$doc->save(SLIDER);
				//AFFICHAGE
				echo '<center>Ajout effectué</center>';
				echo "<center><a class='btn btn-link' href='index.php?page=slider'>Retour à la page d'accueil</a></center>";
				exit();
			} else {
				echo '<center>Ajout non effectué</center>';
			}
		}
	}
	//SI UN FICHIER DOIT ETRE SUPPRIME
	if(isset($_GET['del'])) {
		//Suppression du fichier
		unlink(BASE."/".$_GET['del']);
		//Suppression XML
		$doc = new DOMDocument();
		$doc->load( SLIDER );
		$songs = $doc->getElementsByTagName( "img" );
		foreach( $songs as $img )
		{
			$name = $img->nodeValue;
			if ($name == $_GET['del']) {
				$songs = array();
				for($i=0; $i < count($tab); $i++) {
					if ($tab[$i] != $_GET['del']) {
						$songs [] = array('name' => $tab[$i]);
					}
				}
				$doc = new DOMDocument();
				$doc->formatOutput = true;
				$r = $doc->createElement( "diaporama" );
				$doc->appendChild( $r );
				  
				foreach( $songs as $img ) {
					$name = $doc->createElement( "img" );
					$name->appendChild($doc->createTextNode( $img['name'] ));
					$r->appendChild( $name );
				}
				$doc->save(SLIDER);
			}
		}
		echo '<center>Suppression effectuée</center>';
		echo "<center><a class='btn btn-link' href='index.php?page=slider'>Retour a la page d'accueil</a></center>";
		exit();
	}?>
	<center>
	<div class="slideshow">
	<ul>
	<?php for ($i=0;$i<count($tab);$i++)
		echo "<li><img src='/diaporama/".$tab[$i]."'  max-width='50%' height='auto' /></li>";
		?>
	</ul>
	</div>
	<?php
	echo "<h1>Liste des images : </h1>";
	if ($tab != "Aucune image") {
		echo "<div id='tableauImg'>
		<table class='table table-bordered'>";
		for ($i=0;$i<count($tab);$i++) {
			echo "<tr>";
			echo "<td>";
			echo $tab[$i]."</td><td><a class='btn btn-link' href='index.php?page=slider&del=".$tab[$i]."'>Supprimer</a><br/>"; 
			echo "</td>";
			echo "</tr>";
		}
		echo "</table></div>";
	} else {
		echo "Aucune image n'a été trouvée";
	}
	
	echo "<h1>Ajouter une nouvelle image : </h1>";?>
	<form action="index.php?page=slider" method="post" enctype="multipart/form-data">    
			  <label for="fichier">Photo : 
			  <input type="file" name="fichier"></label>
			  <label>
			  <input class="btn btn-info" type="submit" value="Ajouter"></label>
			  <?php
			  echo "La photo doit être en .jpg et ne doit pas dépasser la taille de 250ko.<br/>
			  Si votre image est dans un autre format ou dépasse cette taille, veuiller utiliser un outil de retouche d'image comme Paint.</b><br><br>";?>
	</form></center>
	
	<script type="text/javascript">
   $(function(){
      setInterval(function(){
         $(".slideshow ul").animate({marginLeft:-350},500,function(){
            $(this).css({marginLeft:0}).find("li:last").after($(this).find("li:first"));
         })
      }, 3500);
   });
</script>
	<?php
}?>