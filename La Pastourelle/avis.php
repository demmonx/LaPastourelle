<?php
// récupération du titre de la page
// récupération du titre de la page
$titre = getTraduction("avis_titre", $_SESSION['lang']);
if (isset($titre["valeurtrad"]))
    echo "<h1>" . $titre["valeurtrad"] . "</h1>";
?>

<center>
	<h4><?php echo getTraduction()['valeurTrad']; ?>.</h4>
	<FORM method="POST" action="index.php?page=avis">
		<P><?php echo $recupAvis[4]['valeurTrad']; ?> :<br> <INPUT type="text"
				name="nom" size=30>
		</p>
		<P><?php echo $recupAvis[5]['valeurTrad']; ?> :<br> <INPUT type="text"
				name="email" size=30>
		</p>
		<P><?php echo $recupAvis[6]['valeurTrad']; ?> :<br>
			<textarea name="message" cols=80 rows=10></textarea>
		</p>
		<BUTTON class="btn" NAME="btn_inscription" type="button" value=""
			onClick="verifForm(this.form)"> <?php echo $recupAvis[7]['valeurTrad']; ?> </BUTTON>
	</form>
</center>