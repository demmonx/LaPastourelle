<?php
	$continents_valides = array("NA", "SA", "EU", "AS", "OC", "AF");
	//Récupération des textes annexes de traduction pour cette zone
		$req_recupMonde = $bdd->select("SELECT valeurTrad FROM tradannexe WHERE lang ='".$_SESSION['lang']."' AND nomTrad LIKE 'monde%' ");
		//$req_recupMonde->execute(array($_SESSION['lang']));
		$recupMonde = $req_recupMonde->fetchAll();
		
	//AUCUN CONTINENT N'A ETE CHOISI OU UN CONTINENT INVALIDE A ETE CHOISI
	if ( 	(!isset($_GET['continent'])) 
		 OR (isset($_GET['continent']) AND !in_array($_GET['continent'],$continents_valides) )){?>

		<!--AFFICHAGE DU MONDE AVEC LES CONTINENTS CLIQUABLES-->
		<h1 style="text-align:center">
			<?php echo $recupMonde[0]['valeurTrad']; ?></h1>
			<div style="text-align:center">
				<a href="index.php?page=mondeLogo&continent=EU">
					<span id="europe"></span>
				</a>
				<a href="index.php?page=mondeLogo&continent=AS">
					<span id="asie"></span>
				</a>
				<a href="index.php?page=mondeLogo&continent=AN">
					<span id="antartique"></span>
				</a>
				<a href="index.php?page=mondeLogo&continent=AF">
					<span id="afrique"></span>
				</a>
				<a href="index.php?page=mondeLogo&continent=NA">
					<span id="amerNord"></span>
				</a>
				<a href="index.php?page=mondeLogo&continent=SA">
					<span id="amerSud"></span>
				</a>
				<a href="index.php?page=mondeLogo&continent=OC">
					<span id="oceanie"></span>
				</a>
				<img class='ssBordure' src='image/mondeLogo/monde.png' alt="monde"/>
			</div><?php
	//UN CONTINENT A ETE SELECTIONNE
	} else {

		//Partie Administration (gestion de l'emplacement des drapeaux
		if (   isset($_SESSION['pseudo']) AND isset($_SESSION['pass']) AND verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass']) 
			AND ( 
					(isset($_GET['visux']) AND $_GET['visux'] == "a") 
				 OR (isset($_GET['x']) AND isset($_GET['y']))
				 OR (isset($_POST['monde_x']) AND isset($_POST['monde_y']))  
				) ) { 
			//On veut supprimer une entreée
			if (isset($_GET['x']) AND isset($_GET['y'])) {
				$delete_coord = $bdd->select("DELETE FROM logocarte WHERE continent ='".$_GET['continent']."' AND x =".$_GET['x']." AND y =".$_GET['y']);
				//$delete_coord->execute(array($_GET['continent'], $_GET['x'], $_GET['y']));
				$delete_coord->closeCursor();
				if (file_exists('/image/mondeLogo/desc/'.$_GET['x'].'-'.$_GET['y'].'-'.$_GET['continent'].'.jpg')){
					unlink('/image/mondeLogo/desc/'.$_GET['x'].'-'.$_GET['y'].'-'.$_GET['continent'].'.jpg');
				}
			}
			//On veut ajouter une entrée
			if (isset($_POST['monde_x']) AND isset($_POST['monde_y'])) {
				$insert_coord = $bdd->select("INSERT INTO logocarte VALUES ('".$_GET['continent']."','".$_POST['monde_x']."','".$_POST['monde_y']."', 'Titre non défini', 'Texte non défini')");
				//$insert_coord->execute(array($_GET['continent'], $_POST['monde_x'], $_POST['monde_y']));
				//$insert_coord->closeCursor();
			}
			//Récupération des différentes coordonnées
			$req_coord = $bdd->select("SELECT *
									  FROM logocarte
									  WHERE continent ='".$_GET['continent']."'");
			//$req_coord->execute(array($_GET['continent']));
			$coords = $req_coord->fetchAll();
			$req_coord->closeCursor();
			//Affichage de l'image?>
			<h1 style="text-align:center">Cliquez sur la carte pour ajouter un drapeau</h1><?php
			// Affichage du continent?>
			<center>
				<!--Utilisation de la librairie GD pour pouvoir avoir la carte cliquable mais aussi voir les drapeaux cliquables-->
				<form action="index.php?page=mondeLogo&continent=<?php echo $_GET['continent'];?>" method="POST" style="text-align: center">
					<input type="image" class='ssBordure' src="image/mondeLogoImg.php?continent=<?php echo $_GET['continent'];?>" name="monde" alt="carte du monde"/>
				</form>
			
				<br />
			<?php
			echo "<hr /><br /><br /><h1>Liste des différents emplacements : </h1>";
			echo "
			<table>
				<tr>
					<th>X</th>
					<th>Y</th>
					<th>Titre</th>
					<th>Description</th>
					<th>Action</th>
				</tr>";
			for ($i = 0; $i < count($coords); $i++) {
				echo "<tr>";
					echo "<td>".$coords[$i]['x']."</td>";
					echo "<td>".$coords[$i]['y']."</td>";
					echo "<td>".$coords[$i]['titre']."</td>";
					echo "<td>".$coords[$i]['texte']."</td>";
					echo "<td><a class='btn btn-link' href='index.php?page=mondeLogo&continent=".$_GET['continent']."&x=".$coords[$i]['x']."&y=".$coords[$i]['y']."'>Supprimer</a></td>";
				echo "</tr>";
			}
			echo"</table>";
			echo "<br /><br /><center><a class='btn btn-link' href='index.php?page=mondeLogo&continent=".$_GET['continent']."'>Revenir à la page précédente</a></center>";
			
		//Affichage de la description d'un pays (avec l'administration si admin
		} else if (isset($_GET['visux']) AND isset($_GET['visuy'])) {
		
			//Si modification des informations
			if ( isset($_POST['titre']) AND isset($_POST['desc'])){
				$modif_pays= $bdd->select("UPDATE logocarte
										   SET titre='".$_POST['titre']."', texte ='".$_POST['desc']."'
										   WHERE x =".$_GET['visux']."
											 AND y =".$_GET['visuy']."
											 AND continent ='".$_GET['continent']."'");
				//$modif_pays->execute(array($_POST['titre'], $_POST['desc'], $_GET['visux'], $_GET['visuy'], $_GET['continent']));
				//Ajout du fichier s'il y en a un
				if(isset($_FILES['fichier'])) {
					$extensions = array('.jpg');
					$extension = strrchr($_FILES['fichier']['name'], '.');
					if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
					{
						echo '<center>Ajout NON effectué car vous devez ajouter des fichiers de type .jpg uniquement</center>';
					} else {
						$dossier = 'image/mondeLogo/desc/';
						$fichier = $_GET['visux'].'-'.$_GET['visuy'].'-'.$_GET['continent'].'.jpg';
						
						if(move_uploaded_file($_FILES['fichier']['tmp_name'], $dossier . $fichier )){
							//REDIMENSION APRES AJOUT  PHP
								$image=$dossier . $fichier;
								$dimension=getimagesize($image);
								$coef_l=500;
								$coef_h=400;
								$chemin = imagecreatefromjpeg($image);
								$nouvelle =imagecreatetruecolor ($coef_l, $coef_h);
								imagecopyresampled($nouvelle,$chemin,0,0,0,0,$coef_l,$coef_h,$dimension[0],$dimension[1]);
								imagejpeg($nouvelle,$image);
								imagedestroy ($chemin);
						} else {
							echo '<center>Ajout non effectué</center>';
						}
					}
				}
			}
			
			//Récupération des différentes coordonnées
			$req_coord = $bdd->select("SELECT *
									   FROM logocarte
									   WHERE continent ='".$_GET['continent']."'
										 AND x ='".$_GET['visux']."'
										 AND y ='".$_GET['visuy']."'");
			///$req_coord->execute(array($_GET['continent'], $_GET['visux'], $_GET['visuy']));
			$coords = $req_coord->fetchAll();
			$req_coord->closeCursor();?>
			<center>
				<h1><?php echo $coords[0]['titre']; ?> </h1><br />

				
					<img class='ssBordure' src="image/mondeLogo/desc/<?php echo $_GET['visux']."-".$_GET['visuy'].'-'.$_GET['continent'].".jpg";?>" width="500" height="400" />
				
				<p><?php echo $coords[0]['texte']; ?></p>
			</center><?php
			
			if (isset($_SESSION['pseudo']) AND isset($_SESSION['pass']) AND verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])){?>
				<hr /><br />
				<form class="form-horizontal" action="index.php?page=mondeLogo&continent=<?php echo $_GET['continent'];?>&visux=<?php echo $_GET['visux'];?>&visuy=<?php echo $_GET['visuy'];?>" enctype="multipart/form-data" method="POST" class="formS" style="margin-left : 20px;">
					<div class="control-group">
						<label class="control-label" for="titre">Titre :</label>
						<div class="controls">
							<input type="text" name="titre" value ="<?php echo $coords[0]['titre']; ?>"/>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="fichier">Photo :</label>
						<div class="controls">
							<input type="file" name="fichier" ><br/>(Modifer l'image, supprimera l'ancienne)
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="desc">Description du voyage :</label>
						<div class="controls">
							<textarea name="desc" cols="60" rows="10"><?php echo $coords[0]['texte']; ?></textarea>
						</div>
					</div>
					<center><input class="btn btn-info" type="submit" value="Modifier" />
				</form><?php
			}
			echo "<br /><center><a class='btn btn-link' href='index.php?page=mondeLogo&continent=".$_GET['continent']."'>".$recupMonde[1]['valeurTrad']."</a></center>";
		//Affichage par défaut quand on clique sur on continent => drapeaux cliquables sur le continent
		} else {
			//Récupération des différentes coordonnées
			$req_coord = $bdd->select("SELECT x, y
									   FROM logocarte
									   WHERE continent ='".$_GET['continent']."'");
			//$req_coord->execute(array($_GET['continent']));
			$coords = $req_coord->fetchAll();
			$req_coord->closeCursor();
			//Affichage de l'image?>
			<h1 style="text-align:center"><?php echo $recupMonde[2]['valeurTrad']; ?></h1><?php
			// Affichage du continent?>
			<center>
				<?php
				/* // info sur la dimension de l'image
				$hauteur = abs(900 - $infos_image[1]) - 13; // hauteur de l'image
				echo $hauteur." et ".$infos_image[1];*/
				//Pas le temps de faire mieux :S
				$infos_image = @getImageSize("image/mondeLogo/".$_GET['continent'].".jpg");
				if ($_GET['continent'] == "EU") { $hauteur = 900 - $infos_image[1] -30;
				} else if ($_GET['continent'] == "AS") { $hauteur = abs(900 - $infos_image[1]) - 95;
				} else if ($_GET['continent'] == "NA") { $hauteur = abs(900 - $infos_image[1]) - 50;
				} else if ($_GET['continent'] == "SA") { $hauteur = abs(900 - $infos_image[1]) - 272;
				} else if ($_GET['continent'] == "AF") { $hauteur = abs(900 - $infos_image[1]) - 62;
				} else if ($_GET['continent'] == "OC") { $hauteur = $infos_image[1] - 700 ; }
								?>
				
				<!--Cadre transparent contenant les drapeaux-->
				<div class='ssBordure' id="img_cont_logo">
					<?php
					//Affichage des drapeaux aux bonnes coordonnées
					for ($i=0;$i<count($coords);$i++) {
						echo '<a href="index.php?page=mondeLogo&continent='.$_GET['continent'].'&visux='.$coords[$i]['x'].'&visuy='.$coords[$i]['y'].'">
						<span class="img_logo ssBordure" style="margin-left:'.$coords[$i]['x'].'px;margin-top:'.($coords[$i]['y']-$hauteur).'px;"></span></a>';
					}?>
					
				</div><br /><br /><br />
				<img class="ssBordure" src="image/mondeLogo/<?php echo $_GET['continent'];?>.jpg" width="900px" height="900px" alt="Continent" />
		
				
				
				
				<?php if (isset($_SESSION['pseudo']) AND isset($_SESSION['pass']) AND verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])){?>
					<a class="btn btn-link" href="index.php?page=mondeLogo&continent=<?php echo $_GET['continent']; ?>&visux=a">Administration des pays visités pour ce continent</a><br /><br /><?php
				}?>
				<a class="btn btn-link" href='index.php?page=mondeLogo'><?php echo $recupMonde[3]['valeurTrad']; ?></a>
			</center><?php
		}
	}
?>