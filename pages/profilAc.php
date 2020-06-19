<?php
    //Incorporation des fonctions du fichier "fonctions.php"
    include('../fonctions_php/co.php');
    //Demarrage de la session
    session_start();
    //Vérification de la connexion de l'utilisateur
    if(!isset($_SESSION['idUtilisateur'])){
        //Si l'utilisateur est connecté, nous le déconnectons
        session_destroy();
        //Puis nous le renvoyons vers la page d'index
        header('Location: ../index.php');
    }
    //Vérification du type de l'utilisateur
    if($_SESSION['type']=="FO"){
        //Si c'est un utilisateur de type "FO" il n'est pas sensé arriver sur cette page, nous le deconnectons
        session_destroy();
        //Puis nous le redirigons vers la page d'index
        header('Location: ../index.php');
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Acheteur</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/profilAc.css">
</head>
<body>
    <?php include('../static/header.php');?>
    
    <span class="erreur">
        Vous n'avez pas remplis les deux champs pour changer de mot de passe.
    </span>
        <div class="container_profil">
            <span class="title_user">Bienvenue <?php echo ucfirst(strtolower($_SESSION['prenom']))." :"?></span>

            <form action="profilAc.php" method="post" class="formPac">
                <label for="OldPassword">Ancien mot de passe : </label>
                <input type="password" name="OldPassword" id="OldPassword" placeholder="Ancien mot de passe" class="form_Et">
                <label for="NewPassword" id="lblNewPassword">Nouveau mot de passe : </label>
                <input type="password" name="NewPassword" id="NewPassword" placeholder="Nouveau mot de passe" class="form_Et">
                <label for="Adresse" id="lblAdresse">Adresse postale : </label>
                <input type="text" name="adresse" id="Adresse" placeholder="adresse" value="<?php echo $_SESSION['adresse']; ?>" class="form_Et">
                <label for="email" id="lblEmail">Email : </label>
                <input type="text" name="email" id="email" placeholder="email" value = "<?php echo $_SESSION['email']?>"class="form_Et">
                <button type="submit" name="btnModif" class="btnModif">Modifier</button>
            </form>
        </div>
    <script type="text/javascript" src="../javascript/script.js"></script>
</body>
</html>

<?php
    //Ecoute du bouton btnModif
    if(isset($_POST['btnModif'])){
        //Vérification de l'entrée des différents champs
        if((isset($_POST['OldPassword']) && isset($_POST['NewPassword']) && $_POST['OldPassword']==$_SESSION['password']) || 
            (isset($_POST['adresse']) && $_POST['adresse']!=$_SESSION['adresse']) || 
            (isset($_POST['email']) && $_POST['email']!=$_SESSION['email'])){
                //Vérification de la saisie de l'ancien mot de passe et du nouveau
                if($_POST['OldPassword']!=null && $_POST['NewPassword']!=null){
                    //Attribution des valeurs aux variables
                    $password=$_POST['NewPassword'];
                    $adresse = $_POST['adresse'];
                    $email = $_POST['email'];
                    $idUtilisateur = $_SESSION['idUtilisateur'];
                    
                    //Définition de la variable de modification de l'utilisateur
                    $query = "UPDATE utilisateur SET password = '$password', email = '$email', adresse = '$adresse' WHERE idUtilisateur = '$idUtilisateur'";
                    //Execution de la requête
                    $c->exec($query);
                    
                    //Récupération des informations de l'utilisateur après le changement.
                    $queryS = "SELECT email, adresse, password FROM utilisateur WHERE idUtilisateur = '$idUtilisateur'";
                    //Préparation de la requête
                    $rep = $c->prepare($queryS);
                    //Execution de la requête
                    $rep->execute();
                    //Création du tableau ayant pour paramètre les éléments du select
                    $rep = $rep->fetchAll();
                    
                    //Réattribution de valeur au variables de sessions changées.
                    $_SESSION['password']=$rep[0]['password'];
                    $_SESSION['adresse']=$rep[0]['adresse'];
                    $_SESSION['email']=$rep[0]['email'];

                    //Raffraichissement de la page
                    $delay=0;
                    $url="http://localhost/marketplace_pro/pages/profilAc.php";
                    header("Refresh: $delay, url=$url");
                }else{//Si l'ancien mot de passe n'est pas remplis, nous assumons le fait que l'utilisateur ne veut pas changer de mot de passe
                    $adresse = $_POST['adresse'];
                    $email = $_POST['email'];
                    $idUtilisateur = $_SESSION['idUtilisateur'];
                    //Définition de la variable de modification de champs des données de l'utilisateur
                    $query = "UPDATE utilisateur SET email = '$email', adresse = '$adresse' WHERE idUtilisateur = '$idUtilisateur'";
                    //Execution de la dite requête
                    $c->exec($query);
                    //Définition de la requête de recherche de l'adresse/adresse email de l'utilisateur pour les réafficher dans les input text
                    $queryS = "SELECT email, adresse FROM utilisateur WHERE idUtilisateur = '$idUtilisateur'";
                    //Préparation de la requête
                    $rep = $c->prepare($queryS);
                    //Execution de la requête
                    $rep->execute();
                    //Attribution des resultats de la requête dans un tableau
                    $rep = $rep->fetchAll();
                    
                    //Réattribution de valeur aux variables de sessions changées.
                    $_SESSION['adresse']=$rep[0]['adresse'];
                    $_SESSION['email']=$rep[0]['email'];

                    //Rafraichissement de la page
                    $delay=0;
                    $url="http://localhost/marketplace_pro/pages/profilAc.php";
                    header("Refresh: $delay, url=$url");
                }
            }else if ($_POST['OldPassword']!=null && $_POST['NewPassword']!=null && $_POST['OldPassword']!=$_SESSION['password']){//Vérification pour la modification du mot de passe
                echo "erreur lors de la saisie des password";
            }else if ($_POST['OldPassword']!=null && $_POST['NewPassword']==null || 
                      $_POST['OldPassword']==null && $_POST['NewPassword']!=null){//Vérification pour la modification du mot de passe
                echo "Vous n'avez pas remplis les deux champs pour changer le mot de passe";
            }else{//Si tout est identique, nous n'avons rien changé
                echo "Vous n'avez rien changé";
            }
    }
?>