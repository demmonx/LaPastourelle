<?php $cryptinstall="./cryptographp.fct.php";include $cryptinstall; ?><?php 
	//$bdd = connect_BD_PDO();
	//Récupération des textes annexes de traduction pour cette zone
	$req_recupLivre = $bdd->select("SELECT valeurTrad FROM tradannexe WHERE lang ='" . $_SESSION['lang'] . "' AND nomTrad LIKE 'livre%' ");
	//$req_recupLivre->execute(array($_SESSION['lang']));
	$recupLivre = $req_recupLivre->fetchAll();
	//Si on veut supprimer un texte
	if (isset($_GET['id']) AND verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
		$delMess = $bdd->select('DELETE FROM livreor WHERE id ="' . $_GET['id'] .'"');
		//$delMess->execute(array($_GET['id']));
	}
	//Affichage du texte
		//Requete
	$message = $bdd->select('SELECT * FROM livreor WHERE confirm = 1 ORDER BY date');
		//Boucle d'affichage au cas où il aurait plusieurs textes (on ne sait jamais :p)
	foreach ($message as $donneesMess) {
		echo "<p>";
			echo "<span style='font-weight:bold'>";
				//Traduit le format de date anglais en format français
				$dateAN = htmlspecialchars($donneesMess['date']);
				list($annee, $mois, $jour) = explode('-', $dateAN);
				$dateFr = $jour."/".$mois."/".$annee;
				echo $recupLivre[0]['valeurTrad'].$dateFr." :<br />";
			echo "</span>";
			echo	nl2br(htmlspecialchars($donneesMess['message']));
			if (isset($_SESSION['pseudo']) AND isset($_SESSION['pass']) AND verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
				echo "&nbsp&nbsp&nbsp&nbsp&nbsp<a href='index.php?page=livreOR&id=".$donneesMess['id']."'>Supprimer</a>";
			}
		echo "</p>";
		echo "<hr/>";
	}
	//On peut ajouter un message qui sera ensuite soumis à une confirmation d'un administrateur?>	<div class="identification">		<form action="verifierLivreOR.php?<?PHP echo SID; ?>" method="post">			<div class="control-group">
				<label class="control-label" for="nom"><?php echo $recupLivre[1]['valeurTrad']; ?> : </label>					<div class="controls">						<input type="text" name="nom" /><!--style="background-color:#dddbd9"/>--><br />					</div>			</div>						<div class="control-group">				
				<label for="message" class="control-label"><?php echo $recupLivre[2]['valeurTrad']; ?> : </label>					<div class="controls">						<textarea name="message"></textarea><br/><!--cols="50" style="background-color:#dddbd9"-->					</div>			</div>						<div class="control-group">					<div class="controls">					<table>						<tr>							<td colspan="2" align="center"><?php dsp_crypt(0,1); ?></td>						</tr>						<tr>							<td colspan="2" align="center">Recopier le code:<br><input type="text" name="code"></td>										</tr>					</table>						</div>			</div>						<input type="submit" class="btn" value="<?php echo $recupLivre[3]['valeurTrad']; ?>" />
		</form>	</div><?php
	//deconnection
	//$message->closeCursor();
?>