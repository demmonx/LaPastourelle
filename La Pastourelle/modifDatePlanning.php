<?php
if (! isset($_SESSION['pseudo']) or ! isset($_SESSION['pass']) or
         ! verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    echo "
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  ";
    exit(0);
} else {
    ?>
<script language="javascript">
$(document).ready(function () {
	
	/* Vérification de la date */
	function checkDate(date) {
		return ( (new Date(date) !== "Invalid Date" && !isNaN(new Date(date)) ));
	}
	
    /** * Formulaire de connexion ** */
    $('#modif').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire

        // Récupération des valeurs
        var jour = $('#jour').val();  
        var date = $('#date').val();  
        var lieu = $('#lieu').val();  
        var joueur = $('#joueur').val();  
        var id = $('#id').val(); 

        $('#msgReturn').empty();
        // Vérifie pour éviter de lancer une requête fausse
        if (jour === '' || date === '' || lieu === '' || joueur === '' || id === '') {
            $('#msgReturn').append('Les champs doivent êtres remplis');
        }else if (isNaN(id) || id < 0) {
        	$('#msgReturn').append("L'identifiant doit être valide");
        } else if (!checkDate(date)) {
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
    
    $info_date = recup_datePlanning($_GET["id"]);
    if (count($info_date) <= 0) {
        echo "Impossible de modifier l'élément sélectionné";
    } else {
        
        echo "<H2>ADMINISTRATION DU PLANNING</H2>";
        echo "<FORM METHOD='POST' id='modif' ACTION='modifDatePlanning_traitement.php'>
			<TABLE >
				<TR><TD>Jour</TD><TD><INPUT required type=text id='jour' name='jour'  value='" .
                 $info_date['jour'] .
                 "'></TD></tr>
			<tr><TD>Date (jj/mm/aaaa)</TD><TD><INPUT required type=text id='date' name='date'  value='" .
                 $info_date['date'] .
                 "'></TD></tr>
			<tr><TD>Lieu</TD><TD><INPUT required type=text name='lieu' id='lieu'  value='" .
                 $info_date['lieu'] .
                 "'></tr>
			<tr><TD>Musiciens</TD><TD><textarea required name='musiciens' id='joueur'>" .
                 $info_date['joueur'] . "</textarea></TD></TR></TABLE>
				<INPUT type=hidden name='id' id='id' value='" . $info_date['id'] . "'>
				<BR><input type='submit' value='Modifier'>
		  </FORM><div id='msgReturn'></div>";
    }
    
    echo "<A class='btn btn-link' HREF='index.php?page=planning'>Retour à la page précédente</A>";
}
?>