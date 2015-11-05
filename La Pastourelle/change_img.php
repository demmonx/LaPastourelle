<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	redirect("index.php?page=accueil", 3);
	exit(0);
} else {?>
	<script language="Javascript" type="text/javascript" >
	function choix(formulaire) {
		var j;
		var i = formulaire.page_photo.selectedIndex;
		if (i == 0)
			for(j = 1; j <3; j++)
				formulaire.photo.options[j].text="";
		else{
			switch (i){
				case 1 : var text = new Array( "danse1","danse2","danse3","danse4","danse5","danse6");break;
				case 2 : var text = new Array( "theatre1","theatre2","theatre3","theatre4","theatre5","theatre6");break;
				case 3 : var text = new Array( "ecole1","ecole2","ecole3","ecole4");break;
				case 4 :var text = new Array( "histo1","histo2","histo3","histo4","histo5");break;
			}
			for(j = 0; j<text.length; j++)
			formulaire.photo.options[j+1].text=text[j];
		}
		formulaire.photo.selectedIndex=0;
	}
	</script>

	<?php require_once ("upload.php");
	if ( isset($_FILES['fichier_choisi'])and isset($_POST["repertoire"]) and isset($_POST["nom"])) {
		transfert();
		$_POST["page_photo"] = "";
		$_POST["photo"] = "";
	}?> 
	<br><br><br>
	<CENTER>
		<form class="form-horizontal" name="formulaire" method="POST" enctype="multipart/form-data" action="index.php?page=change_img">
			Choisissez une page : 
			<select class="span2" name="page_photo" onChange="choix(this.form)">
				<option></option>
				<option>danse</option>
				<option>theatre</option>
				<option>ecole</option>
				<option>historique</option>
			</select>
			
			Choisissez une photo :
			<select class="span2"  name="photo">
				<option></option>
				<option></option>
				<option></option>
				<option></option>
				<option></option>
				<option></option>
				<option></option>
			</select>
			<INPUT  class="btn btn-info" type="submit" value="Selectionner"><br>
		<?php
		if (isset($_POST["page_photo"]) and isset($_POST["photo"]) 
			and !empty($_POST["page_photo"]) and ($_POST["photo"])){
			
			echo '<br>Page choisie : <b>'.$_POST["page_photo"].'</b> Photo : <b>'.$_POST["photo"].'</b><br><br>';
			echo '
		 <input type="hidden" name="repertoire" value="'.$_POST["page_photo"].'">
		 <input type="hidden" name="nom" value="'.$_POST["photo"].'">
		 Fichier : <input type="file" name="fichier_choisi" size="90">
		 <br><i>* l\'image doit être de type jpg (ex : image.jpg) </i>
		 <br><br>
		 <input type="submit" name="envoyer" value="Enregistrer ce fichier">
		';
		}
		echo "
		<BR><BR>
		<CENTER>
			<A class='btn btn-link' HREF='index.php?page=page_administrateur'>Retour à la page précédente</A>
		</CENTER>
		</form>
	</CENTER>";
}?>