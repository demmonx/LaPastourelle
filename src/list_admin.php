<?php
@session_start();
require_once 'inc.function.php';
verifLoginWithArray($_SESSION, 1);
?>

<h2>Administrateurs</h2>

<TABLE class='table table-bordered'>
	<TR>
		<H3>
			<TH>Prenom</TH>
			<TH>Nom</TH>
			<TH>Pseudo</TH>
			<TH>E-mail</TH>
			<TH>Telephone</TH>
			<TH>Adresse</TH>
			<TH>Action</TH>
		</H3>
	</TR>
<?php
$rep = getAdmin();
foreach ($rep as $row) {
    echo "<TR>
		<TD><B>" . $row['prenom'] . "</B></TD>
		<TD><B>" . $row['nom'] . "</B></TD>
		<TD>" . $row['pseudo'] . "</TD>
		<TD>" . $row['email'] . "</TD>
		<TD>" . $row['telephone'] . "</TD>
		<TD>" . $row['adresse'] . "</TD>
		<TD><A class='action'  HREF='traitement_admin.php?ac=1&id=" .
             $row['id'] . "'><i class='fa fa-level-down fa-2x'></i></A></TD>
		</TR>
		<TR></TR>";
}
?>
</table>

<h2>Membres</h2>

<?php

$rep = getMembers();
if (count($rep) != 0) {
    ?>
<TABLE class='table table-bordered'>
	<TR>
		<TH>Prenom</TH>
		<TH>Nom</TH>
		<TH>Pseudo</TH>
		<TH>E-mail</TH>
		<TH>Telephone</TH>
		<TH>Adresse</TH>
		<TH>Action</TH>
	</TR>
<?php
    foreach ($rep as $row) {
        echo "<TR>
		<TD><B>" . $row['prenom'] . "</B></TD>
		<TD><B>" . $row['nom'] . "</B></TD>
		<TD>" . $row['pseudo'] . "</TD>
		<TD>" . $row['email'] . "</TD>
		<TD>" . $row['telephone'] . "</TD>
		<TD>" . $row['adresse'] . "</TD>
		<TD><A class='action' HREF='traitement_admin.php?ac=2&id=" .
                 $row['id'] . "'><i class='fa fa-level-up fa-2x'></i></A></TD>
		</TR>
		<TR></TR>";
    }
} else {
    echo "Aucun membre à afficher";
}
?>
</TABLE>


<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des music mais pas le player
	function refresh() {
        $('#container_admin').load("list_admin.php");
	}

	$('.action').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
            // requete de suppression
            $.ajax({
                url: $(this).attr("href"),
                type: 'GET',
                success: function (html) { // Récupération de la réponse       
                  	 alert(html);            
                     refresh();                  
                }
            });
  
    });


});
</script>