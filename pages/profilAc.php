<?php
    include('../fonctions_php/co.php');

    session_start();

    if(!isset($_SESSION['idUtilisateur'])){
        session_destroy();
        header('Location: ../index.php');
    }
    
    if($_SESSION['type']=="FO"){
        session_destroy();
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
    if(isset($_POST['btnModif'])){
        if((isset($_POST['OldPassword']) && isset($_POST['NewPassword']) && $_POST['OldPassword']==$_SESSION['password']) || 
            (isset($_POST['adresse']) && $_POST['adresse']!=$_SESSION['adresse']) || 
            (isset($_POST['email']) && $_POST['email']!=$_SESSION['email'])){
                if($_POST['OldPassword']!=null && $_POST['NewPassword']!=null){
                    $password=$_POST['NewPassword'];
                    $adresse = $_POST['adresse'];
                    $email = $_POST['email'];
                    $idUtilisateur = $_SESSION['idUtilisateur'];

                    $query = "UPDATE utilisateur SET password = '$password', email = '$email', adresse = '$adresse' WHERE idUtilisateur = '$idUtilisateur'";
                    $c->exec($query);
                    
                    //Récupération des informations de l'utilisateur après le changement.
                    $queryS = "SELECT email, adresse, password FROM utilisateur WHERE idUtilisateur = '$idUtilisateur'";
                    
                    $rep = $c->prepare($queryS);
                    $rep->execute();
                    $rep = $rep->fetchAll();
                    
                    //Réattribution de valeur au variables de sessions changées.
                    $_SESSION['password']=$rep[0]['password'];
                    $_SESSION['adresse']=$rep[0]['adresse'];
                    $_SESSION['email']=$rep[0]['email'];

                    $delay=0;
                    $url="http://localhost/marketplace_pro/pages/profilAc.php";
                    header("Refresh: $delay, url=$url");
                }else{
                    $password = $_POST['NewPassword'];
                    $adresse = $_POST['adresse'];
                    $email = $_POST['email'];
                    $idUtilisateur = $_SESSION['idUtilisateur'];
                    
                    $query = "UPDATE utilisateur SET email = '$email', adresse = '$adresse' WHERE idUtilisateur = '$idUtilisateur'";
                    $c->exec($query);

                    $queryS = "SELECT email, adresse FROM utilisateur WHERE idUtilisateur = '$idUtilisateur'";
                    
                    $rep = $c->prepare($queryS);
                    $rep->execute();
                    $rep = $rep->fetchAll();
                    
                    //Réattribution de valeur aux variables de sessions changées.
                    $_SESSION['adresse']=$rep[0]['adresse'];
                    $_SESSION['email']=$rep[0]['email'];

                    $delay=0;
                    $url="http://localhost/marketplace_pro/pages/profilAc.php";
                    header("Refresh: $delay, url=$url");
                }
            }else if ($_POST['OldPassword']!=null && $_POST['NewPassword']!=null && $_POST['OldPassword']!=$_SESSION['password']){
                echo "erreur lors de la saisie des password";
            }else if ($_POST['OldPassword']!=null && $_POST['NewPassword']==null || 
                      $_POST['OldPassword']==null && $_POST['NewPassword']!=null){
                echo "Vous n'avez pas remplis les deux champs pour changer le mot de passe";
            }else{
                echo "Vous n'avez rien changé";
            }
    }
?>