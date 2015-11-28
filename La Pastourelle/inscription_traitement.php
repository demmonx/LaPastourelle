<?php

require_once 'traitement.inc.php';
/* on vérifie le captcha */
if (! (isset($_POST['g-recaptcha-response']) &&  verifCaptcha($_SERVER, $_POST['g-recaptcha-response']))) {
    exit("Code de validation incorrect");
}

// Go essayer

$prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
$nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
$pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS);
$mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_SPECIAL_CHARS);
$adresse = filter_input(INPUT_POST, 'adresse', FILTER_SANITIZE_SPECIAL_CHARS);
$tel = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);
$mail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

/* si une erreur sur les champs */
if (! $prenom || ! $nom || ! $pseudo || ! $mdp || ! $adresse || ! $tel || ! $mail) {
    // génération du tableau des erreurs
    $erreur = array(
            array()
    );
    $erreur[0][0] = $prenom;
    $erreur[0][1] = "Le prénom est invalide";
    $erreur[1][0] = $nom;
    $erreur[1][1] = "Le nom est invalide";
    $erreur[2][0] = $pseudo;
    $erreur[2][1] = "Le pseudo est invalide";
    $erreur[3][0] = $mdp;
    $erreur[3][1] = "Le mot de passe est invalide";
    $erreur[4][0] = $adresse;
    $erreur[4][1] = "L'adresse est invalide";
    $erreur[5][0] = $tel && is_numeric($tel) && strlen($tel) == 10;
    $erreur[5][1] = "Le téléphone est invalide";
    $erreur[6][0] = $mail;
    $erreur[6][1] = "L'adresse mail est invalide";
    
    // Affichage de la première erreur trouvée
    for ($i = 0; $i < count($erreur); $i ++)
        if (! $erreur[$i][0])
            exit($erreur[$i][1]);
}

if (inscriptionBDD($_POST)) {
    exit("L'inscription a bien été enregistrée");
} else {
    exit("Un membre avec le même pseudo existe déjà");
}

?>
