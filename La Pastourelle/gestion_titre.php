<?php
@session_start();
@header('Content-Type: text/html; charset=utf-8');
require_once 'traitement.inc.php';
verifLoginWithArray($_SESSION, 1);
$lang = getLanguages();
?>
Langue à modifier :
<form action='list_titre.php' id='choix-langue' method='GET'>
	<select name='lang'><option value=''>Langue</option>
	<?php
foreach ($lang as $item)
    echo "<option value='" . $item['id'] . "'>" . $item['name'] . "</option>";
?>
	</select> <input type='submit' value='Choisir' />
</form>
<div class='modif-titre'>
<?php require 'list_titre.php'; ?>
</div>


<script type="text/javascript">
$(document).ready(function () {

	function afficher(page, lang) {
		if (lang !== '') {
			  $(".modif-titre").load(page +"?lang=" + lang);
		}
	}
    $('#choix-langue').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
    	afficher(form.attr("action"), $("select[name=lang]", form).val());
    });

});
</script>
