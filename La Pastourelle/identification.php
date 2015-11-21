<?php
/*
 * Analyse du formulaire, Variables de session, Redirection OPTIMISE
 * @author Pierre Gaboriaud et Yohan Delmas (IUT de Rodez) Années 2009-2011
 */
if (! empty($_POST['pseudo']) and ! empty($_POST['motdepasse'])) {
    echo "
	";
    if (verifLo($_POST['pseudo'], sha1($_POST['motdepasse']))) {
        $_SESSION['pseudo'] = $_POST['pseudo'];
        $_SESSION['pass'] = sha1($_POST['motdepasse']);
        $_SESSION['id'] = getId($_POST['pseudo']);
        echo "Félicitations ! Vous êtes maintenant connecté sur le site de La Pastourelle de Rodez<br />";
    } else {
        echo "Pseudo ou mot de passe incorrect<br />";
    }
    echo "Pour revenir à la page d'accueil, cliquez<a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
	";
    exit(0);
}
?>
	Espace
réservé
aux membres de la Pastourelle
<br />
Pour accéder à cet espace, vous devez obligatoirement être inscrit .
<br />
Pour vous inscrire , cliquez sur la rubrique "s'inscrire" et remplissez
les champs qui vous sont demandés.
<H2>Identification</H2>
<FORM ACTION="index.php?page=identification" METHOD="POST">
	<table>
		<tr>
			<td>Pseudo</td>
			<td><input type="text" name="pseudo" placeholder="Pseudo" /></td>
		</tr>
		<tr>
			<td>Mot de passe</td>
			<td><input type="password" name="motdepasse"
				placeholder="Mot de Passe" /></td>
		</tr>
	</table>
	<input type="submit" value="Se Connecter" />
</FORM>