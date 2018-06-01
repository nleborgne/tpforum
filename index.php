<?php
// Affichage 'non connecté'
if(!isset($_SESSION)) {
  session_start();
  $nom = " ";
}

// Affichage 'bonjour"
if(isset($_SESSION['ID'])){
  $nom = "Bonjour ".$_SESSION['nom'];
}
// Appel du modèle
require('modele.php');

// Voir les différentes news
$news = getNews();

// Bouton deconnexion
if(isset($_SESSION['ID'])) {
  $deconnexion = "<li><a href='disconnect.php'>Déconnexion</a></li>";
} else {
  $deconnexion = "";
}

$categories = getCategories();
// Poster une news
if (isset($_POST["validerPostSujet"])) {
  // Dans un premier temps on teste la connexion
  echo'on poste une news';
  posterNews($_SESSION['ID'],date('Y-m-d'),$_POST['contenuSujet'],$_POST['categorie']);
}

// Connexion de l'utilisateur
if (!empty($_POST['email_connexion']) && !empty($_POST['mot_de_passe_connexion'])) {
  if (testConnexion($_POST['email_connexion'], $_POST['mot_de_passe_connexion']) != false) {
    // Test réussi, utilisateur connecté
    session_destroy();
    session_start();

    // On définit les variables de session
    $dataID = getID($_POST['email_connexion']);
    $_SESSION['ID'] = $dataID['ID'];

    $dataNom = getNom($_POST['email_connexion']);
    $_SESSION['nom'] = $dataNom['nom'];
    header('Refresh:0');
    $messageConnexion= "Vous êtes connecté !";
  } else {
    $messageConnexion =  "Email ou mot de passe incorrect";
  }
}

// Vérification inscription
if (!empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['mot_de_passe'])) {
  if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    if(strlen($_POST['mot_de_passe']) >= 5) {
      if(verifEmail($_POST['email'])) {
        creerCompte($_POST['nom'],$_POST['email'],$_POST['mot_de_passe']);
        $message = "Compte créé avec succès !";
      } else {
        $message = "Cette adresse mail est déjà utilisée";
      }
    } else {
      $message = "Mot de passe trop court (min 5 caractères)";
    }
  } else {
    $message = "Email non valide";
  }
}

// Appel de la vue
require('vue.php');
