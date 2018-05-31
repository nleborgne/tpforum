<?php

// Connexion à la base de données via PDO
try {
  $bdd = new PDO('mysql:host=localhost;dbname=tpforum;charset=utf8', 'root', '');
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

// Fonction pour voir les news (page 1)
function getNews()
{
  global $bdd;
  $get = $bdd->query('SELECT *, messages.contenu AS contenu_news, messages.date AS date_message from messages INNER JOIN personne ON messages.ID_utilisateur = personne.ID ORDER BY messages.date DESC');
  return $get;
}

// Fonction qui retourne l'ID d'un utilisateur en fonction de son email
function getID($email)
{
  global $bdd;
  $get = $bdd->prepare('SELECT ID from personne WHERE email = ?');
  $get->execute(array($email));
  return $get->fetch();
}

// Fonction qui retourne le nom d'un utilisateur en fonction de son email
function getNom($email)
{
  global $bdd;
  $get = $bdd->prepare('SELECT nom from personne WHERE email = ?');
  $get->execute(array($email));
  return $get->fetch();
}

// Fonction pour poster une news
function posterNews($ID_utilisateur, $date, $contenu,$categorie)
{
  global $bdd;
  $news = $bdd->prepare('INSERT INTO messages(ID_utilisateur,date,contenu,ID_categorie) VALUES(:ID_utilisateur, :date, :contenu,:categorie)');
  $news->bindParam('ID_utilisateur', $ID_utilisateur, PDO::PARAM_INT);
  $news->bindParam('date', $date, PDO::PARAM_STR);
  $news->bindParam('contenu', $contenu, PDO::PARAM_STR);
  $news->bindParam('categorie', $categorie, PDO::PARAM_STR);
  $news->execute();
  //header('Refresh:0');
}

// Fonction qui vérifie si un compte est déjà dans la BDD
function verifEmail($email)
{
  global $bdd;
  $verify = $bdd->prepare('SELECT email FROM personne WHERE email = ?');
  $verify->execute(array($email));
  $data = $verify->fetch();
  if ($data > 0) {
    return false;
  } else {
    return true;
  }
}

// Fonction pour créer un compte
function creerCompte($nom, $email, $pass)
{
  global $bdd;
  $hash = password_hash($pass, PASSWORD_DEFAULT);
  $compte = $bdd->prepare('INSERT INTO personne(nom,email,mot_de_passe) VALUES(:nom,:email,:mot_de_passe)');
  $compte->bindParam('nom', $nom, PDO::PARAM_STR);
  $compte->bindParam('email', $email, PDO::PARAM_STR);
  $compte->bindParam('mot_de_passe', $hash, PDO::PARAM_STR);
  $compte->execute();
}

// Fonction qui teste la connexion
function testConnexion($email, $pass)
{
  global $bdd;
  $connexion = $bdd->prepare('SELECT * from personne WHERE email = ?');
  $connexion->execute(array($email));
  $data = $connexion->fetch();
  if (password_verify($pass, $data['mot_de_passe'])) {
    // Connexion bonne
    return $data['ID'];
  } else {
    // Connexion fausse
    return false;
  }
}

// Fonction qui récupère les commentaires
function getCommentaires($id)
{
  global $bdd;
  $get = $bdd->prepare('SELECT * FROM commentaire INNER JOIN personne ON commentaire.ID_utilisateur = personne.ID WHERE ID_message = ?');
  $get->execute(array($id));
  return $get;
}

// Fonction ajoutant un commentaire
function ajoutCommentaire($ID_message, $ID_utilisateur, $date, $contenu)
{
  global $bdd;
  $commentaire = $bdd->prepare('INSERT INTO commentaire(ID_message,ID_utilisateur,date,contenu) VALUES(:ID_message, :ID_utilisateur, :date, :contenu)');
  $commentaire->bindParam('ID_message', $ID_message, PDO::PARAM_INT);
  $commentaire->bindParam('ID_utilisateur', $ID_utilisateur, PDO::PARAM_INT);
  $commentaire->bindParam('date', $date, PDO::PARAM_STR);
  $commentaire->bindParam('contenu', $contenu, PDO::PARAM_STR);
  $commentaire->execute();
}

// On récupère les auteurs
function getAuteurs() {
  global $bdd;
  $get = $bdd->query('SELECT DISTINCT personne.nom, personne.ID from messages INNER JOIN personne ON messages.ID_utilisateur = personne.ID');
  return $get;
}
// On récupère les catégories
function getCategories() {
  global $bdd;
  $get = $bdd->query('SELECT * from categories');
  return $get;
}

// On récupère le nombre d'articles
function getNbreArticles() {
  global $bdd;
  $get = $bdd->query('SELECT ID, count(ID) FROM messages');
  return $get;
}

// fonction qui tri les articles
function tri($id,$categorie,$date) {
  global $bdd;
  // Cas où on choisit un auteur mais pas de catégorie
  if($id > 0 && $categorie == 0 && $date=="") {
    $get = $bdd->prepare('SELECT * FROM (SELECT DISTINCT messages.ID AS ID_news, messages.date AS date_message, messages.contenu AS contenu_news, commentaire.date AS date_rep, commentaire.contenu AS contenu_rep, categories.ID, categories.nom_categorie ,messages.ID_categorie, nom FROM messages LEFT JOIN commentaire ON commentaire.ID_message = messages.ID LEFT JOIN personne ON messages.ID_utilisateur = personne.ID INNER JOIN categories ON messages.ID_categorie = categories.ID WHERE messages.ID_utilisateur = ? ORDER BY commentaire.date DESC) AS subquery GROUP BY ID_news ORDER BY subquery.date_rep DESC');
    $get->execute(array($id));
    return $get;

    // Cas où on choisit un auteur et une catégorie
  }else if($id > 0 && $categorie > 0 && $date == "") {
    $get = $bdd->prepare('SELECT * FROM (SELECT DISTINCT messages.ID AS ID_news, messages.date AS date_message, messages.contenu AS contenu_news, commentaire.date AS date_rep, commentaire.contenu AS contenu_rep, categories.ID, categories.nom_categorie, messages.ID_categorie, nom FROM messages LEFT JOIN commentaire ON commentaire.ID_message = messages.ID LEFT JOIN personne ON messages.ID_utilisateur = personne.ID INNER JOIN categories ON messages.ID_categorie = categories.ID WHERE (messages.ID_utilisateur = ? AND categories.ID = ?) ORDER BY commentaire.date DESC) AS subquery GROUP BY ID_news ORDER BY subquery.date_rep DESC');
    $get->execute(array($id,$categorie));
    return $get;

    // Cas où on choisit ni auteur, ni catégorie (defaut)
  } else if($id == 0 && $categorie == 0 && $date=="") {
    $get = $bdd->query('SELECT * FROM (SELECT DISTINCT messages.ID AS ID_news, messages.date AS date_message, messages.contenu AS contenu_news, commentaire.date AS date_rep, commentaire.contenu AS contenu_rep, categories.ID, categories.nom_categorie, nom FROM messages LEFT JOIN commentaire ON commentaire.ID_message = messages.ID LEFT JOIN personne ON messages.ID_utilisateur = personne.ID INNER JOIN categories ON messages.ID_categorie = categories.ID ORDER BY commentaire.date DESC) AS subquery GROUP BY ID_news ORDER BY subquery.date_rep DESC');
    return $get;
    // Cas où on choisit une catégorie mais pas d'auteur
  } else if($id == 0 && $categorie > 0) {
    $get = $bdd->prepare('SELECT * FROM (SELECT DISTINCT messages.ID AS ID_news, messages.date AS date_message, messages.contenu AS contenu_news, commentaire.date AS date_rep, commentaire.contenu AS contenu_rep, categories.ID, categories.nom_categorie, messages.ID_categorie, nom FROM messages LEFT JOIN commentaire ON commentaire.ID_message = messages.ID LEFT JOIN personne ON messages.ID_utilisateur = personne.ID INNER JOIN categories ON messages.ID_categorie = categories.ID WHERE ( categories.ID = ?) ORDER BY commentaire.date DESC) AS subquery GROUP BY ID_news ORDER BY subquery.date_rep DESC');
    $get->execute(array($categorie));
    return $get;

    // pas d'auteur, pas de catégorie, juste une date
  } else if($id == 0 && $categorie == 0 && $date!="") {
    $get = $bdd->prepare('SELECT * FROM (SELECT DISTINCT messages.ID AS ID_news, messages.date AS date_message, messages.contenu AS contenu_news, commentaire.date AS date_rep, commentaire.contenu AS contenu_rep, categories.ID, categories.nom_categorie, messages.ID_categorie, nom FROM messages LEFT JOIN commentaire ON commentaire.ID_message = messages.ID LEFT JOIN personne ON messages.ID_utilisateur = personne.ID INNER JOIN categories ON messages.ID_categorie = categories.ID WHERE ( messages.date < ?) ORDER BY commentaire.date DESC) AS subquery GROUP BY ID_news ORDER BY subquery.date_rep DESC');
    $get->execute(array($date));
    return $get;

    //auteur, pas de caté,date
  } else if($id > 0 && $categorie == 0 && $date!=""){
    $get = $bdd->prepare('SELECT * FROM (SELECT DISTINCT messages.ID AS ID_news, messages.date AS date_message, messages.contenu AS contenu_news, commentaire.date AS date_rep, commentaire.contenu AS contenu_rep, categories.ID, categories.nom_categorie, messages.ID_categorie, nom FROM messages LEFT JOIN commentaire ON commentaire.ID_message = messages.ID LEFT JOIN personne ON messages.ID_utilisateur = personne.ID INNER JOIN categories ON messages.ID_categorie = categories.ID WHERE ( messages.ID_utilisateur = ? AND messages.date < ?) ORDER BY commentaire.date DESC) AS subquery GROUP BY ID_news ORDER BY subquery.date_rep DESC');
    $get->execute(array($id,$date));
    return $get;

    // pas d'auteur, caté, date
  } else if($id == 0 && $categorie > 0 && $date!="") {
    $get = $bdd->prepare('SELECT * FROM (SELECT DISTINCT messages.ID AS ID_news, messages.date AS date_message, messages.contenu AS contenu_news, commentaire.date AS date_rep, commentaire.contenu AS contenu_rep, categories.ID, categories.nom_categorie, messages.ID_categorie, nom FROM messages LEFT JOIN commentaire ON commentaire.ID_message = messages.ID LEFT JOIN personne ON messages.ID_utilisateur = personne.ID INNER JOIN categories ON messages.ID_categorie = categories.ID WHERE ( categories.ID = ? AND messages.date < ?) ORDER BY commentaire.date DESC) AS subquery GROUP BY ID_news ORDER BY subquery.date_rep DESC');
    $get->execute(array($categorie,$date));
    return $get;

    // Tous les champs remplis
  } else if($id > 0 && $categorie > 0 && $date !="") {
    $get = $bdd->prepare('SELECT * FROM (SELECT DISTINCT messages.ID AS ID_news, messages.date AS date_message, messages.contenu AS contenu_news, commentaire.date AS date_rep, commentaire.contenu AS contenu_rep, categories.ID, categories.nom_categorie, messages.ID_categorie, nom FROM messages LEFT JOIN commentaire ON commentaire.ID_message = messages.ID LEFT JOIN personne ON messages.ID_utilisateur = personne.ID INNER JOIN categories ON messages.ID_categorie = categories.ID WHERE ( messages.ID_utilisateur = ? AND categories.ID = ? AND messages.date < ?) ORDER BY commentaire.date DESC) AS subquery GROUP BY ID_news ORDER BY subquery.date_rep DESC');
    $get->execute(array($id, $categorie,$date));
    return $get;
  }
}
