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
<div id="espace_reserve">
	Espace <span>réservé</span> aux membres de la Pastourelle<br /> Pour <span>accéder</span>
	à cet espace, vous devez obligatoirement être <span>inscrit</span>.<br />
	Pour vous <span>inscrire</span>, <span>cliquez</span> sur la rubrique <span>"s'inscrire"</span>
	et <span>remplissez</span> les champs qui vous sont demandés.
</div>
<H2>Identification</H2>
<div class="identification">
	<FORM class="form-horizontal" ACTION="index.php?page=identification"
		METHOD="POST">
		<div class="control-group">
			<label class="control-label for="inputEmail">Pseudo</label>
			<div class="controls">
				<input type="text" name="pseudo" placeholder="Pseudo">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputPassword">Mot de passe</label>
			<div class="controls">
				<input type="password" name="motdepasse" placeholder="Mot de Passe">
			</div>
		</div>
		<button type="submit" class="btn">Se Connecter</button>
	</FORM>
</div>
';
