<?php
    //Incorporation des fonctions du fichier "fonctions.php"
    include('../fonctions_php/co.php');
    //Démarrage de la session
    session_start();
    //Vérification de la connexion de l'utilisateur
    if(!isset($_SESSION['idUtilisateur'])){
        //Si l'utilisateur n'est pas connecté nous le déconnectons
        session_destroy();
        //Puis nous le redirigons vers la page d'index
        header('Location: ../index.php');
    }
    //Vérification du type de l'utilisateur
    if($_SESSION['type']=="AC"){
        //Si il n'est pas du type "AC" nous le déconnectons
        session_destroy();
        //Puis nous le redirigons vers la page "index.php"
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
    <link rel="stylesheet" href="../css/profilFo.css">
</head>
<body>
    <?php include('../static/header.php')?>
        <div class="profilFo">
            <span class="title">Bienvenue <?php echo ucfirst(strtolower($_SESSION['raisonSociale']));?></span>
            
            <form action="profilFo.php" method="post" class="formPfo">

                <label for="OldPassword" id="lblOldPassword" class="lblP">Ancien mot de passe : </label>
                <input type="password" name="OldPassword" id="OldPassword" placeholder="Ancien mot de passe" class="form_Et">
                <label for="NewPassword" id="lblNewPassword" class="lblP">Nouveau mot de passe : </label>
                <input type="password" name="NewPassword" id="NewPassword" placeholder="Nouveau mot de passe" class="form_Et">
                <label for="Adresse" id="lblAdresse" class="lblP">Adresse postale : </label>
                <input type="text" name="adresse" id="Adresse" placeholder="adresse" value="<?php echo $_SESSION['postalAdress']; ?>" class="form_Et">
                <label for="email" id="lblEmail" class="lblP">Email : </label>
                <input type="text" name="email" id="email" placeholder="email" value = "<?php echo $_SESSION['email']?>"class="form_Et">
                <label for="email" id="lblRaisonSociale" class="lblP">Raison sociale : </label>
                <input type="text" name="raisonSociale" id="raisonSociale" placeholder="Raison Sociale" value = "<?php echo $_SESSION['raisonSociale']?>"class="form_Et">

                <button type="submit" name="btnModif" class="btnModif">Modifier</button>
            </form>
        </div>
</body>
</html>

<?php
    //Ecoute du bouton "btnModif"
    if(isset($_POST['btnModif'])){
        //Vérification des champs pour la modification du profil
        if((isset($_POST['OldPassword']) && isset($_POST['NewPassword']) && $_POST['OldPassword']==$_SESSION['password']) || 
            (isset($_POST['adresse']) && $_POST['adresse']!=$_SESSION['postalAdress']) || 
            (isset($_POST['email']) && $_POST['email']!=$_SESSION['email']) ||
            (isset($_POST['raisonSociale']) && $_POST['raisonSociale']!=$_SESSION['raisonSociale'])){
                //Vérification de l'entrée d'un nouveau mot de passe
                if($_POST['OldPassword']!=null && $_POST['NewPassword']!=null){
                    //Attribution des valeurs aux variables
                    $password=$_POST['NewPassword'];
                    $adresse = $_POST['adresse'];
                    $email = $_POST['email'];
                    $raisonSociale = $_POST['raisonSociale'];
                    $idUtilisateur = $_SESSION['idUtilisateur'];
                    //Définition de la requête d'update des champs de l'utilisateur
                    $query = "UPDATE utilisateur SET password = '$password', email = '$email', adresse = '$adresse', raisonSociale = '$raisonSociale' WHERE idUtilisateur = '$idUtilisateur'";
                    //Execution de la requête
                    $c->exec($query);
                    
                    //Récupération des informations de l'utilisateur après le changement.
                    $queryS = "SELECT email, adresse, password, raisonSociale FROM utilisateur WHERE idUtilisateur = '$idUtilisateur'";
                    //Préparation de la requête
                    $rep = $c->prepare($queryS);
                    //Execution de la requête
                    $rep->execute();
                    //Attribution des valeurs reçus pas la requête dans un tableau
                    $rep = $rep->fetchAll();
                    
                    //Réattribution de valeur au variables de sessions changées.
                    $_SESSION['password']=$rep[0]['password'];
                    $_SESSION['postalAdress']=$rep[0]['adresse'];
                    $_SESSION['email']=$rep[0]['email'];
                    $_SESSION['raisonSociale']=$rep[0]['raisonSociale'];
                    //Rechargement de la page
                    $delay=0;
                    $url="http://localhost/marketplace_pro/pages/profilFo.php";
                    header("Refresh: $delay, url=$url");
                }else{//Si nous ne modifions pas le mot de passe
                    //Attribution des valeurs aux variables
                    $adresse = $_POST['adresse'];
                    $email = $_POST['email'];
                    $raisonSociale = $_POST['raisonSociale'];
                    $idUtilisateur = $_SESSION['idUtilisateur'];
                    //Définition de la variable d'update de champs d'utilisateur
                    $query = "UPDATE utilisateur SET email = '$email', adresse = '$adresse', raisonSociale = '$raisonSociale' WHERE idUtilisateur = '$idUtilisateur'";
                    //Execution de la dite requête
                    $c->exec($query);
                    //Définition de la requête permettant le rafraichissement des données de la page
                    $queryS = "SELECT email, adresse, raisonSociale FROM utilisateur WHERE idUtilisateur = '$idUtilisateur'";
                    //Préparation de la requête
                    $rep = $c->prepare($queryS);
                    //Execution de la requête
                    $rep->execute();
                    //Attribution des nouvelles valeurs dans le tableau
                    $rep = $rep->fetchAll();
                    
                    //Réattribution de valeur aux variables de sessions changées.
                    $_SESSION['postalAdress']=$rep[0]['adresse'];
                    $_SESSION['email']=$rep[0]['email'];
                    $_SESSION['raisonSociale']=$rep[0]['raisonSociale'];
                    //Raffraichissement de la page
                    $delay=0;
                    $url="http://localhost/marketplace_pro/pages/profilFo.php";
                    header("Refresh: $delay, url=$url");
                }
            }else if ($_POST['OldPassword']!=null && $_POST['NewPassword']!=null && $_POST['OldPassword']!=$_SESSION['password']){//Vérification pour le changement de mot de passe
                echo "erreur lors de la saisie des password";
            }else if ($_POST['OldPassword']!=null && $_POST['NewPassword']==null || 
                    $_POST['OldPassword']==null && $_POST['NewPassword']!=null){//Vérification pour le changement de mot de passe
                echo "Vous n'avez pas remplis les deux champs pour changer le mot de passe";
            }else{//Si nous ne mettons rien dans les champs, nous n'avons rien changé
                echo "Vous n'avez rien changé";
            }
    }
?>