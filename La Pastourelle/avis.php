<?php
//Récupération des textes annexes de traduction pour cette zone
	$req_recupAvis = $bdd->select("SELECT valeurTrad FROM tradannexe WHERE lang ='".$_SESSION['lang']."' AND nomTrad LIKE 'avis%' ");
	//$req_recupAvis->execute(array($_SESSION['lang']));
	$recupAvis = $req_recupAvis->fetchAll();
	
if (isset($_POST['nom']) AND isset($_POST['email']) AND isset($_POST['message'])) {
	//Pour définir chaque input du formulaire, ajouter le signe de dollar devant
	$msg = "Nom:\t$nom\n";
	$msg .= "E-Mail:\t$email\n";
	$msg .= "Message:\t$message\n\n";

	//Pourrait continuer ainsi jusqu'à la fin du formulaire
	$recipient = "pastourelle.rodez@yahoo.fr";
	$subject = "Formulaire du site internet";
	$mailheaders = "From:formulaire votre avis nous interesse // contact<> \n";
	$mailheaders .= "Reply-To: $email\n\n";
	mail($recipient, $subject, $msg, $mailheaders);

	echo "<H1 align=center>".$recupAvis[0]['valeurTrad'].", $nom </H1>";
	echo "<P align=center>";
	echo $recupAvis[1]['valeurTrad']."</P>";

	echo "<center><a class='btn btn-link' href='index.php?page=avis'>".$recupAvis[2]['valeurTrad']."</a></center>";
	exit();
}?>
<SCRIPT LANGUAGE="JavaScript">
/* On crée une fonction de verification */
function verifForm(formulaire)
{
adresse = formulaire.email.value;
var place = adresse.indexOf("@",1);
var point = adresse.indexOf(".",place+1);
if(formulaire.nom.value == "" ||  formulaire.email.value == "" ||  formulaire.message.value == "") /* on detecte si saisie33 est vide */
	alert('Remplissez correctement tous les champs'); /* dans ce cas on lance un message d'alerte */
else
	if ((place > -1)&&(adresse.length >2)&&(point > 1))
		formulaire.submit(); /* sinon on envoi le formulaire */
	else
		alert('Entrez une adresse e-mail valide !');
}
</SCRIPT>

<?php
	//récupération du titre de la page
	$titre = recup_titre("avis",$bdd);

	echo '<center><H1>'.$titre.'</H1>';
?>

<center>
	<h4><?php echo $recupAvis[3]['valeurTrad']; ?>.</h4>
	<FORM method="POST" action="index.php?page=avis">
		<P><?php echo $recupAvis[4]['valeurTrad']; ?> :<br>
			<INPUT type="text" name="nom" size=30>
		</p>
		<P><?php echo $recupAvis[5]['valeurTrad']; ?> :<br>
			<INPUT type="text" name="email" size=30>
		</p>
		<P><?php echo $recupAvis[6]['valeurTrad']; ?> :<br>
			<textarea name="message" cols=80 rows=10></textarea>
		</p>
		<BUTTON class="btn" NAME="btn_inscription" type="button" value="" onClick="verifForm(this.form)"> <?php echo $recupAvis[7]['valeurTrad']; ?> </BUTTON>
	</form>
</center>