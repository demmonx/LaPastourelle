 <?php
require_once 'inc.footer.php';
// récupération du titre de la page
$titre = getTraduction("coord", $_SESSION['lang']);
if (isset($titre["content"]))
    echo "<h1>" . $titre["content"] . "</h1>";
    
    // récupération des informations à ajouter dans la page
$coord = getCoordonnees();
if (count($coord) <= 0) {
    echo "Nos coordonnées ne sont pas dispobibles";
    exit(footer());
} // else

?>
<table class='table'>
	<tr>
		<th>Téléphone</th>
		<td><?php echo convertPhoneNumber($coord['tel']); ?></td>
	</tr>
	<tr>
		<th>Adresse</th>
		<td><?php echo nl2br(html_entity_decode($coord['adr'])); ?></td>
	</tr>
	<tr>
		<th>Carte</th>
		<td>
			<div class='map' id="map"></div>
		</td>
	</tr>
	<tr>
		<th>Mail</th>
		<td><a href="mailto:<?php echo $coord['mail']; ?>"><?php echo $coord['mail']; ?></a></td>
	</tr>
</table>
<script>
function initialize() {
  var myLatLng = {lat: <?php echo $coord['lat']; ?>, lng: <?php echo $coord['long']; ?>};

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 13,
    center: myLatLng
  });

  var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
    title: 'La Pastourelle'
  });
  
}


      google.maps.event.addDomListener(window, 'load', initialize);
    </script>