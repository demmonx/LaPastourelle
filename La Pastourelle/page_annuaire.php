<?php
// impossible de supprimer sinon
@session_start();
@header("Content-Type: text/html; charset=utf-8");
require_once ("inc.function.php");
require_once ("inc.footer.php");
verifLoginWithArray($_SESSION, 0, true);
try {
    $adminOk = checkLoginWithArray($_SESSION, 1);
} catch (Exception $e) {
    $adminOk = false;
}

// Si on est admin et que l'id est correct
if ($adminOk && isset($_GET['id']) && is_numeric($_GET['id'])) {
    setMemberToAnnuaire($_GET['id'], false);
    
    // Affichage
    echo 'Retrait effectuée';
}

$search = filter_input(INPUT_POST, 'aRechercher', FILTER_SANITIZE_SPECIAL_CHARS);
$type = filter_input(INPUT_POST, 'typeRecherche', FILTER_SANITIZE_SPECIAL_CHARS);
// récupération des liens dans la BD et traitement
if ($search && $type) {
    // Suppression des caractères problématiques
    $type = preg_replace("#[^a-zA-Z_]+#", '', $type);
    $tab_membre = getAnnuaire($search, $type);
} else {
    $tab_membre = getAnnuaire();
}
?>
<DIV id="liens">

	<H1>Annuaire</H1>
	<form class="form-inline" action="index.php?page=page_annuaire"
		method="POST">
		<input class="span2" type="text" placeholder="Recherche"
			name="aRechercher" />
		<!-- Ajout d'une liste déroulante pour optimiser la recherche -->
		<div class="input-append">
			<SELECT class="span2" name="typeRecherche">
				<option value='nom'>Nom
				
				<option value='prenom'>Prenom
				
				<option value='pseudo'>Pseudo
				
				<option value='email'>E-mail
				
				<option value='tel'>Telephone
				
				<option value='adresse'>Adresse
			
			</SELECT> <input type="submit" value="Rechercher" class="btn" />
		</div>

	</form><?php

// Si aucun membre dans la liste
if (count($tab_membre) == 0) {
    echo "Aucun membre ne correspond à votre recherche";
    exit(footer());
}
?>
	<p>Cliquez sur le titre de la colonne choisie (ex : Nom) pour ordonner
		la liste</p>
	<?php
echo "<TABLE class='sortable table table-bordered table-striped'  >
			<TR>
					<TH>Nom</TH>
					<TH>Prénom</TH>
					<TH>Pseudo</TH>
					<TH>E-mail</TH>
					<TH>Téléphone</TH>
					<TH>Adresse</TH>";
if ($adminOk) {
    echo "<TH>Action</TH>";
}
echo "</TR>";
foreach ($tab_membre as $row) {
    echo "<TR>
					<TD><B>" . $row['nom'] . "</B></TD>";
    echo "	<TD><B>" . $row['prenom'] . "</B></TD>";
    echo "	<TD>" . $row['pseudo'] . "</TD>";
    echo "	<TD>" . $row['email'] . "</TD>";
    echo "	<TD>" . $row['telephone'] . "</TD>";
    echo "	<TD>" . $row['adresse'] . "</TD>";
    if ($adminOk) {
        echo "<TD><A title='Retirer' HREF='index.php?page=page_annuaire&id=" .
                 $row['id'] . "'><i class='fa fa-user-times fa-2x'></i>
                		</A></TD>";
    }
    echo "</TR>";
}

echo "</TABLE></DIV>";
?>