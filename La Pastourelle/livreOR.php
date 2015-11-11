<?php $cryptinstall="./cryptographp.fct.php";require_once $cryptinstall; ?><?php 
	//Récupération des textes annexes de traduction pour cette zone
	$trad = getTrad ($_SESSION['lang'], 'livre');
	//Si on veut supprimer un texte
	if (isset($_GET['id']) AND verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
		deleteMessageLivre($_GET['id']);
	}
	//Affichage du texte
	$message = getMessageActifLivre();
	foreach ($message as $row) {
		echo "<p>";
			echo "<span style='font-weight:bold'>";
				//Traduit le format de date anglais en format français
				$dateAN = htmlspecialchars($row['date']);
				list($annee, $mois, $jour) = explode('-', $dateAN);
				$dateFr = $jour."/".$mois."/".$annee;
				echo (isset($trad[0]) ? $trad[0] : "Non traduit") . " " .$dateFr." :<br />";
			echo "</span>";
			echo	nl2br(htmlspecialchars($row['message']));
			if (isset($_SESSION['pseudo']) AND isset($_SESSION['pass']) AND verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
				echo "&nbsp&nbsp&nbsp&nbsp&nbsp<a href='index.php?page=livreOR&id=".$row['id']."'>Supprimer</a>";
			}
		echo "</p>";
		echo "<hr/>";
	}
	//On peut ajouter un message qui sera ensuite soumis à une confirmation d'un administrateur?>
<div class="identification">
	<form action="verifierLivreOR.php?<?PHP echo SID; ?>" method="post">
		<div class="control-group">
			<label class="control-label" for="nom"><?php echo (isset($trad[1]) ? $trad[1] : "Non traduit") ?> : </label>
			<div class="controls">
				<input type="text" name="nom" />
				<!--style="background-color:#dddbd9"/>-->
				<br />
			</div>
		</div>
		<div class="control-group">
			<label for="message" class="control-label"><?php echo (isset($trad[2]) ? $trad[2] : "Non traduit") ?> : </label>
			<div class="controls">
				<textarea name="message"></textarea>
				<br />
				<!--cols="50" style="background-color:#dddbd9"-->
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<table>
					<tr>
						<td colspan="2" align="center"><?php dsp_crypt(0,1); ?></td>
					</tr>
					<tr>
						<td colspan="2" align="center">Recopier le code:<br>
						<input type="text" name="code"></td>
					</tr>
				</table>
			</div>
		</div>
		<input type="submit" class="btn"
			value="<?php echo (isset($trad[3]) ? $trad[3] : "Non traduit") ?>" />
	</form>
</div><?php
	//deconnection
	//$message->closeCursor();
?>