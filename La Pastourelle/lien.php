<?php
$titre = getTraduction("lien_titre", $_SESSION['lang']);
if (isset($titre["valeurtrad"]))
    echo "<h1>" . $titre["valeurtrad"] . "</h1>";

$liens = recup_lienExt();
if (count($liens) <= 0) {
    echo "Aucun lien à afficher";
}
echo "<table>";
foreach ($liens as $link) {
    ?>
<tr>
	<td><?php echo $link['nom_public'];?></td>
	<td><?php echo $link['content'];?></td>
	<td><a href="<?php echo $link['url'];?>"><img
			src='<?php echo $link['img'];?>' /></a></td>
</tr>
<?php
}
echo "</table>";