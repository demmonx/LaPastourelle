<?php
@session_start();
require_once "traitement.inc.php";
if (! isset($_SESSION['pseudo']) or ! isset($_SESSION['pass']) or
         ! verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {
    echo "
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  ";
    redirect("index.php?page=accueil", 3);
    exit(0);
} // else
  // Affichage du titre
if (verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    echo '<H2>Ajouter un compte rendu</H2>';
    ?>
<form action='compte_rendu_traitement.php' method='post' id='new-cr'>
	<textarea name='content' class='form-compteRendu' placeholder='Contenu'
		required></textarea>
	<br /> <label>Date de réunion : </label><input type='text'
		class='datepicker' name='date' placeholder="jj/mm/aaaa" required /> <input
		type="submit" value="Ajouter" />
</form>
<?php
}
echo "<div id='list-cr'>";
require_once 'list_compte_rendu.php';
?>
</div>

<script type="text/javascript">
$(document).ready(function () {

	/* Vérification de la date */
	function checkDate(date) {
		return ( (new Date(date) !== "Invalid Date" && !isNaN(new Date(date)) ));
	}

	function refresh() {
		$("#list-cr").load("list_compte_rendu.php");
		}
	
    /** * Formulaire de connexion ** */
    $('#new-cr').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire

        // Récupération des valeurs
        var content = $("textarea[name=content]", form).val();  
        var date = $("input[name=date]", form).val();  

        $('#msgReturn').empty();
        // Vérifie pour éviter de lancer une requête fausse
        if (content === '' || date === '') {
            alert('Les champs doivent êtres remplis');
        } else if (!checkDate(date)) {
            	alert("La date doit être valide");         
        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                data: form.serialize(), // Envoie de toutes les données
                success: function (html) { // Récupération de la réponse
                    if (html == "Ajout effectué avec succès") {
                    	refresh();
                    	form.get(0).reset();
                        }
                    alert(html);  // affichage du résultat
                }
            });
        }
    });

});
</script>