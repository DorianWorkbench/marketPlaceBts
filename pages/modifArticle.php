<?php
//Incorporation des fonctions du fichier "fonctions.php"
include("../fonctions_php/fonctions.php");
//Demarrage de la session
session_start();

//Ecoute du bouton "btnModif" de la page "index_Fo.php", vérifie si il renvoie bien un nArticle non null
if(isset($_POST['btnModif']) && !empty($_POST['nArticle'])){
    //Attribution de la valeur "post" du nArticle à la variable de "session"
    $_SESSION['nArticle'] = $_POST['nArticle'];

    //Définition et attribution des valeurs aux variables
    $arrayArticle = recupArticle($_SESSION['nArticle']);
    $nomArticle = $arrayArticle[0]['nomArticle'];
    $prixArticle = $arrayArticle[0]['prix'];
    $stock = $arrayArticle[0]['stock'];
    $desc = $arrayArticle[0]['description'];
}
//Permet d'éviter les erreurs lors du rechargement de la page 
//(vérification du non click du bouton et de l'attribution non null d'une valeur à la variable de session)
if(!isset($_POST['btnModif']) && !empty($_SESSION['nArticle'])){
    //Récupération du tableau renvoyé par la fonction "recupArticle"
    $arrayArticle = recupArticle($_SESSION['nArticle']);
    //Declaration des variables et attribution des valeurs
    $nomArticle = $arrayArticle[0]['nomArticle'];
    $prixArticle = $arrayArticle[0]['prix'];
    $stock = $arrayArticle[0]['stock'];
    $desc = $arrayArticle[0]['description'];
}
//Si le bouton "btnModif" n'est pas cliqué et que la variable de session est null, nous renvoyons sur la page d'index_fo
if(!isset($_POST['btnModif']) && empty($_SESSION['nArticle'])){
    //Redirection vers la page "index_fo.php"
    header('Location: ../index_fo.php');
}
//Vérifie si l'utilisateur est du bon type et si un utilisateur est connecté
if($_SESSION['type']=='AC'|| empty($_SESSION['type'])){
    header('Location: ../index.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifications article</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/modifArticle.css">
</head>
<body>
    <?php include('../static/header.php'); ?>
    <div class="containerModifArticle">
    <span class="titleModif">Modification Article : </span>
        <form action="modifArticle.php" method="post" class="formModifArticle">
            <label for="nomArticle" class="lblArt">Nom de Article : </label>
            <input type="text" name="nomArticle" id="nomArticle" class="form_Et" value="<?php echo $nomArticle ?>">
            <div class="infosArticle">
                <div class="prix">
                    <label for="prix" style="color:royalblue; font-weight:600;"> Prix Article : </label>
                    <input type="number" name="prixArticle" id="prixArticle" value="<?php echo $prixArticle ?>" class="number_Et">
                </div>
                <div class="qte">
                    <label for="qte" style="color:royalblue; font-weight:600;">Stock : </label>
                    <input type="number" name="qte" id="stock" value="<?php echo $stock ?>" class="number_Et">
                </div>
            </div>
            <label for="desc" class="lblArt">Description : </label>
            <textarea name="desc" id="desc" cols="30" rows="10"><?php echo $desc ?></textarea>
            <button type="submit" name="btnModifArt" class="btnModif">Modifier</button>
        </form>
    </div>
</body>
</html>

<?php
//Ecoute du bouton "btnModifArt"
if(isset($_POST['btnModifArt'])){
    //Vérification de l'entrée du nom de l'article
    if(!empty($_POST['nomArticle'])){
        //Si l'entrée n'est pas vide, nous vérifions les champs remplis par l'utilisateur
        if(!empty($_POST['qte']) && !empty($_POST['prixArticle']) && !empty($_POST['desc'])){
            //Appel de la fonction modifArticle permettant de mettre à jour l'article de l'utilisateur
            modifArticle($_SESSION['nArticle'], $_SESSION['raisonSociale'], $nomArticle, $_POST['nomArticle'], $_POST['prixArticle'],$_POST['qte'], $_POST['desc']);
            //Redirection vers la page d'index une fois la modification effectuée
            header('Location: ../index_fo.php');
        }else{//Si les champs ne possède pas de quantité et/ou de prix et/ou de description, 
             // nous mettons des valeurs par défaut pour éviter les mauvaises manipulations de l'utilisateur(un article ayant pour quantité 1 et pour prix 0 par exemple)
            $_POST['prixArticle']=0;
            $_POST['qte']=0;
            //Appel de la fonction de modification d'article
            modifArticle($_SESSION['nArticle'], $_SESSION['raisonSociale'], $nomArticle, $_POST['nomArticle'], $_POST['prixArticle'],$_POST['qte'], $_POST['desc']);
            //Redirection vers la page "index_fo.php" à la fin de la modification
            header('Location: ../index_fo.php');
        }
    }else{//Si le champ du nom du produit est vide, nous renvoyons un message d'erreur
        echo('Vous n\'avez pas saisie le nom du produit');
    }
}
?>