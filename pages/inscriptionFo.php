<!DOCTYPE html>
<?php
    //Démarrage de la session
    session_start();
    //Vérification pour savoir si l'utilisateur est connecté
    if(isset($_SESSION['idUtilisateur'])){
        //Si il est connecté, nous le deconnectons
        session_destroy();
        //Puis nous le redirigons vers la page d'index
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
    <!-- Ajout de la bar de navigation -->
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
    //Lien vers la fonction de connexion vers la base de donnée
    include('../fonctions_php/co.php');
    //Ecoute du bouton "btnSubscribe" du formulaire
    if(isset($_POST['btnSubscribe'])){
        //Vérification des champs null
        if($_POST['username'] == null || $_POST['password'] == null || 
           $_POST['email'] == null || $_POST['rib']==null || 
           $_POST['adresse']==null || $_POST['rs'] == null || $_POST['rs']==null){
            // Si il y a un champ null, nous retournons une erreur
            echo "<script>erreur();</script>";

        }else{//Si tous les champs sont remplis
            //Nous définissons et attribuons une valeur aux variables suivantes
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $adresse= $_POST['adresse'];
            $type = "FO";
            $rib = $_POST['rib'];
            $raisonSociale = $_POST['rs'];

            //Création de la requête de test pour savoir si l'utilisateur existe.
            $verif = "SELECT username FROM utilisateur WHERE username = '$username'";
            //Préparation de la requête
            $req = $c -> prepare($verif);
            //Execution de la requête
            $req->execute();
            //Recuperation des resultats sous form de tableau
            $rep = $req->fetchAll();

            //Si le tableau de la requête précédente est supérieur à 0, cela voudra dire que l'utilisateur existe déjà.
            if(sizeof($rep)==0){
                //Création de la requête de création de l'utilisateur.
                $query = "INSERT INTO utilisateur(username, password, email, adresse, type, rib, raisonSociale)
                VALUES('$username', '$password', '$email', '$adresse', '$type', '$rib', '$raisonSociale')";
               //Execution de la requête d'inscription.
               $c->exec($query);
               //Redirection vers la page "index.php"
               header('Location: ../index.php'); 
            }else{//Si la taille du tableau est supérieur à 0, nous estimons que l'utilisateur existe déjà
                echo "L'utilisateur existe déjà";
            }
        }
    }
    //Ecoute du bouton de retour
    if(isset($_POST['retour'])){
        //Redirection vers la page "inscription.php"
        header('Location: inscription.php');
    }
?>