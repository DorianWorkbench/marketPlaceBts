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
    <title>Inscription</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/inscription.css">
</head>
<body>
    <?php include('../static/header.php')?>

        <div class="erreur" id="erreur">
            <span>Erreur lors de la saisie des champs</span>
        </div>
        <div class="container_insc">

            <span class="title_insc">Inscription :</span>

            <form action="inscription.php" method="post" class="form">
                
                <input type="text" id="username" name="username" class="form_ET" placeholder="Username"></input>
                <input type="password" id="password" name="password" class="form_ET" placeholder="Password"></input>

                <div class="sexeContainer">
                    <div class="Masculin">
                        <input type="radio" name="sexe" id="Masculin" value="M">
                        <label for="Masculin">M</label>
                    </div>
                    <div class="Feminin">
                        <input type="radio" name="sexe" id="Feminin" value="F">
                        <label for="Feminin">F</label>
                    </div>
                </div>

                <input type="email" id="email" name="email" class="form_ET" placeholder="Email"></input>
                <input type="text" id="nom" name="nom" class="form_ET" placeholder="Nom"></input>
                <input type="text" id="prenom" name="prenom" class="form_ET" placeholder="Prenom"></input>
                <input type="text" id="rib" name="rib" class="form_ET" placeholder="Rib"></input>
                <input type="text" id="adresse" name="adresse" class="form_ET" placeholder="Adresse postale"></input>
                
                <button type="submit" class="btnSubscribe" name="btnSubscribe" value="btnSubscribe"> S'inscrire </button>
                
                <a href="inscriptionFo.php" class="fournisseur"> Vous êtes fournisseur ?</a>

            </form>
        </div>
    <script type = "text/javascript" src = "../javascript/script.js"></script>
</body>
</html>
<?php
    include('../fonctions_php/co.php');
    if(isset($_POST['btnSubscribe'])){

        if($_POST['username']==null || $_POST['password']==null || 
           !isset($_POST['sexe']) || $_POST['email']==null || 
           $_POST['nom']==null || $_POST['prenom']==null || 
           $_POST['rib']==null || $_POST['adresse']==null){

            echo "<script>erreur();</script>";

        }else{

            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $adresse= $_POST['adresse'];
            $type = "AC";
            $paiement = "Carte Bancaire";
            $sexe = $_POST['sexe'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $rib = $_POST['rib'];

           //Création de la requête de test pour savoir si l'utilisateur existe.

            $verif = "SELECT username FROM utilisateur WHERE username = '$username'";
            $req = $c -> prepare($verif);
            $req->execute();
            $rep = $req->fetchAll();

            //Si le tableau de la requête précédente est supérieur à 0, cela voudra dire que l'utilisateur existe déjà.
            if(sizeof($rep)==0){

                //Création de la requête de création de l'utilisateur.
                $query = "INSERT INTO utilisateur(username, password, email, adresse, type, paiement, sexe, nom, prenom, rib)
                VALUES('$username', '$password', '$email', '$adresse', '$type', '$paiement', '$sexe', '$nom', '$prenom', '$rib')";
               //Execution de la requête d'inscription.
               $c->exec($query);
               header('Location: ../index.php'); 
            }else{
                echo "L'utilisateur existe déjà";
            }
        }
    }
?>
