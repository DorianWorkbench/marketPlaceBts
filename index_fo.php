<?php
//Démarrage de la session me permettant d'effectué un test sur les variables de celle-ci
session_start();
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
</head>
<body>
    <?php include('static/header.php')?>
</body>
</html>