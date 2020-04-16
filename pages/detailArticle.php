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
    <div class="container_all">
        <div class="containerArticle">
            <span class="nomArticle"><?php echo "".ucfirst($nomArticle)." du fournisseur ".strtoupper($fournisseur).":";?></span>
            <div class="containerDetails">
                <span class="descriptionTitle">Description : </span>
                <span class="description"><?php echo $description; ?></span>
                <div class="containerInfos">
                    <div class="infos">
                        <span class="prixC">
                            <span class="prixTitle">Prix : </span>
                            <span style= "color:white; font-family: sans-serif;"><?php echo $prix." €"; ?></span>
                        </span>
                        <span class="qteC">
                            <span class="qteTitle">Stock : </span>
                            <span style="color:white; font-family: sans-serif;"><?php echo $qte."/u" ?></span>
                        </span>
                    </div>
                </div>
            </div>
            <button class="btnAcheterProduit">Acheter</button>
        </div>
    </div>
</body>
</html>