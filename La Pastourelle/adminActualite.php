<?php
if (! isset($_SESSION['pseudo']) or ! isset($_SESSION['pass']) or
         ! verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
    redirect("index.php?page=accueil", 3);
    exit(0);
} // else
$type = getActuType();
$langage = getLanguages();
?>
<center>
	<h1>Administration de l'actualité</h1>


	<DIV id=accueil>

		<p style='text-align: center'>
			Tous les champs sont optionnels.<br />Vous pouvez donc n'avoir qu'une
			seule actualité (uniquement théatre par exemple)
		</p>


		<FORM METHOD='POST' id = 'actuMaj' ACTION='actu_maj.php'>
			<br /> <br />Modification de l'actualité : <BR> <BR>
			<table>
				<tr>
					<th>Langue</th>
					<?php
    foreach ($type as $field) {
        echo "<th>" . $field["name"] . "</th>";
    }
    ?>
				</tr>
				<?php
 
    // Récupération de toutes les langues
    foreach ($langage as $lang) {
        echo "<tr><td>" . $lang["name"] . "</td>";
        
        // Récupération de tous les types pour toutes les langues
        foreach ($type as $field) {
            // Récupération du contenu
            $content = getActu($lang["id"], $field["id"]);
            $content = count($content) == 1 ? $content[0]["txt"] : "";
            echo "<td><textarea name='" . $field["type"] . "[" . $lang["id"] .
                     "]'>";
            echo stripnl2br2 ($content);
            echo "</textarea></td>";
        }
        echo "</tr>";
    }
    ?>
			</table>
			<input type='submit' value='Modifier' />
			<div id='msgReturn'></div>
		</FORM>

	</DIV>
	<A class='btn btn-link' HREF=index.php?page=change_img_act>Modifier les
		images</A>
</CENTER>

<script language="javascript">
$(document).ready(function () {
    /** * Formulaire de connexion ** */
    $('#actuMaj').on('submit', function (e) {
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
