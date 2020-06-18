<?php
    include('../fonctions_php/co.php');
    include('../fonctions_php/fonctions.php');
    session_start();
    if(isset($_POST['acheter']) && !empty($_POST['nArticle'])){

        $_SESSION['nArticle'] = $_POST['nArticle'];
        header('detailArticle.php');

        $arrayArticle = recupArticle($_SESSION['nArticle']);
        $nomArticle = $arrayArticle[0]['nomArticle'];
        $fournisseur = rechercheFournisseur($_SESSION['nArticle'])[0]['raisonSociale'];
        $description = recupArticle($_SESSION['nArticle'])[0]['description'];
        $qte = recupArticle($_SESSION['nArticle'])[0]['stock'];
        $prix = recupArticle($_SESSION['nArticle'])[0]['prix'];
    }
    if(!isset($_POST['acheter']) && !empty($_SESSION['nArticle'])){
        $arrayArticle = recupArticle($_SESSION['nArticle']);
        $nomArticle = $arrayArticle[0]['nomArticle'];
        $fournisseur = rechercheFournisseur($_SESSION['nArticle'])[0]['raisonSociale'];
        $description = recupArticle($_SESSION['nArticle'])[0]['description'];
        $qte = recupArticle($_SESSION['nArticle'])[0]['stock'];
        $prix = recupArticle($_SESSION['nArticle'])[0]['prix'];
    }
    if(!isset($_POST['acheter']) && empty($_SESSION['nArticle'])){
        header('Location: ../index.php');
    }
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail Article</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/detailArticle.css">
    
</head>
<body>
    <?php include('../static/header.php'); ?>

        <div class="container_infos">
        <span class="titleArticle"><?php echo $nomArticle." du fournisseur ".$fournisseur ?></span>

            <div class="detail">
                <span class="inti" id="descTitle">Description : </span>
                <span class="desc"><?php echo $description ?></span>
                <div class="infoArt">
                    <div class="prix">
                        <span class="inti">Prix</span>
                        <span><?php echo $prix ?></span>
                    </div>
                    <div class="qte">
                        <span class="inti">Stock</span>
                        <span><?php echo $qte ?></span>
                    </div>
                </div>
                <form action="detailArticle.php" method="post" class="center">
                    <button type="submit" name="achat" class="acheter">Acheter</button>
                </form>
            </div>
        </div>
</body>
</html>

<?php 
    if(isset($_POST['achat'])){
        ajoutCommande($_SESSION['nArticle'],$_SESSION['idUtilisateur']);
        header('Location:../index.php');
    }
?>