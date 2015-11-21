<?php
$cryptinstall = "./cryptographp.fct.php";
require_once $cryptinstall;
?><?php
// Récupération des textes annexes de traduction pour cette zone
$trad = getTrad($_SESSION['lang'], 'livre');
// Si on veut supprimer un texte
if (isset($_GET['id']) and verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    deleteMessageLivre($_GET['id']);
}
// Affichage du texte
$message = getMessageActifLivre();
foreach ($message as $row) {
    echo "<p>";
    echo "<span >";
    // Traduit le format de date anglais en format français
    $dateAN = htmlspecialchars($row['date']);
    list ($annee, $mois, $jour) = explode('-', $dateAN);
    $dateFr = $jour . "/" . $mois . "/" . $annee;
    echo "Le " . $dateFr . " :<br />";
    echo "</span>";
    echo nl2br(htmlspecialchars($row['message']));
    if (isset($_SESSION['pseudo']) and isset($_SESSION['pass']) and
             verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
        echo "<a href='index.php?page=livreOR&id=" . $row['id'] .
         "'>Supprimer</a>";
    }
    echo "</p>";
    echo "<hr/>";
}
// On peut ajouter un message qui sera ensuite soumis à une confirmation d'un
// administrateur ?>
<div class="identification">
	<form action="verifierLivreOR.php?<?PHP echo SID; ?>" method="post">
		<div class="control-group">
			<label class="control-label" for="nom">Nom </label>
			<div class="controls">
				<input type="text" name="nom" />
				<!--/>-->
				<br />
			</div>
		</div>
		<div class="control-group">
			<label for="message" class="control-label">Message </label>
			<div class="controls">
				<textarea name="message"></textarea>
				<br />
				<!--cols="50" -->
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<table>
					<tr>
						<td colspan="2"><?php dsp_crypt(0,1); ?></td>
					</tr>
					<tr>
						<td colspan="2">Recopier le code:<br> <input type="text"
							name="code"></td>
					</tr>
				</table>
			</div>
		</div>
		<input type="submit" class="btn" value="Envoyer" />
	</form>
</div><?php
?>