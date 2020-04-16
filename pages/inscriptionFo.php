<!DOCTYPE html>
<?php
    session_start();
    if(isset($_SESSION['idUtilisateur'])){
        session_destroy();
        header('Location: ../index.php');
    }
?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Fournisseur</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/inscription.css">
</head>
<body>
    <?php include('../static/header.php')?>
    
    <div class="erreur" id="erreur">
            <span>Erreur lors de la saisie des champs</span>
        </div>
        <div class="container_insc">
            <span class="title_insc">Inscription fournisseur :</span>
            <form action="inscriptionFo.php" method="post" class="formFo">
                <input type="text" id="username" name="username" class="form_ET" placeholder="Username"></input>
                <input type="password" id="password" name="password" class="form_ET" placeholder="Password"></input>
                <input type="email" id="email" name="email" class="form_ET" placeholder="Email"></input>
                <input type="text" id="rib" name="rib" class="form_ET" placeholder="Rib"></input>
                <input type="text" id="adresse" name="adresse" class="form_ET" placeholder="Adresse postale"></input>
                <input type="text" id="rs" name="rs" class="form_ET" placeholder="Raison Sociale"></input>
                <button type="submit" class="btnSubscribe" name="btnSubscribe"> S'inscrire </button>
                <button type="submit" class="btnRetour" name="retour">Retour</buton>
            </form>
        </div>
    <script type = "text/javascript" src = "../javascript/script.js"></script>
</body>
</html>

<?php
    include('../fonctions_php/co.php');

    if(isset($_POST['btnSubscribe'])){

        if($_POST['username'] == null || $_POST['password'] == null || 
           $_POST['email'] == null || $_POST['rib']==null || 
           $_POST['adresse']==null || $_POST['rs'] == null || $_POST['rs']==null){

            echo "<script>erreur();</script>";

        }else{

            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $adresse= $_POST['adresse'];
            $type = "FO";
            $rib = $_POST['rib'];
            $raisonSociale = $_POST['rs'];

           //Création de la requête de test pour savoir si l'utilisateur existe.

            $verif = "SELECT username FROM utilisateur WHERE username = '$username'";
            $req = $c -> prepare($verif);
            $req->execute();
            $rep = $req->fetchAll();

            //Si le tableau de la requête précédente est supérieur à 0, cela voudra dire que l'utilisateur existe déjà.
            if(sizeof($rep)==0){

                //Création de la requête de création de l'utilisateur.
                $query = "INSERT INTO utilisateur(username, password, email, adresse, type, rib, raisonSociale)
                VALUES('$username', '$password', '$email', '$adresse', '$type', '$rib', '$raisonSociale')";
               //Execution de la requête d'inscription.
               $c->exec($query);
               header('Location: ../index.php'); 
            }else{
                echo "L'utilisateur existe déjà";
            }
        }
    }
    if(isset($_POST['retour'])){
        header('Location: inscription.php');
    }
?>