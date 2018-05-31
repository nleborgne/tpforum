<?php
session_start();

require('modele.php');

$count = getNbreArticles();
$nbreArticles = $count->fetch();

for ($i = 1; $i <= $nbreArticles['count(ID)']; $i++) {
  if(isset($_POST['validerForm'.$i])) {
    echo $_POST['contenu'];
    ajoutCommentaire($_POST['ID_news'], $_SESSION['ID'], date('Y-m-d'), $_POST["contenu"]);
    header('Location: controller_actualites.php');
  }
}
