<?php
@session_start();
require_once 'traitement.inc.php';
$adminOK = false;
if (isset($_SESSION['pseudo']) && isset($_SESSION['pass']) &&
         verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    $adminOK = true;
}

if (! $adminOK) {
    exit("Vous n'avez pas les droits requis");
}
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
		<TD>" . $row['adresse'] .
             "</TD>
		<TD><A class='action'  HREF='gestion_admin.php?ac=1&id=" .
             $row['id'] . "'>Retirer</A></TD>
		</TR>
		<TR></TR>";
}
?>
</table>

<h2>Membres</h2>

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
$rep = getMembers();
foreach ($rep as $row) {
    echo "<TR>
		<TD><B>" . $row['prenom'] . "</B></TD>
		<TD><B>" . $row['nom'] . "</B></TD>
		<TD>" . $row['pseudo'] . "</TD>
		<TD>" . $row['email'] . "</TD>
		<TD>" . $row['telephone'] . "</TD>
		<TD>" . $row['adresse'] .
             "</TD>
		<TD><A class='action' HREF='gestion_admin.php?ac=2&id=" .
             $row['id'] . "'>Promouvoir</A></TD>
		</TR>
		<TR></TR>";
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