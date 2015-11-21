<?php
// récupération du titre de la page
// récupération du titre de la page
$titre = getTraduction("avis_titre", $_SESSION['lang']);
if (isset($titre["valeurtrad"]))
    echo "<h1>" . $titre["valeurtrad"] . "</h1>";
?>

<FORM method="POST" action="index.php?page=avis">
	<P>
		Nom :<br> <INPUT type="text" name="nom" size=30 required>
	</p>
	<P>
		Mail :<br> <INPUT type="text" name="email" size=30 required>
	</p>
	<P>
		Message :<br>
		<textarea name="message" class='form-compteRendu' required></textarea>
	</p>
	<input type="submit" value="Envoyer" />
</form>