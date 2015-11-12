<?php
if (! isset ( $_SESSION ['pseudo'] ) or ! isset ( $_SESSION ['pass'] ) or ! verifLo ( $_SESSION ['pseudo'], $_SESSION ['pass'] )) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect ( "index.php?page=accueil", 3 );
	exit ( 0 );
} // else
  
// Nombre de photos par page
DEFINE ( "PHOTO_PER_PAGE", 10 );
$total = getNbPic (); // Nombre de photos dispo
                      
// compte le nombre de pages.
$nombreDePages = floor ( $total / PHOTO_PER_PAGE );

if (isset ( $_GET ['lapage'] ) && is_numeric ( $_GET ['lapage'] )) {
	$pageActuelle = intval ( $_GET ['lapage'] );
	
	if ($pageActuelle > $nombreDePages) {
		$pageActuelle = $nombreDePages;
	}
} else {
	$pageActuelle = 1; // La page actuelle est la n°1
}

$premiereEntree = ($pageActuelle - 1) * PHOTO_PER_PAGE; // On calcule la première entrée à lire
                                                        
// selectionne les photos
$les_photos = getPicByRange ( $premiereEntree, PHOTO_PER_PAGE );

// administration intégrée dans la page des blogs
// S'affiche uniquement si l'utilisateur est un administrateur
// pour ajouter de nouvelles photos
if (verifLoAdmin ( $_SESSION ['pseudo'], $_SESSION ['pass'] )) {
	echo "<DIV><CENTER><B>Pour ajouter une nouvelle photo</B></CENTER></DIV>";
	
	echo '
		<center>
		<form method="POST" id="post-pic" action="blog_traitement.php" enctype="multipart/form-data">
		<br>Description de la photo :<br><TEXTAREA name="description"   id="desc" rows=2 cols=40 wrap=hard></TEXTAREA><br><br>
		Fichier : <input type="file" id="uploadFile" name="fichier" size="50">
		<input type="hidden" name="ac" value="1" />
		<input class="btn btn-info" type="submit" name="envoyer" value="Enregistrer cette photo">
		</form>
		</center>';
}

// ouverture tableau
foreach ( $les_photos as $row ) {
	echo "<div>";
	// la date de la photo
	echo "<br><I>Publié le " . $row ['date'] . "</I><a class='btn btn-link' href='#header' style='font-size:10px;'>&nbsp&nbspHaut de page</a> | <a class='btn btn-link' href='#basDePage' style='font-size:10px;'>Bas de page</a>";
	
	// si administrateur -> pour supprimer la photo
	if (verifLoAdmin ( $_SESSION ['pseudo'], $_SESSION ['pass'] )) {
		echo "<div><a class='action' href='blog_traitement.php?ac=2&id=" . $row ['id'] . "'><button class='btn btn-info'>Supprimer la photo</button></a></div>";
	}
	
	// la photo
	echo "<br><center><IMG class='ssBordure' style='margin-top:-10px' ALT=" . $row ['adr'] . " HEIGHT=\"500\" WIDTH=\"400\" src='" . $row ['adr'] . "'></center><br>";
	// description de la photo s'il en existe une
	if ($row ['txt'] != null) {
		echo "<b>Description de l'image :</b>" . $row ['txt'] . "<br><br/>";
	}
	
	echo "<center><b><i class='icon-comment'></i> Commentaires</b></center></br>";
	// affichage des commentaires pour chaque photo s'ils existent
	$les_commentaires = getBlogComment ( $row ['id'] );
	foreach ( $les_commentaires as $resultat ) {
		echo "<div>";
		// auteur du commentaire
		echo "<B>" . $resultat ['pseudo'] . " : </B>&nbsp&nbsp";
		
		// le commentaire
		echo $resultat ['txt'];
		
		// si administrateur -> pour supprimer un commentaire
		if (verifLoAdmin ( $_SESSION ['pseudo'], $_SESSION ['pass'] )) {
			echo "<br /><a class='action' href='blog_traitement.php?ac=1&id=" . $resultat ['id'] . "'><button class='btn btn-info'>Supprimer ce commentaire</button></a>";
		}
		echo "</div>";
		echo "<hr>";
	}
	// formulaire de commentaire
	echo '<center>
				<form method="post" class="post-comment" action="blog_traitement.php">
					<textarea name="content" rows="3" cols="60"></textarea><br>
					<input type="hidden" name="photo" value="' . $row ['id'] . '" />
							<input type="hidden" name="ac" value="2" />
					
					<input class="btn btn-info" type="submit" value="Poster un commentaire">
				</form>
			</center>
			<hr></div>';
}
// GESTION DES BOUTONS DE LA PAGINATION
for($i = 1; $i <= $nombreDePages; $i ++) {
	if ($i == $pageActuelle) {
		echo 'Page ' . $i;
	} else {
		echo "<a href='index.php?page=blog&lapage=" . $i . "'><button class='btn btn-small btn-primary' >Page " . $i . "</button>";
	}
}
// fermeture du tableau
echo "</table>";
?>

<script type="text/javascript" src="js/blog.js"></script>