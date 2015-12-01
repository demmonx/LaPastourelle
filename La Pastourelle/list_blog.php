<?php
@session_start ();
require_once 'traitement.inc.php';
verifLoginWithArray ( $_SESSION, 0 );
try {
	$adminOk = checkLoginWithArray ( $_SESSION, 1 );
} catch ( Exception $e ) {
	$adminOk = false;
}
// Nombre de photos par page
DEFINE ( "PHOTO_PER_PAGE", 4 );
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

$premiereEntree = ($pageActuelle - 1) * PHOTO_PER_PAGE; // On calcule la
                                                        // première entrée à
                                                        // lire
                                                        
// selectionne les photos
$les_photos = getPicByRange ( $premiereEntree, PHOTO_PER_PAGE );
// ouverture tableau
foreach ( $les_photos as $row ) {
	echo "<div>";
	// si administrateur -> pour supprimer la photo
	if ($adminOk) {
		echo "<div><a class='action' href='blog_traitement.php?ac=2&id=" . $row ['id'] . "'><i class='fa fa-close fa-lg'></i></a> ";
	}
	// la date de la photo
	echo "<I>Le " . date ( 'd/m/Y - H\hi', strtotime ( $row ['date'] ) ) . "</I> ";
	
	// la photo
	echo "<br><IMG class='ssBordure'  ALT=" . $row ['adr'] . " src='" . $row ['adr'] . "'><br>";
	// description de la photo s'il en existe une
	if ($row ['txt'] != null) {
		echo "<b>Description de l'image :</b>" . $row ['txt'] . "<br><br/>";
	}
	
	// affichage des commentaires pour chaque photo s'ils existent
	$les_commentaires = getBlogComment ( $row ['id'] );
	echo "<b><i class='fa fa-commenting-o fa-lg'></i> Commentaires (" . count ( $les_commentaires ) . ")</b>";
	echo "  <span class='spoiler'><i class='fa fa-plus-square-o'></i></span>";
	echo "<div class='spoiler-hidden'>";
	if (count ( $les_commentaires ) <= 0) {
		echo "Aucun commentaire pour ce billet";
	}
	foreach ( $les_commentaires as $resultat ) {
		echo "<div>";
		// si administrateur -> pour supprimer un commentaire
		if ($adminOk) {
			echo "<a class='action' href='blog_traitement.php?ac=1&id=" . $resultat ['id'] . "'><i class='fa fa-close fa-lg'></i></a> ";
		}
		// auteur du commentaire
		echo "<B>" . $resultat ['pseudo'] . " : </B>";
		
		// le commentaire
		echo nl2br ( html_entity_decode ( $resultat ['txt'] ) );
		
		echo "</div>";
		echo "<hr>";
	}
	// formulaire de commentaire
	echo '
			<h3>Commenter</h3>
				<form method="post" class="post-comment" action="blog_traitement.php">
					<textarea name="content"></textarea><br>
					<input type="hidden" name="photo" value="' . $row ['id'] . '" />
							<input type="hidden" name="ac" value="2" />
			
					<input class="btn btn-default" type="submit" value="Poster">
				</form>
		';
	echo "</div>";
	echo '<hr></div>';
}
// GESTION DES BOUTONS DE LA PAGINATION
echo '<ul class="pagination">';

// Désactive si on est sur la première page
if ($pageActuelle == 1) {
	echo '<li class="disabled"><span aria-hidden="true">&laquo;</span></li>';
} else {
	echo '<li><a href="index.php?page=blog&lapage=' . ($pageActuelle - 1) . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
}

// Affiche les pages
for($i = 1; $i <= $nombreDePages; $i ++) {
	if ($i == $pageActuelle) {
		echo "<li class='active'><a href='index.php?page=blog&lapage=" . $i . "'>" . $i . "</a></li>";
	} else {
		echo "<li><a href='index.php?page=blog&lapage=" . $i . "'>" . $i . "</a></li>";
	}
}

// Désactive si on est sur la dernière page
if ($pageActuelle == $nombreDePages) {
	echo '<li class="disabled"><span aria-hidden="true">&raquo;</span></li>';
} else {
	echo '<li><a href="index.php?page=blog&lapage=' . ($pageActuelle + 1) . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
}
echo '</ul>';
?>

<script type="text/javascript" src="ressources/js/blog.js"></script>
<script type="text/javascript" src="ressources/js/spoiler.js"></script>