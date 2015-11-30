<?php
require_once 'header.inc.php';
require_once 'footer.inc.php';
?>
<!-- HEADER -->
<header class="container-fluid">
	<div class='row'>

		<div class="col-md-3">
			<figure>
				<a href="index.php" title="Revenir à l'accueil"> <img
					src="ressources/images/logo.png" class="logoPastourelle"
					alt="La Pastourelle de Rodez" />
				</a>
				<figcaption>
					<strong>Groupe Folklorique Rouergat</strong><br /> Fondé en 1948
				</figcaption>
			</figure>
		</div>

		<div class="col-md-3 aveyron-carte">
			<div class='titre-site'>
				La Pastourelle<br />Rodez
			</div>
			<img src="ressources/images/aveyron.png" class="logoAveyron"
				alt="Logo de l'Aveyron" />
		</div>

		<div class="col-md-5">
			<div class="slide-top">
						<?php
						$tab = getActiveDiapos ();
						foreach ( $tab as $diapo ) {
							echo "<div><img  height=225 src='" . $diapo ["lien"] . "'/></div>";
						}
						?>		
		</div>
			<div>Affilié à la Fédération des Arts et Traditions Populaires du
				Centre et Massif Central</div>

			<!-- END HEADER -->

		</div>
		<div class="col-md-1">
			<div class='lang-chooser dropdown'> <?php require 'menu_lang.php'; ?></div>

		</div>
	</div>
</header>
<!-- fin - header  -->
<?php require 'menu.php'; ?>
<!-- .contain-to-grid -->
<section>
		<?php
		
		if (isset ( $_GET ['page'] )) {
			if ($_GET ['page'] == 'generic' && isset ( $_GET ['id'] ) && is_numeric ( $_GET ['id'] )) {
				$page = $_GET ["id"];
				$type = isset ( $_GET ["type"] ) ? $_GET ["type"] : null;
				require_once ("generic.php");
			} else if (! strstr ( $_GET ['page'], 'http://' ) && ! strstr ( $_GET ['page'], 'www.' ) && ! strstr ( $_GET ['page'], '/' )) {
				// && file_exists($_GET['page'])) {
				require_once ($_GET ['page'] . ".php");
			} else {
				require_once ("accueil.php");
			}
		} else {
			require_once ("accueil.php");
		}
		require_once 'footer.inc.php';
		footer();
		?>

		
