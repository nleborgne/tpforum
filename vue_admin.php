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
        <li><a href="index.php">Accueil</a></li>
        <li><a href="">Acutalités</a></li>
        <li><a href="">Ajouter un sujet</a></li>
        <li><a href="">Contact</a></li>
        <?php echo $deconnexion; ?>
    </ul>
</header>

<div class="nom">
    <?php echo $nom; ?>
</div>

<h1>Actualités | ISEP</h1>

<div> <!--  Séparateur -->

    <!-- Liste des actualités -->
    <div class="liste_sujets">
        <?php
        $i = 0;
        while ($data = $news->fetch()) {
            echo '<form action="modifierSujet.php" method="post" id="formModifierSujet">';
            $i+=1;
            $id = $data['ID'];

            //echo '<textarea name="name'.$id.'" cols="50" rows="10" form="formModifierSujet" >'.htmlspecialchars($data['contenu_news']).'</textarea> <br>';
            echo '<input style="width:300px" name="name'.$id.'" value="'.htmlspecialchars($data["contenu_news"]).'"><br>';
            echo "<input type='text' style='display:none;' name='ID' value ='" . $id . "'>";
            echo '<span class="italic">Posté par </span><strong>' . htmlspecialchars($data['nom']) . '</strong> le <span class="italic">' . htmlspecialchars($data['date_message']) . '</span></p>';
            echo '<span class="italic">Catégorie : </span><strong>' . htmlspecialchars($data['nom_categorie']) .'</span></strong></p>';
            echo '<input class="bouton_submit" type="submit" name="modifSujet'.$id.'" value="Modif">';
            echo '</form>';
            // La ligne suivante n'est pas censée se trouver dans la vue, or je n'ai pas trouvé le moyen de la placer dans le controleur.
            $commentaire = getCommentaires($data['ID_news']);
            echo '<form action="" method="post" id="formAjoutCommentaire">';
            while ($dataCommentaire = $commentaire->fetch()) {
                echo '<p> >> ' . htmlspecialchars($dataCommentaire['contenu']) . '</p>';
                echo '<span class="italic">Posté par </span><strong>' . htmlspecialchars($dataCommentaire['nom']) . '</strong> le <span class="italic">' . htmlspecialchars($dataCommentaire['date']) . '</span></p>';
            }
            echo "</form>";
        }
        ?>
    </div>
    <div class="poster_sujet">
        <h2>Filtrer :</h2>
        <form method="POST" action="controller_actualites.php" id="newsForm">
            <p>Par auteur du sujet :</p>
            <select name="auteurs" id="">
                <option value="0">Tous (<?php echo $nbreAuteurs['count(distinct(ID_utilisateur))']?>)</option>
                <?php while ($dataAuteurs = $auteurs->fetch()) {
                    echo "<option value='" . $dataAuteurs['ID'] . "'>" . $dataAuteurs['nom'] . "</option>";
                } ?>
            </select>
            <p>Par catégorie :</p>
            <select name="categorie" id="">
                <option value="0">Toutes</option>
                <?php while ($dataCategorie = $categories->fetch()) {
                    echo "<option value='" . $dataCategorie['ID'] . "'>".$dataCategorie['nom_categorie'] . "</option>";
                } ?>
            </select>
            <p>Articles postérieurs à la date</p>
            <input type="date" name="date">
            <input type="submit" class="bouton_submit" name="validerTrier" value="Filtrer">
        </form>
    </div>
</div>
</body>
</html>

<!-- Nicolas LE BORGNE, G9C -->
