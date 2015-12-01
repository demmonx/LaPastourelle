<?php
/*
 * Suppression de la page adminPlanning.php
 * Les actions administrateurs sont présents sur la page planning.php ici
 * présente avec une restriction d'accès bien sur
 * @author Pierre Gaboriaud et Yohan Delmas (IUT de Rodez) Années 2009-2011
 */
verifLoginWithArray($_SESSION, 0, true);
try {
    $adminOk = checkLoginWithArray($_SESSION, 1);
} catch (Exception $e) {
    $adminOk = false;
}
if ($adminOk) {
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
                    $("#planning-container").load("list_planning.php");
                }
            });
        }
    });
});
</SCRIPT>
<H2>ADMINISTRATION DU PLANNING</H2>

<FORM class='form-horizontal' id='ajout' METHOD='POST'
	ACTION='planning_traitement.php'>
	<table>
		<tr>
			<td>Jour</td>
			<td><INPUT type=text id='jour' name='jour' required /></td>
		</tr>
		<tr>
			<td>Date (jj/mm/aaaa)</td>
			<td><INPUT type=text id='date' class='datepicker' name='date'
				required /></td>
		</tr>
		<tr>
			<td>Lieu</td>
			<td><INPUT type=text id='lieu' name='lieu' required /></td>
		</tr>
		<tr>
			<td>Musiciens</td>
			<td><INPUT type=text id='musiciens' name='musiciens' required /></td>
		</tr>
	</table>
	<input type='submit' value='Ajouter' />
</FORM>
<div id='msgReturn'></div>
<?php
}
/* Titre membre */
echo "<H2>PLANNING DES SORTIES ET REPETITIONS A VENIR</H2>";
echo "<div id='planning-container'>";
require 'list_planning.php';
echo "</div>";
?>