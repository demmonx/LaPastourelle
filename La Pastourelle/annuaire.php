<?php
// impossible de supprimer sinon
@session_start();
?>
<script src="js/sorttable.js" type="text/javascript"></script>

<?php
require_once ("traitement.inc.php");
if (! isset($_SESSION['pseudo']) || ! isset($_SESSION['pass']) ||
         ! verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {
    @header("Content-Type: text/html; charset=utf-8");
    echo "
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant que membre<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  ";
    exit(0);
} else {
    $adminOk = false;
    if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
        $adminOk = true;
    }
    // Si on est admin et que l'id est correct
    if ($adminOk && isset($_GET['id']) && is_numeric($_GET['id'])) {
        setMemberToAnnuaire($_GET['id'], false);
        
        // Affichage
        echo 'Retrait effectuée';
    }
    
    // récupération des liens dans la BD et traitement
    if (isset($_POST['aRechercher'])) {
        $tab_membre = getAnnuaire($_POST['aRechercher'], 
                $_POST['typeRecherche'], 0);
    } else 
        if (isset($_POST['aTrier'])) {
            $tab_membre = getAnnuaire($_POST['aTrier'], "", 1);
        } else {
            $tab_membre = getAnnuaire("", "", 2);
        }
    $cpt = 0;
    $taille_tab = count($tab_membre);
    ?>
<DIV id="liens">

	<H2>ANNUAIRE</H2>



	<form class="form-inline" action="index.php?page=annuaire"
		method="POST">
		<input class="span2" type="text" name="aRechercher" />
		<!-- Ajout d'une liste déroulante pour optimiser la recherche -->
		<div class="input-append">
			<SELECT class="span2" name="typeRecherche">
				<option>Nom
				
				<option>Prenom
				
				<option>Pseudo
				
				<option>E-mail
				
				<option>Telephone
				
				<option>Adresse
			
			</SELECT> <input type="submit" value="Rechercher" class="btn" />
		</div>
	</form><?php
    if (isset($_POST['aRechercher'])) {
        echo "<a class='btn btn-link' href='index.php?page=annuaire'><img src='image/maison.png' alt='Voir la liste complète'  ></a>";
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
        echo "	<TD>" . $row['mail'] . "</TD>";
        echo "	<TD>" . $row['tel'] . "</TD>";
        echo "	<TD>" . $row['adresse'] . "</TD>";
        if ($adminOk) {
            echo "<TD><A class='btn btn-link' HREF='index.php?page=annuaire&id=" .
                     $row['id'] . "'>Retirer</A></TD>";
        }
        echo "</TR>";
    }
    
    echo "</TABLE></DIV>";
    if ($taille_tab == 0) {
        echo "Aucun membre ne correspond à votre recherche";
    }
}
?>