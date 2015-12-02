<?php
@session_start();
require_once 'traitement.inc.php';
verifLoginWithArray($_SESSION, 1);

$tab = getActiveDiapos();
echo "<div class='slide-admin'>";
foreach ($tab as $row)
    echo "<div><img src='" . $row["lien"] . "' /></div>";
echo "</div>";
?>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('.slide-admin').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
    	dots: false,
    	arrows: true,
    	infinite: true,
    });	
});
</script>