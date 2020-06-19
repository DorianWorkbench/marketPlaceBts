<?php
    //Début de la session
    session_start();
    //Si il existe une variable de session ayant pour valeur un idUtilisateur on déconnecte l'utilisateur et on le redirige vers la page d'accueil
    if(isset($_SESSION['idUtilisateur'])){
        session_destroy();
        //Redirection vers la page "index.php"
        header('Location: ../index.php');
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/connexion.css">
</head>
<body>
    <?php include('../static/header.php')?>
    
    <span class="erreur">Erreur lors de la saisie de vos identifiants</span>
    
    <div class="connexion">
        <span class="title_co"> Connecte-toi : </span>
        <form action="connexion.php" method="post" class="form_co">
            <input type="text" name="username" id="username" placeholder="Username" class="form_Et">
            <input type="password" name="password" id="password" placeholder="Password" class="form_Et">

            <button type="submit" class="btnConnexion" name="btnConnexion"> Connexion </button>
        </form>
    </div>
    <script type="text/javascript" src="../javascript/script.js"></script>
</body>
</html>

<?php
    //Ajout des fonction php
    include('../fonctions_php/co.php');
    
    //Ecoute du bouton btnConnexion
    if(isset($_POST['btnConnexion'])){
        //Si les champs ne sont pas remplis, nous affichons une erreur
        if($_POST['username']==null || $_POST['password']==null){
            echo "Les champs ne sont pas remplis";
        }else{//Si les champs sont remplis, nous effectuons une verification de l'existance de l'utilisateur
            //Récupération des champs saisis par l'utilisateur
            $username=$_POST['username'];
            $password=$_POST['password'];

            //Définition de la requête permettant de récuperer les données de l'utilisateur
            $querry = "SELECT * FROM utilisateur WHERE username = '$username' AND password = '$password'";
            //Préparation de la requête 
            $result = $c->prepare($querry);
            //Execution de la requête
            $result->execute();
            //Retour de la réponse à la requête sous forme de tableau
            $result = $result->fetchAll();

            //Si le tableau contient une valeur
            if(sizeof($result)==1){
                //Si l'élément du tableau a pour valeur pour le champ "type" "FO"
                if($result[0]['type']=="FO"){
                //Nous démarrons une session avec pour valeur les champs récupérés par la requête                    
                    session_start();
                    //Définition des variables de session et attribution des valeurs
                    $_SESSION['idUtilisateur']=$result[0]['idUtilisateur'];
                    $_SESSION['username']=$result[0]['username'];
                    $_SESSION['password']=$result[0]['password'];
                    $_SESSION['email']=$result[0]['email'];
                    $_SESSION['postalAdress']=$result[0]['adresse'];
                    $_SESSION['rib']=$result[0]['rib'];
                    $_SESSION['raisonSociale']=$result[0]['raisonSociale'];
                    $_SESSION['type']=$result[0]['type'];
                    header('Location: ../index_fo.php');
                }else if($result[0]['type']=="AC"){//Si l'élément du tableau a pour valeur pour le champ "type" "AC"
                    //Nous démarrons une session avec pour valeur les champs récupérés par la requête
                    session_start();
                    
                    //Définition des variables de session et attribution des valeurs
                    $_SESSION['idUtilisateur']=$result[0]['idUtilisateur'];
                    $_SESSION['username']=$result[0]['username'];
                    $_SESSION['password']=$result[0]['password'];
                    $_SESSION['email']=$result[0]['email'];
                    $_SESSION['adresse']=$result[0]['adresse'];
                    $_SESSION['rib']=$result[0]['rib'];
                    $_SESSION['type']=$result[0]['type'];
                    $_SESSION['nom']=$result[0]['nom'];
                    $_SESSION['prenom']=$result[0]['prenom'];
                    $_SESSION['paiement']=$result[0]['paiement'];
                    header('Location: ../index.php'); 
                }
            }else{//Si la taille du tableau n'est pas égale à un (nous sous entendrons donc que l'utilisateur n'existe pas).
                echo "L'utilisateur n'existe pas";
            }
        }
    }
?>