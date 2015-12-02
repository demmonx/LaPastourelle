<?php
@session_start();
@header('Content-Type: text/html; charset=utf-8');
require_once 'traitement.inc.php';
verifLoginWithArray($_SESSION, 1);
/*
 * Teste si on a reçu tous les champs, même vide
 * Pour cela, besoin de lister les champs à recevoir
 */
$lang = filter_input(INPUT_GET, 'lang', FILTER_VALIDATE_INT);
if (! isset($lang) || ! $lang) {
    $langage = getLanguage($_SESSION['lang']); // Récupère la langue courante
} else {
    $langage = getLanguage($lang);
}
$titre = getTitles();
$lang = getLanguages();
?>
<h1>Titres : <?php echo $langage['name'] ?></h1>
Langue à modifier :
<form action='list_titre.php' id='choix-langue' method='GET'>
	<select name='lang'><option value=''>Langue</option>
	<?php
foreach ($lang as $item)
    echo "<option value='" . $item['id'] . "'>" . $item['name'] . "</option>";
?>
	</select> <input class='btn' type='submit' value='Choisir' />
</form>
<FORM METHOD='POST' id='actuTitle' ACTION='gestion_titre_traitement.php'>
	<table class='table table-bordered'>
		<tr>
			<th>Titre</th>
			<th>Valeur</th>
		</tr>
				<?php
    
    // Récupération de tous les types pour toutes les langues
    foreach ($titre as $field) {
        echo "<tr>";
        // Récupération du contenu
        $content = getTitre($field["code"], $langage["id"]);
        echo "<td>" . $field['nom'] . "</td>";
        echo "<td><input required type='text' name='" . $field['code'] .
                 "' value='" . htmlspecialchars($content, ENT_QUOTES) .
                 "' /></td>";
        echo "</tr>";
    }
    ?>
			</table>
	<input type="hidden" name="lang" value=" <?php echo $langage["id"]; ?>" />
	<input class='btn' type='submit' value='Modifier' />
	<div id='msgReturn'></div>
</FORM>
<script language="javascript">
$(document).ready(function () {
    /** * Formulaire d'actualité ** */
    $('#actuTitle').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire
        $('#msgReturn').empty();
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                data: form.serialize(), // Envoie de toutes les données
                success: function (html) { // Récupération de la réponse
                    $('#msgReturn').append(html);  // affichage du résultat
                }
            });
    });

	function afficher(page, lang) {
		if (lang !== '') {
			  $(".modif-titre").load(page +"?lang=" + lang);
		}
	}
    $('#choix-langue').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
    	afficher(form.attr("action"), $("select[name=lang]", form).val());
    });
});
</script>