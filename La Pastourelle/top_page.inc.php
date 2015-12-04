<?php function top() { ?>
<!-- HEADER -->
<header class="container-fluid">
	<div class='row'>

		<div class="col-md-3 logo-container">
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

		<div class="col-md-3 col-xs-11 aveyron-carte">
			<img src="ressources/images/aveyron.png" class="logoAveyron"
				alt="Logo de l'Aveyron" />
			<div class='titre-site'>
				La Pastourelle<br />Rodez
			</div>
		</div>

		<div class="col-md-5">
			<div class="slide-top">
						<?php
    $tab = getActiveDiapos();
    foreach ($tab as $diapo) {
        echo "<div><img  class='img-responsive' src='" . $diapo["lien"] .
                 "'/></div>";
    }
    ?>		
		</div>

			<!-- END HEADER -->

		</div>
		<div class="col-md-1 col-xs-1">
			<div class='lang-chooser dropdown'> <?php require 'menu_lang.php'; ?></div>

		</div>
	</div>
</header>
<!-- fin - header  -->
<?php require 'menu.php'; ?>
<!-- .contain-to-grid -->
<section class='container'>
<?php } ?>