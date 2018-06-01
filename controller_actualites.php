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
// Bouton deconnexion
if(isset($_SESSION['ID'])) {
  $deconnexion = "<li><a href='disconnect.php'>Déconnexion</a></li>";
} else {
  $deconnexion = "";
}

require('modele.php');

// Voir les auteurs
$auteurs = getAuteurs();
$nbreAuteurs = getNbreAuteurs();
// Voir les acutalités
$categories = getCategories();
// Trier
//$tri = trier();
if(isset($_POST["validerTrier"])) {
  echo $_POST['auteurs'];
  echo $_POST['categorie'];
  echo $_POST['date'];
  $news = tri($_POST['auteurs'], $_POST['categorie'],$_POST['date']);
} else {
  $news = tri(0,0,"");
}

require('vue_actualites.php');
