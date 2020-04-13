<?php
//Démarrage de la session me permettant d'effectué un test sur les variables de celle-ci
session_start();

include('fonctions_php/co.php');
include('fonctions_php/fonctions.php');

//Test pour savoir si l'utilisateur est connecté, si non, ferme la session
if(!isset($_SESSION['idUtilisateur'])){
  session_destroy();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index_fo.css">
</head>
<body>
    <?php include('static/header.php')?>
    <div class="container_all">
      <div class="containerArt">
        <?php
            $array = tableauArticles($_SESSION['raisonSociale']);
            if(!(empty($array[0]['nomArticle']))){
            echo "<table>";
            echo "<tr>";
            echo "<th>Article</th>";
            echo "<th>Catégorie</th>";
            echo "<th>Raison sociale</th>";
            echo "<th>Prix</th>";
            echo "<th>Quantité</th>";
            echo "<th>Modifier</th>";
            echo "</tr>";

            for($i=0; $i<sizeof($array); $i++){
              echo "<tr>";
              echo "<td align=\"center\">".$array[$i]['nomArticle']."</td>";
              echo "<td align=\"center\">".$array[$i]['cat']."</td>";
              echo "<td align=\"center\">".$array[$i]['raisonSociale']."</td>";
              echo "<td align=\"center\">".$array[$i]['prix']." €</td>";
              echo "<td align=\"center\">".$array[$i]['stock']."</td>";
              echo "<td align=\"center\"><button type=\"submit\" class=\"btnModif\">Modifier</button></td>";
            }
            echo "</table>";
          }else{
            echo "<span class=\"article\">Vous n'avez ajouté aucun article</span>";
          }
          ?>
      </div>
    </div>
    
</body>
</html>