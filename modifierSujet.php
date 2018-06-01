<?php

session_start();

require('modele.php');

$count = getNbreArticles();
$nbreArticles = $count->fetch();

echo $_POST['name' . $_POST['ID']];
modifierSujet($_POST['ID'], $_SESSION['ID'], $_POST['date' . $_POST['ID']], $_POST['name' . $_POST['ID']], 1);
header('Location: controller_admin.php');

