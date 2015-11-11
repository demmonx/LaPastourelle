<?php
if (! isset ( $_SESSION ['pseudo'] ) or ! isset ( $_SESSION ['pass'] ) or ! verifLoAdmin ( $_SESSION ['pseudo'], $_SESSION ['pass'] )) {
	echo "<center>
			Vous ne pouvez pas accéder Ã  ces pages sans être connecté en tant qu'administrateur<br />
			Revenir Ã  la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	exit ( 0 );
}
// Formulaire qui changera la phrase du jour
$languages = getLanguages ();
?>
<form id="phraseMaj" class="form-horizontal" action="change_phrasejour_traitement.php"
	method="post">
	<table>
		<tr>
			<th>Langue</th>
			<th>Phrase</th>
		</tr>
<?php
foreach ( $languages as $lang ) {
	?>
	<tr>
	<td><?php echo $lang['name'];?></td>
	<td>
	<input  class="input-medium span4" type="text"
			name="phrase[<?php echo $lang['id'];?>]"
			value="<?php echo recup_phrasejour($lang['id']);?>" /> 
	</td></tr>	
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
