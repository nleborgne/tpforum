<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>TP HTML CSS</title>
  <link rel="stylesheet" href="style.css">

  <!-- Balises META (Référencement) -->
  <meta name="Content-Type" content="UTF-8">
  <meta name="Content-Language" content="fr">
  <meta name="Description" content="TP PHP SQL noté du 25/05/2018 encadré par M. FELLER">
  <meta name="Keywords" content="tp php sql js isep ">
  <meta name="Author" content="Nicolas Le Borgne">
  <meta name="Identifier-Url" content="index.php">
  <meta name="Revisit-After" content="15 days">
  <meta name="Robots" content="all">
  <meta name="Rating" content="general">
  <meta name="Distribution" content="global">
  <meta name="Category" content="software">

</head>

<body>
  <header>
    <img class="img_logo" src="ISEP.png" alt="">
    <ul class="liste_header">
      <li><a href="">Accueil</a></li>
      <li><a href="controller_actualites.php">Acutalités</a></li>
      <li><a href="">Ajouter un sujet</a></li>
      <li><a href="">Contact</a></li>
        <?php echo $deconnexion; ?>
    </ul>
  </header>

  <div class="nom">
      <?php echo $nom ?>
  </div>

  <h1>ISEP</h1>

  <div> <!--  Séparateur -->

    <div class="ISEP">
      <h2>École d'ingénieurs du numérique</h2>
      <p><span class="italic">Lorem ipsum dolor sit amet</span>, consectetur adipiscing elit. Etiam finibus egestas euismod. Morbi lobortis dignissim quam ac pharetra. Phasellus sed condimentum urna. Etiam eget sem sit amet turpis semper interdum ac in ipsum. Donec at massa sem. Ut vel eleifend ligula. Suspendisse ut ante sagittis, euismod libero quis, vulputate metus. Etiam vitae dapibus arcu, vel accumsan ex. Aliquam ut aliquet augue, id mattis erat. Maecenas aliquam porttitor porttitor. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque laoreet facilisis eros, id mattis sapien. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.</p>
      <ul>
        <li>Etiam finibus egestas euismod</li>
        <li>Morbi lobortis dignissim quam ac pharetra.</li>
        <li>Pellentesque laoreet facilisis eros,</li>
        <li>Vestibulum ante ipsum primis</li>
      </ul>
      <p>Vestibulum <strong>ante ipsum primis in faucibus</strong> orci luctus et ultrices posuere cubilia Cura</p>
    </div>

    <div class="inscription">
      <h2>Inscription au forum</h2>
      <form method="POST" action="index.php">
        <p>Votre nom : </p>
        <input type="text" name="nom" placeholder="Votre nom">
        <p>Votre e-mail : </p>
        <input type="text" name="email" placeholder="Votre e-mail">
        <p>Votre mot de passe : </p>
        <input type="password" name="mot_de_passe" placeholder="Votre mot de passe">
        <input class="bouton_submit" type="submit" value="Envoyer">
      </form>
      <?php if(isset($message)) {echo $message;} ?>
    </div>

      <div class="connexion">
          <h2>Connexion au forum</h2>
          <form action="index.php" method="post">
              <p>Votre e-mail : </p>
              <input type="text" name="email_connexion" placeholder="Votre e-mail">
              <p>Votre mot de passe : </p>
              <input type="password" name="mot_de_passe_connexion" placeholder="Votre mot de passe">
              <input type="submit" class="bouton_submit" value="Envoyer">
          </form>
          <?php if(isset($messageConnexion)) {echo $messageConnexion;} ?>
      </div>

  </div>

  <div> <!-- Séparateur -->

    <div class="poster_sujet">
      <h2>Poster un nouveau sujet</h2>
      <form method="POST" action="index.php" id="newsForm">
        <p>Votre sujet:</p>
        <textarea name="contenuSujet" form="newsForm" rows="10" cols="65"></textarea>
        <p>Catégorie:</p>
        <select name="categorie" id="">
          <?php while ($dataCategorie = $categories->fetch()) {
            echo "<option value='" . $dataCategorie['ID'] . "'>".$dataCategorie['nom_categorie'] . "</option>";
          } ?>
        </select>
        <input type="submit" class="bouton_submit" name="validerPostSujet" value="Envoyer">
      </form>
    </div>

    <!-- Liste des sujets -->
    <div class="liste_sujets">
      <h2>Sujets en cours</h2>
      <?php
      while($data = $news->fetch()) {
        echo "<p>".htmlspecialchars($data["contenu_news"])."<br>";
        echo '<span class="italic">Posté par </span><strong>'.htmlspecialchars($data['nom']).'</strong> le <span class="italic">'.htmlspecialchars($data['date_message']).'</span></p>';
      }
      ?>
    </div>
  </div>

</body>
</html>

<!-- Nicolas LE BORGNE, G9C -->
