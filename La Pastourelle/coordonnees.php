 <?php

// récupération du titre de la page
$titre = getTraduction("coord", $_SESSION['lang']);
if (isset($titre["content"]))
    echo "<h1>" . $titre["content"] . "</h1>";
    
    // récupération des informations à ajouter dans la page
$coord = getCoordonnees();
if (count($coord) < 0) {
    echo "Aucune information à afficher";
} // else

?>
<table>
	<tr>
		<th>Téléphone :</th>
		<td><?php echo convertPhoneNumber($coord['tel']); ?></td>
	</tr>
	<tr>
		<th>Adresse :</th>
		<td><?php echo nl2br(html_entity_decode($coord['adr'])); ?></td>
	</tr>
	<tr>
		<th>Carte :</th>
		<td>

			<figure>
				<a href="<?php echo $coord['img']; ?>" title="Cliquez pour agrandir">
					<img src="<?php echo $coord['img']; ?>" alt="Localisation" />
					<figcaption>Cliquez ici pour agrandir</figcaption>
				</a>
			</figure>
		</td>
	</tr>
	<tr>
		<th>Mail :</th>
		<td><a href="mailto:<?php echo $coord['mail']; ?>"><?php echo $coord['mail']; ?></a></td>
	</tr>
</table>