<?php
verifLoginWithArray($_SESSION, 1, true);
// Formulaire qui changera la phrase du jour
$languages = getLanguages();
?>
<form id="phraseMaj" class="form-horizontal"
	action="change_phrasejour_traitement.php" method="post">
	<table>
		<tr>
			<th>Langue</th>
			<th>Phrase</th>
		</tr>
<?php
foreach ($languages as $lang) {
    ?>
	<tr>
			<td><?php echo $lang['name'];?></td>
			<td><textarea name="phrase[<?php echo $lang['id'];?>]"><?php echo getPhraseJour($lang['id']);?></textarea></td>
		</tr>	
<?php
}
?> 
</table>
	<input class="btn" type="submit" value="OK" />
</form>
<div id='msgReturn'></div>
<script language="javascript">
$(document).ready(function () {
    /** * Formulaire d'actualité ** */
    $('#phraseMaj').on('submit', function (e) {
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
});

</script>
