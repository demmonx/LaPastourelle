<?php
$titre = getTraduction("lien", $_SESSION['lang']);
if (isset($titre["content"]))
    echo "<h1>" . $titre["content"] . "</h1>";

$liens = getLinks();
if (count($liens) <= 0) {
    echo "Aucun lien à afficher";
}
echo "<table>";
foreach ($liens as $link) {
    ?>
<tr>
	<td><?php echo $link['nom'];?></td>
	<td><a href="<?php echo $link['url'];?>"><img
			src='<?php echo $link['img'];?>' /></a></td>
</tr>
<?php
}
echo "</table>";