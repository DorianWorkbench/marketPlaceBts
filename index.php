<?php
//Démarrage de la session me permettant d'effectué un test sur les variables de celle-ci
session_start();
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
    <link rel="stylesheet" href="css/indexHome.css">
</head>
<body>
    <?php include('static/header.php');?>
    <div class="container_all">
      
      <div class="containerArt">
        <?php
                $array = tableauAllArticles();
                if(!(empty($array[0]['nomArticle']))){
                  echo "<table>";
                  echo "<tr>";
                  echo "<th>Article</th>";
                  echo "<th>Catégorie</th>";
                  echo "<th>Prix</th>";
                  echo "<th>Quantité</th>";
                  echo "<th>acheter</th>";
                  echo "</tr>";
                  echo "<form action=\"pages/detailArticle.php\" method=\"post\">";
                for($i=0; $i<sizeof($array); $i++){
                  echo "<tr>";  ²
                  echo "<td align=\"center\">".$array[$i]['nomArticle']."</td>";
                  echo "<input type=\"hidden\" name=\"nomArticle\" value=\"".$array[$i]['nomArticle']."\">";
                  echo "<td align=\"center\">".$array[$i]['cat']."</td>";
                  echo "<td align=\"center\">".$array[$i]['prix']." €</td>";
                  echo "<td align=\"center\">".$array[$i]['stock']."</td>";
                  echo "<td align=\"center\"><button type=\"submit\" class=\"btnAcheter\" name=\"Acheter\">Acheter</button></td>";
                }
                echo "</form>";
                echo "</table>";
              }else{
                echo "<span class=\"article\">Il n'y a aucun article en boutique</span>";
              }
        ?>
      </div>
    </div>
</body>
</html>