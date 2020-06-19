<?php
//Démarrage de la session me permettant d'effectué un test sur les variables de celle-ci
session_start();
include('fonctions_php/fonctions.php');

//Vérifie si l'utilisateur est du bon type et si un utilisateur est connecté
if($_SESSION['type']=='FO'){
  header('Location: index_fo.php');
}
if(isset($_POST['deco'])){
  session_destroy();
  $delay=0;
  $url="http://localhost/marketplace_pro/index.php";
  header("Refresh: $delay, url=$url");
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
  <h1 class="trends">Articles :</h1>
    <div class="containerArt">
      <div class="containerTrend">
      
        <?php
          $array = tableauAllArticles();
          if(sizeof($array)==0){
            echo "<span class=\"article\">Pas d'article</span>";
          }
          else{
            for($i=0; $i< sizeof($array); $i++){
              echo "<form action=\"pages/detailArticle.php\" method=\"post\">";
              echo "<input type=\"hidden\" name=\"nArticle\" value=".$array[$i]['nArticle'].">";
                echo "<div class=\"containerArticle\">";
                  echo "<div class=\"nomArticle\">";
                    echo ucfirst(strtolower($array[$i]['nomArticle'])); 
                  echo "</div>";
                  echo "<div class=\"prixArticle\">";
                    echo $array[$i]['prix']." €";
                  echo "</div>";
                  echo "<div class=\"qteArticle\">";
                    echo $array[$i]['stock']. " pièces";
                  echo "</div>";
                  echo "<div class=\"acheter\">";
                  if(!isset($_SESSION['idUtilisateur'])){
                  }else{
                    echo "<button class=\"btnAcheter\" type=\"submit\" name=\"acheter\">Acheter</button>";
                  }
                  echo "</div>";
                echo "</div>";
              echo "</form>";
            }
          }
        ?>
      </div>
    </div>
</body>
</html>