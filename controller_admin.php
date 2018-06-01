<?php
$nom = "Administration";

// Bouton deconnexion
if (isset($_SESSION['ID'])) {
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

if (isset($_POST["validerTrier"])) {
    $news = tri($_POST['auteurs'], $_POST['categorie'], $_POST['date']);
} else {
    $news = tri(0, 0, "");
}
require('vue_admin.php');
