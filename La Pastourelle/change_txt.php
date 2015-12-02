<?php
verifLoginWithArray($_SESSION, 1, true);

echo "<h1>Modification d'un texte</h1>";
$page = getPage();
$langage = getLanguages();
foreach ($langage as $lang) {
    echo "<h2>" . $lang['name'] . "</h2>";
    foreach ($page as $item) {
        $content = getContent($item['id'], $lang['id']);
        ?>
<div>
<?php echo $item['nom'] ?> : <span class='spoiler'><i class='fa fa-plus-square-o'></i></span>
	<div class="spoiler-hidden ">
		<form action="change_text_traitement.php" class='update' method='post'>
			<textarea class='editor' name='content'><?php
        
        echo (isset($content['txt']) ? stripnl2br2($content["txt"]) : "");
        ?></textarea>
			<input type='hidden' name='lang' value='<?php echo $lang['id']; ?>' />
			<input type='hidden' name='page' value='<?php echo $item['id']; ?>' />
			<br /> <input class='btn' type="submit" value='Modifier' />
		</form>
	</div>
</div>
<?php
    }
}
?>
<!-- On appelle la fonction spoiler ici, sinon elle ne trouve pas les éléments -->
<script type="text/javascript" src="ressources/js/spoiler.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  
    
    $('.update').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        tinyMCE.triggerSave();
        var form = $(this); // L'objet jQuery du formulaire

        // Récupération des valeurs
        var content = $("textarea[name=content]", form).val();
        alert(content);

        // Vérifie pour éviter de lancer une requête fausse
        if (content === '') {
            alert('Les champs doivent êtres remplis');
        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: form.attr('action'), // cible (formulaire)
                type: form.attr('method'), // méthode (formulaire)
                data: form.serialize(), // Envoie de toutes les données
                success: function (html) { // Récupération de la réponse
                    alert(html);
                }
            });
        }
    });
});
</script>
