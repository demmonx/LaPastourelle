<?php
/*
 * Suppression de la page adminPlanning.php
 * Les actions administrateurs sont présents sur la page planning.php ici
 * présente avec une restriction d'accès bien sur
 * @author Pierre Gaboriaud et Yohan Delmas (IUT de Rodez) Années 2009-2011
 */
if (! isset($_SESSION['pseudo']) or ! isset($_SESSION['pass']) or
         ! verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {
    echo "
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  ";
    exit(0);
}
require_once 'traitement.inc.php';
if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    // Suppression dans la base de données
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        // récupération de l'evt à delete
        // Suppression dans la BD
        deleteFromPlanning($_GET["id"]);
        
        // Ajout dans la base de données
    }
    ?>
<script language="javascript">
$(document).ready(function () {
	
	/* Vérification de la date */
	function checkDate(date) {
		return ( (new Date(date) !== "Invalid Date" && !isNaN(new Date(date)) ));
	}
	
    /** * Formulaire de connexion ** */
    $('#ajout').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire

        // Récupération des valeurs
        var jour = $('#jour').val();  
        var date = $('#date').val();  
        var lieu = $('#lieu').val();  
        var joueur = $('#joueur').val();   

        $('#msgReturn').empty();
        // Vérifie pour éviter de lancer une requête fausse
        if (jour === '' || date === '' || lieu === '' || joueur === '') {
            $('#msgReturn').append('Les champs doivent êtres remplis');
        } else if (!checkDate(date) || date.length != 10) {
            	$('#msgReturn').append("La date doit être valide");         
        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                data: form.serialize(), // Envoie de toutes les données
                success: function (html) { // Récupération de la réponse
                    $('#msgReturn').append(html);  // affichage du résultat
                }
            });
        }
    });
});
</SCRIPT>
<?php
    /* Titre admin */
    echo "<H2>ADMINISTRATION DU PLANNING</H2>";
    /* Formulaire d'ajout d'un évenement */
    echo "
		<div class='identification'>
			<FORM class='form-horizontal' id='ajout' METHOD='POST' ACTION='planning_ajout.php'>
				<div class='control-group'>
					<label class='control-label'>Jour</label>
					<div class='controls'>
						<INPUT type=text id='jour' name='jour' required />
					</div>
				</div>
				<div class='control-group'>
					<label class='control-label'>Date (jj/mm/aaaa)</label>
					<div class='controls'>
						<INPUT type=text id='date' name='date' required />
					</div>
				</div>
				<div class='control-group'>
					<label class='control-label'>Lieu</label>
					<div class='controls'>
						<INPUT type=text id='lieu' name='lieu' required />
					</div>
				</div>
				<div class='control-group'>
					<label class='control-label'>Musiciens</label>
					<div class='controls'>
						<INPUT type=text id='musiciens' name='musiciens' required />
					</div>
				</div>
				<input type='submit' value='Ajouter'/>
			</FORM>
 		<div id='msgReturn'></div>";
} else {
    /* Titre membre */
    echo "<H2>PLANNING DES SORTIES ET REPETITIONS A VENIR</H2>";
}

// récupération des info dans la BD et traitement
$tab_planning = recup_planning();

/**
 * tableau du planning
 */
echo "
		<TABLE class='table table-bordered table-striped'>
			<TR>
				<TH>JOUR</TH>
				<TH>DATE</TH>
				<TH>LIEU</TH>
				<TH>MUSICIENS</TH>";
if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    echo "<TH colspan='3'>Actions</TH>";
} // Ajout des colones de suppression
echo "</TR>";
$adminOK = false;
if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    $adminOK = true;
}
foreach ($tab_planning as $row) {
    $un_jour = $row["jour"];
    $une_date = $row["date"];
    $un_lieu = $row["lieu"];
    $un_musiciens = $row["joueur"];
    $unId = $row["id"];
    
    // traitement de la date pour l'afficher de la forme jj/mm/aaaa
    $morceau_date = explode("/", $une_date);
    $jour = $morceau_date[2];
    $mois = $morceau_date[1];
    $annee = $morceau_date[0];
    $une_date = $jour . "/" . $mois . "/" . $annee;
    
    echo "<TR><TD>" . $un_jour . "</TD><TD>" . $une_date . "</TD><TD>" . $un_lieu .
             "</TD><TD>" . $un_musiciens . "</TD> ";
    if ($adminOK) {
        echo "<TD><A class='btn btn-link' HREF=\"index.php?page=planning&id=" .
                 $unId .
                 "\">Supprimer </A> </TD>
			      <TD><A class='btn btn-link' HREF=\"index.php?page=modifDatePlanning&id=" .
                 $unId . "\"> Modifier</A></TD>";
    }
}

echo "</TABLE>";
?>