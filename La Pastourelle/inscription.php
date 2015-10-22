<?php 
$cryptinstall="./cryptographp.fct.php";
include $cryptinstall; 
?>
<script language="javascript">
/* On crée une fonction de verification */
function verifForm(formulaire)
{
adresse = formulaire.email.value;
var place = adresse.indexOf("@",1);
var point = adresse.indexOf(".",place+1);
if(formulaire.pseudo.value == "" || formulaire.mdp.value == "" || formulaire.tel.value == "" ||  (formulaire.tel.value).length != 10
   ||  formulaire.nom.value == "" ||  formulaire.prenom.value == "" ||  formulaire.adresse.value == "") /* on detecte si saisie33 est vide */
	alert('Remplissez correctement tous les champs'); /* dans ce cas on lance un message d'alerte */
else
	if ((place > -1)&&(adresse.length >2)&&(point > 1))
		formulaire.submit(); /* sinon on envoi le formulaire */
	else
		alert('Entrez une adresse e-mail valide !');
}
</script>

	<center> <h2>Inscription</h2></center>
	<div id="espace_reserve">
		Attention ! L'inscription au site est <span>réservée</span> aux seuls <span>membres</span> de l'association.<br />
		Si vous n'en faites pas partie, nous serions ravis que vous nous rejoignez.
	</div>
				<form action="verifier.php?<?PHP echo SID; ?>" method="post">
					<table>
						<tr>
							<td> Prénom </td>
							<td><input type="text" value="" name="prenom" size=27></td>
						</tr>
						<tr>
							<td> Nom </td>
							<td><input type="text" value="" name="nom" size=27></td>
						</tr>
						<tr>
							<td colspan="2"><br></td>
						</tr>
						<tr>
							<td> Pseudo </td>
							<td><input type="text" value="" name="pseudo" size=27></td>
						</tr>
						<tr>
							<td> Mot de Passe </td>
							<td><input type="password" value="" name="mdp" size=27></td>
						</tr>
						<tr>
							<td colspan="2"><br></td>
						</tr>
						<tr>
							<td>Adresse</td>
							<td><textarea rows="4" name="adresse"></textarea></td>
						</tr>
						<tr>
							<td>Téléphone</td>
							<td><input type="text" value="" name="tel" size=27></td>
						</tr>
						<tr>
							<td>E-mail</td>
							<td><input type="text" value="" name="email" size=27></td>
						</tr>
						<tr>
							<td colspan="2"><br></td>
						</tr>
						<tr>
							<td> Ajout de vos coordonnées<br /> dans l'annuaire <br />des membres de l'association.<br /> Oui si coché</td>
							<td><input type="checkbox" name="etat_annuaire[]" value=""></td>
						</tr>
						<tr>
							<td colspan="2" align="center"><?php dsp_crypt(0,1); ?></td>
						</tr>
						<tr>
							<td colspan="2" align="center">Recopier le code:<br><input type="text" name="code"></td>				
						</tr>
					</table>
					
					<br><input type="submit" name="submit" value="S'inscrire" onClick="verifForm(this.form)"/>
				</form>


