 <?php

// récupération du titre de la page
$titre = getTraduction("coordonnees_titre", $_SESSION['lang']);
if (isset($titre["valeurtrad"]))
    echo "<h1>" . $titre["valeurtrad"] . "</h1>";
    
    // récupération des informations à ajouter dans la page
$coord = recup_infoCoord();
if (count($coord) < 0) {
    echo "Aucune information à afficher";
} // else

?>
<table>
	<tr>
		<th>Téléphone :</th>
		<td><?php echo $coord['tel']; ?></td>
	</tr>
	<tr>
		<th>Adresse :</th>
		<td><?php echo nl2br(html_entity_decode($coord['adr'])); ?></td>
	</tr>
	<tr>
		<th>Carte :</th>
		<td><img src='<?php echo $coord['img']; ?>' /></td>
	</tr>
	<tr>
		<th>Mail :</th>
		<td><a href="mailto:<?php echo $coord['mail']; ?>">Envoyer un email</a></td>
	</tr>
</table>