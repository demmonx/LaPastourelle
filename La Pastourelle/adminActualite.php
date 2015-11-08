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
?>
<center>
	<h1>Administration de l'actualité</h1>


	<DIV id=accueil>

		<p style='text-align: center'>
			Tous les champs sont optionnels.<br />Vous pouvez donc n'avoir qu'une
			seule actualité (uniquement théatre par exemple)
		</p>


		<FORM METHOD='POST' ACTION='actu_traitement.php'>
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
    $langage = getLanguages();
    // Récupération de toutes les langues
    foreach ($langage as $lang) {
        echo "<tr><td>" . $lang["name"] . "</td>";
        
        // Récupération de tous les types pour toutes les langues
        foreach ($type as $field) {
            // Récupération du contenu
            $content = getActu($lang["id"], $field["id"]);
            $content = count($content) == 1 ? $content[0]["txt"] : "";
            echo "<td><textarea name='" . $field["type"] . "[" . $lang["id"] .
                     "]'>" . $content . "</textarea></td>";
        }
        echo "</tr>";
    }
    ?>
			</table>
			<input type='submit' value='Modifier' />

		</FORM>

	</DIV>
	<A class='btn btn-link' HREF=index.php?page=change_img_act>Modifier les
		images</A>
</CENTER>
