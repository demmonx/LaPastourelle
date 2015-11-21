<?php
@session_start();
require_once 'traitement.inc.php';
if (isset($_SESSION['pseudo']) && isset($_SESSION['pass']) &
         verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    
    $tab = recup_actuel_diapos();
    echo "<div class='slideshow'><ul>";
    foreach ($tab as $row)
        echo "<li><img src='" . $row["lien"] .
                 "'  max- /></li>";
    echo "</ul>";
    ?>
</div>
<script type="text/javascript">
   $(function(){
      setInterval(function(){
         $(".slideshow ul").animate({marginLeft:-350},1000,function(){
            $(this).css({marginLeft:0}).find("li:last").after($(this).find("li:first"));
         })
      }, 3500);
   });
</script>
<?php
}
?>