<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accéder Ã  ces pages sans être connecté en tant qu'administrateur<br />
			Revenir Ã  la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	exit(0);
} else {
	// Formulaire qui changera la phrase du jour
		$phrase = recup_phrasejour();
		
		echo "Phrase actuelle : ".$phrase."</br>";
	
	?>
	<form class="form-horizontal" action="index.php?page=change_phrasejour" method="post">
		<input class="input-medium span4" type="text" name="phrase" placeholder="Nouvelle phrase de la semaine..."/>
		<input class="btn" type="submit" value="OK"/>
	</form>
	Cliquez sur "OK" pour effectuer le changement de la phrase de la semaine.<br/>
	Retourner sur la page d'accueil pour constater le changement.
	<?php
	//Changement de la phrase du jour
	$phrase = filter_input(INPUT_POST, 'phrase', FILTER_SANITIZE_SPECIAL_CHARS);
		if(isset($phrase) && $phrase) {
			$modif_phrasejour = $bdd->prepare("UPDATE tradannexe SET valeurTrad = :val 
											  WHERE lang = 'fr' 
												AND nomTrad = 'phrasejour'");
			$modif_phrasejour->bindValue(":val", $phrase);
			$modif_phrasejour->execute();
			echo "Phrase mise à jour<br>";
		}
}?>
