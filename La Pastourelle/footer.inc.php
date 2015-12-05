<?php
@session_start();
require_once 'traitement.inc.php';

function footer ()
{
    
    // On vérifie les statuts de connexion
    try {
        $member = checkLoginWithArray($_SESSION, 0);
    } catch (Exception $e) {
        $member = false;
    }
    try {
        $admin = checkLoginWithArray($_SESSION, 1);
    } catch (Exception $e) {
        $admin = false;
    }
    ?>
</section>
<!-- FOOTER -->
<footer class="footer container-fluid">
	<a href="#0" class="cd-top">Top</a>
	<div class='row'>
		<div class="col-md-8 border-right">
<?php
    $coord = getCoordonnees();
    if (isset($coord['adr'])) {
        echo nl2br(html_entity_decode($coord['adr'])) . " - ";
    }
    if (isset($coord['tel'])) {
        echo convertPhoneNumber($coord['tel']) . "<br />";
    }
    echo "Association reconnue d'intérêt général et
			habilitée à ce titre à recevoir des dons";
    if (isset($coord['mail'])) {
        echo " - <a href='mailto:" . $coord['mail'] . "'>" . $coord['mail'] .
                 "</a>";
    }
    echo "<br /><i>Affilié à la Fédération des Arts et Traditions Populaires du
Centre et Massif Central</i>";
    ?>
	</div>
		<div class="col-md-4">
					<?php
    if ($member) {
        if ($admin) {
            echo '<b>Vous êtes Administrateur : ' . $_SESSION['pseudo'] . '</b>';
        } else {
            echo '<b>Vous êtes Membre : ' . $_SESSION['pseudo'] . "</b>";
        }
        ?>
       <br /> <a href="index.php?page=info_perso"><i
				class="fa fa-user fa-lg"></i> Mon compte</a><br /> <a
				href="index.php?page=deconnexion"><i class="fa fa-sign-out fa-lg"></i>
				Se Déconnecter</a>
                 
                 
                 <?php
    } else {
        ?>
						
						<a href="index.php?page=inscription"><i class="fa fa-user fa-lg"></i>
				S'inscrire</a> <br /> <br /> <a href="index.php?page=identification"><i
				class="fa fa-lock fa-lg"></i> Se connecter</a>
				<?php }?>
		
	
	</div>
	</div>

</footer>

<!-- END FOOTER -->
</body>

</html>
<?php } ?>

