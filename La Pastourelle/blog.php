<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass'])OR !verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect("index.php?page=accueil", 3);
	exit(0);
} else {
	//Ajout d'un commentaire
	if (isset($_POST['commentaire']) AND isset($_POST['add']) AND $_POST['add'] == 1 AND isset($_SESSION['pseudo']) AND verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {
		$numero = $_POST['numero_photo'];
		$insertion_commentaire ="INSERT INTO commentaire (texte, num_photo, auteur)VALUES ('".$_POST['commentaire']."',".$numero.",'".$_SESSION['pseudo']."')";
		$insert_com = $bdd->select($insertion_commentaire);
		//mysql_query($insertion_commentaire);
	}
	//Suppression d'un commentaire
	else if (isset($_POST['id_commentaire']) AND verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
		$lecommentaire = $_POST['id_commentaire'];
		$suppression_commentaire ="DELETE FROM commentaire WHERE id_commentaire = $lecommentaire";
		$suppr_commentaire = $bdd->select($suppression_commentaire);
	//	mysql_query($suppression_commentaire);
	}
	//Suppression d'une photo
	else if (isset($_POST['numero_photo']) AND verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
		$numero = $_POST['numero_photo'];
		//Recuperation du nom de la photo et suppression du fichier
		//$bdd = connect_BD_PDO();
		$req_recupNom = $bdd->prepare("SELECT adr_photo FROM photo WHERE id_photo = '".array($numero)."'");
		//$req_recupNom->execute(array($numero));
		//$recupNom = $req_recupNom->fetchAll();
		unlink($recupNom[0]["adr_photo"]);
		
		// suppression de  la photo dans la bases de données
		$suppression_photo ="DELETE FROM photo where id_photo = $numero";
		$suppr_photo = $bdd->select($suppression_photo);
		//mysql_query($suppression_photo);
		// suppresion des commentaires de la photo
		$suppression_commentaire ="DELETE FROM commentaire where num_photo = $numero";
		$suppr_com = $bdd->select($suppression_commentaire);
		//mysql_query($suppression_commentaire);
		echo "<center><h2>Photo supprimée</h2></center>";
		echo "<center><br /><a class='btn btn-link' href='index.php?page=blog'>Revenir à la page précédente</a></center>";
	}
	// GESTION DE LA PAGINATION
	// nombre de photos par page
	$photosParPage=12; 
	
	// compte le nombre de photos
	$retour_total=$bdd->select("SELECT COUNT(*) AS total FROM photo");

	foreach ($retour_total as $row) {
		$total=$row['total']; //On récupère le total pour le placer dans la variable $total.
	}
	//$donnees_total=mysql_fetch_assoc($retour_total); //On range retour sous la forme d'un tableau.
	//$total=$donnees_total['total']; //On récupère le total pour le placer dans la variable $total.

	//compte le nombre de pages.
	$nombreDePages=ceil($total/$photosParPage);

	if(isset($_POST['lapage'])){
		$pageActuelle=intval($_POST['lapage']);
		
		if($pageActuelle>$nombreDePages) 
		
		{
			$pageActuelle=$nombreDePages;
		}
	}else{
		$pageActuelle=1; // La page actuelle est la n°1    
	}
	
	$premiereEntree=($pageActuelle-1)*$photosParPage; // On calcule la première entrée à lire
	// FIN DE LA GESTION DE LA PAGINATION
	
	// selectionne les photos
	$rqt_blog_photo = "SELECT id_photo, adr_photo, date_photo, description FROM photo ORDER BY date_photo DESC LIMIT $premiereEntree, $photosParPage ";
	$les_photos = $bdd->select($rqt_blog_photo);
	//$les_photos = mysql_query($rqt_blog_photo);
	
	// administration intégrée dans la page des blogs
	// S'affiche uniquement si l'utilisateur est un administrateur
	// pour ajouter de nouvelles photos
	if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
		echo "<br><DIV id=\"menu\" style='margin-left:auto;margin-right:auto'><CENTER><B>Pour ajouter une nouvelle photo</B></CENTER></DIV><br>"; 
		
		if ( isset($_FILES['fichier_choisi'])){
		include("blog_upload.php");
		$chemin = new_lien();

		$insertion_photo ="INSERT INTO photo VALUES ('','".$chemin."',NOW(),'".$_POST['description']."')";
		$insert = $bdd->select($insertion_photo);
	//	mysql_query($insertion_photo);
		}

		echo'
		<center>
		<form method="POST" action="#" enctype="multipart/form-data">
		<br>Description de la photo :<br><TEXTAREA name="description"   rows=2 cols=40 wrap=hard></TEXTAREA><br><br>
		Fichier : <input type="file" name="fichier_choisi" size="50"><br><b> La photo doit être en .jpg et ne doit pas dépasser la taille de 250ko.<br/>
		Si votre image est dans un autre format ou dépasse cette taille, veuiller utiliser un outil de retouche d\'image comme Paint.<br/><br/>
		Votre photo sera visible après avoir actualisé la page.<br/><br/></b>
		
		<input class="btn btn-info" type="submit" name="envoyer" value="Enregistrer cette photo">
		</form>
		</center>';
	}
	
	//ouverture tableau
	foreach ($les_photos as $row) {
		echo "<div id='".$row['id_photo']."'>";
		// la date de la photo
		echo "<br><p style='float:left;'><I>Publié le ".$row['date_photo']."</I><a class='btn btn-link' href='#header' style='font-size:10px;'>&nbsp&nbspHaut de page</a>&nbsp&nbsp<a class='btn btn-link' href='#basDePage' style='font-size:10px;'>Bas de page</a>&nbsp&nbsp</p>";
		
		// si administrateur -> pour supprimer la photo
		if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
			echo '<div style="margin-top:10px;"><FORM  METHOD="POST" ACTION="index.php?page=blog">
			<input type="hidden" name="numero_photo" value="'.$row['id_photo'].'" />
			<input class="btn btn-info" type="submit"  value="Supprimer cette photo">
			</FORM></div>';
		}
		
		// la photo
		echo "<br><center><IMG class='ssBordure' style='margin-top:-10px' ALT=".$row['adr_photo']." HEIGHT=\"500\" WIDTH=\"400\" SRC='".$row['adr_photo']."'></center><br>"; 
		// description de la photo s'il en existe une
		if ( $row['description'] != null ){
			echo "<b>Description de l'image :</b>".$row['description']."<br><br/>";
		}
		
		echo "<div style='width:700px;margin-left:auto;margin-right:auto;margin-top:-10px;
						  border-left: 1px solid black;border-right:1px solid black;padding-left: 10px;padding-right:10px;'>";
		echo "<center><b><i class='icon-comment'></i> Commentaires</b></center></br>";
		// affichage des commentaires pour chaque photo s'ils existent
		$rqt_blog_commentaire ="SELECT texte, num_photo, auteur,id_commentaire FROM commentaire WHERE num_photo=".$row['id_photo']."";
		$les_commentaires = $bdd->select($rqt_blog_commentaire);
		foreach($les_commentaires as $resultat ){
			
			// auteur du commentaire 
			echo "<B>".$resultat['auteur']." : </B>&nbsp&nbsp";
			
			// le commentaire 
			echo $resultat['texte'];
			echo"<hr>";
			
			// si administrateur -> pour supprimer un commentaire
			if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
				echo '<div style="margin-top:-5px;">
				<FORM METHOD="POST" ACTION="index.php?page=blog#'.$row['id_photo'].'">
					<input type="hidden" name="id_commentaire" value="'.$resultat['id_commentaire'].'" />
					<input class="btn btn-info" type="submit" value="Supprimer ce commentaire">
				</FORM>
				</div>';
			}
			
		}
		echo "</div>";
		// formulaire de commentaire
		echo'<center>
				<form method="post" action="index.php?page=blog#'.$row['id_photo'].'">
					<textarea name="commentaire" rows="3" cols="60"></textarea><br>
					<input type="hidden" name="numero_photo" value="'.$row['id_photo'].'" />
					<input type="hidden" name="add" value="1" />
					
					<input class="btn btn-info" type="submit" value="Poster un commentaire">
				</form>
			</center>
			<hr></div>';
	}
	//while( $une_photo = mysql_fetch_object($les_photos)){
	//	echo "<div id='".$une_photo->id_photo."'>";
		// la date de la photo
	//	echo "<br><p style='float:left;'><I>Publié le ".$une_photo->date_photo."</I><a href='#header' style='font-size:10px;'>&nbsp&nbspHaut de page</a>&nbsp&nbsp<a href='#footer' style='font-size:10px;'>Bas de page</a>&nbsp&nbsp</p>";
		
		// si administrateur -> pour supprimer la photo
	//	if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	//		echo '<div style="margin-top:10px;"><FORM  METHOD="POST" ACTION="index.php?page=blog">
	//		<input type="hidden" name="numero_photo" value="'.$une_photo->id_photo.'" />
	//		<input type="submit"  value="Supprimer cette photo">
	//		</FORM></div>';
	//	}
		
		// la photo
	//	echo "<br><center><IMG style='margin-top:-10px' ALT=\"$row['adr_photo']\" HEIGHT=\"500\" WIDTH=\"400\" SRC=\"$row['adr_photo']\"></center><br>"; 
		// description de la photo s'il en existe une
	//	if ( $row['description'] != null ){
	//		echo "<b>Description de l'image :</b>".$row['description']."<br>";
	//	}
		
	//	echo "<div style='width:700px;margin-left:auto;margin-right:auto;margin-top:-10px;
	//					  border-left: 1px solid black;border-right:1px solid black;padding-left: 10px;padding-right:10px;'>";
	//	echo "<center><b>Commentaires</b></center>";
		// affichage des commentaires pour chaque photo s'ils existent
	//	$rqt_blog_commentaire ="SELECT texte, num_photo, auteur,id_commentaire FROM commentaire WHERE num_photo=".$une_photo->id_photo."";
	//	$les_commentaires = mysql_query($rqt_blog_commentaire);
	//	while($un_commentaire = mysql_fetch_object($les_commentaires) ){
			// auteur du commentaire 
	//		echo "<p style='float:left;'><B>".$un_commentaire->auteur." : </B>&nbsp&nbsp</p>";
	//		echo"<br>";
			// si administrateur -> pour supprimer un commentaire
	//		if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	//			echo '<div style="margin-top:-5px;"><FORM METHOD="POST" ACTION="index.php?page=blog#'.$une_photo->id_photo.'">
	//			<input type="hidden" name="id_commentaire" value="'.$un_commentaire->id_commentaire.'" />
	//			<input style="margin-top:-20px;" type="submit" value="Supprimer ce commentaire">
	//			</FORM></div>';
	//		}
			
			// le commentaire 
	//		echo "<p>".$un_commentaire->texte."</p>";
	//		echo"<hr>";
	//	}
	//	echo "</div>";
		// formulaire de commentaire
	//	echo'<center><form method="post" action="index.php?page=blog#'.$une_photo->id_photo.'">
	//	<textarea name="commentaire" rows="3" cols="60"></textarea><br>
	//	<input type="hidden" name="numero_photo" value="'.$une_photo->id_photo.'" />
	//	<input type="hidden" name="add" value="1" />
	//	<input type="submit" value="Poster un commentaire">
	//	</form></center><hr></div>';
	//}
	
	// GESTION DES  BOUTONS DE LA PAGINATION 
	for($i=1; $i<=$nombreDePages; $i++){
		if($i==$pageActuelle){
			echo 'Page '.$i; 
		} else {
			echo '
				  <FORM METHOD="POST" ACTION="index.php?page=blog">
					<input type="hidden" name="lapage" value="'.$i.'" />
					<input class="btn btn-small btn-primary" type="submit" value="Page '.$i.'">
				  </FORM>';
		}
	}
	// fermeture du tableau
	echo "</table>";
}
?>