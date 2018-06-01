<?php

session_start();

require('modele.php');

$count = getNbreArticles();
$nbreArticles = $count->fetch();

echo $_POST['name' . $_POST['ID']];
modifierSujet($_POST['ID'],$_SESSION['ID'],"2018-06-01",$_POST['name'.$_POST['ID']],1);
