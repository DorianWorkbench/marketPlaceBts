<?php
    include("../fonctions_php/fonctions.php");
    session_start();
    if(!isset($_SESSION['idUtilisateur']) || $_SESSION['type'] == "AC"){
        session_destroy();
        header('Location:../index.php');
    }
    if(isset($_POST['btnModif']) && !empty($_POST['nArticle'])){

        $_SESSION['nArticle'] = $_POST['nArticle'];
        header('modifArticle.php');
        
        $arrayArticle = recupArticle($_SESSION['nArticle']);
        $nomArticle = $arrayArticle[0]['nomArticle'];
        $prixArticle = $arrayArticle[0]['prix'];
        $stock = $arrayArticle[0]['stock'];
        $desc = $arrayArticle[0]['description'];
    }
    if(!isset($_POST['btnModif']) && !empty($_SESSION['nArticle'])){
        
        $arrayArticle = recupArticle($_SESSION['nArticle']);
        $nomArticle = $arrayArticle[0]['nomArticle'];
        $prixArticle = $arrayArticle[0]['prix'];
        $stock = $arrayArticle[0]['stock'];
        $desc = $arrayArticle[0]['description'];
    }
    if(!isset($_POST['btnModif']) && empty($_SESSION['nArticle'])){
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
   if(isset($_POST['btnModifArt'])){
        if(!empty($_POST['nomArticle'])){
            if(!empty($_POST['qte']) && !empty($_POST['prixArticle']) && !empty($_POST['desc'])){
                modifArticle($_SESSION['nArticle'], $_SESSION['raisonSociale'], $nomArticle, $_POST['nomArticle'], $_POST['prixArticle'],$_POST['qte'], $_POST['desc']);
                header('Location: ../index_fo.php');
            }else{
                $_POST['prixArticle']=0;
                $_POST['qte']=0;

                modifArticle($_SESSION['nArticle'], $_SESSION['raisonSociale'], $nomArticle, $_POST['nomArticle'], $_POST['prixArticle'],$_POST['qte'], $_POST['desc']);
                header('Location: ../index_fo.php');
            }
        }else{
            echo('Vous n\'avez pas saisie le nom du produit');
        }
    }
?>