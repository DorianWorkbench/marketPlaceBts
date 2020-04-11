<?php
    session_start();
    if(isset($_SESSION['idUtilisateur'])){
        session_destroy();
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
    
    <div class="container_all">
    <div class="erreur" id="erreur">
            <span>Erreur lors de la saisie de vos identifiants</span>
    </div>
        <div class="connexion">
            <span class="title_co"> Connecte toi : </span>
            <form action="connexion.php" method="post" class="form_co">
                <input type="text" name="username" id="username" placeholder="Username" class="form_Et">
                <input type="password" name="password" id="password" placeholder="Password" class="form_Et">

                <button type="submit" class="btnConnexion" name="btnConnexion"> Connexion </button>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="../javascript/script.js"></script>
</body>
</html>

<?php
    include('../fonctions_php/co.php');
    if(isset($_POST['btnConnexion'])){
        if($_POST['username']==null || $_POST['password']==null){
            echo "<script>erreur()</script>";
        }else{
            $username=$_POST['username'];
            $password=$_POST['password'];

            $querry = "SELECT * FROM utilisateur WHERE username = '$username' AND password = '$password'";
            $result = $c->prepare($querry);
            $result->execute();
            $result = $result->fetchAll();

            if(sizeof($result)==1){
                if($result[0]['type']=="FO"){
                    //Integer nUtilisateur, String username, String password, String email, String postalAddress, String rib, String raisonSociale
                    
                    session_start();
                    
                    $_SESSION['idUtilisateur']=$result[0]['idUtilisateur'];
                    $_SESSION['username']=$result[0]['username'];
                    $_SESSION['password']=$result[0]['password'];
                    $_SESSION['email']=$result[0]['email'];
                    $_SESSION['postalAdress']=$result[0]['adresse'];
                    $_SESSION['rib']=$result[0]['rib'];
                    $_SESSION['raisonSociale']=$result[0]['raisonSociale'];
                    $_SESSION['type']=$result[0]['type'];
                    header('Location: ../index_fo.php');
                //String username, String password, String email, String postalAddress, String rib,String surname, String name, Integer sexe, String paiement, Integer nUtilisateur
                }else if($result[0]['type']=="AC"){

                    session_start();

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
            }else{
                echo "<script>erreur();</script>";
            }
        }
    }
?>