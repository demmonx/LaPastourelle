<?php
@session_start();
require_once "inc.function.php";
verifLoginWithArray($_SESSION, 0, true);
try {
    $adminOk = checkLoginWithArray($_SESSION, 1);
} catch (Exception $e) {
    $adminOk = false;
}
// Affichage du titre
if ($adminOk) {
    echo '<H2>Ajouter un compte rendu</H2>';
    ?>
<form action='traitement_compte_rendu.php' method='post' id='new-cr'>
	<textarea name='content' class='editor' placeholder='Contenu'></textarea>
	<br /> <label>Date de réunion : </label><input type='text'
		class='datepicker' name='date' placeholder="jj/mm/aaaa" required /> <input class='btn' type="submit" value="Ajouter" />
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
        tinyMCE.triggerSave();
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
                    if (html.search("succès") >= 0) {
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