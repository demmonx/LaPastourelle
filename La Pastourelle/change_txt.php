<?php
if (! isset($_SESSION['pseudo']) or ! isset($_SESSION['pass']) or
         ! verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    echo "
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  ";
    
    exit(0);
} // else

echo "<h1>Modification d'un texte</h1>";
$page = getPage();
$langage = getLanguages();
foreach ($langage as $lang) {
    echo "<h4>" . $lang['name'] . "</h4>";
    foreach ($page as $item) {
        $content = getContent($item['id'], $lang['id']);
        ?>
<div>
<?php echo $item['nom'] ?> : <button class="spoiler">Afficher / Masquer</button>
	<div class="spoiler-hidden ">
		<form action="change_text_traitement.php" class='update' method='post'>
			<textarea class='form-compteRendu' name='content'><?php
        
        echo (isset($content['txt']) ? stripnl2br2($content["txt"]) : "");
        ?></textarea>
			<input type='hidden' name='lang' value='<?php echo $lang['id']; ?>' />
			<input type='hidden' name='page' value='<?php echo $item['id']; ?>' />
			<br /> <input type='submit' value='Modifier' />
		</form>
	</div>
</div>
<?php
    }
}
?>
<!-- On appelle la fonction spoiler ici, sinon elle ne trouve pas les éléments -->
<script type="text/javascript">
$(document).ready(function () {

    /*** Spoiler ***/
    // Clique sur élément
    $(".spoiler").click(function () {
        $(this).next().toggle(0); // inverse l'état de l'élément suivant en 4ms
        return false;  // bloque la fonction par défaut
    });

    
    $('.update').on('submit', function (e) {
        e.preventDefault(); // Empeche de soumettre le formulaire
        var form = $(this); // L'objet jQuery du formulaire

        // Récupération des valeurs
        var content = $("textarea[name=content]", form).val();

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
