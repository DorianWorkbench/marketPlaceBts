<?php
    //Incorporation des fonctions des fichiers suivant:
    include('../fonctions_php/co.php');
    include('../fonctions_php/fonctions.php');
    //Démarrage de la session
    session_start();
    //Ecoute du bouton "acheter" venant de la page "index.php"
    if(isset($_POST['acheter']) && !empty($_POST['nArticle'])){
        //Ajout du nArticle à la variable de session
        $_SESSION['nArticle'] = $_POST['nArticle'];
        
        //Définition des variables et affectation des valeurs
        $arrayArticle = recupArticle($_SESSION['nArticle']);
        $nomArticle = $arrayArticle[0]['nomArticle'];
        //Appel de la fonction "rechercheFournisseur" pour récuperer la raison sociale
        $fournisseur = rechercheFournisseur($_SESSION['nArticle'])[0]['raisonSociale'];
        //Appel de la fonction "recupArticle" pour récuperer les différentes valeurs du tableau renvoyé
        $description = recupArticle($_SESSION['nArticle'])[0]['description'];
        $qte = recupArticle($_SESSION['nArticle'])[0]['stock'];
        $prix = recupArticle($_SESSION['nArticle'])[0]['prix'];
    }
    //Vérifie si la variable de session "nArticle" est attribuée, cela règle le problème d'affichage des données lors du rechargement de la page
    if(!isset($_POST['acheter']) && !empty($_SESSION['nArticle'])){
        //Récupération du tableau d'informations sur les articles
        $arrayArticle = recupArticle($_SESSION['nArticle']);

        //Déclaration/Affectation des valeurs pour les variable
        $nomArticle = $arrayArticle[0]['nomArticle'];
        //Récupération de la raison sociale du fournisseur de l'article
        $fournisseur = rechercheFournisseur($_SESSION['nArticle'])[0]['raisonSociale'];
        $description = recupArticle($_SESSION['nArticle'])[0]['description'];
        $qte = recupArticle($_SESSION['nArticle'])[0]['stock'];
        $prix = recupArticle($_SESSION['nArticle'])[0]['prix'];
    }
    //Evite l'accès à la page par un url rempli à la main par l'utilisateur lorsque celui ci n'a pas consulté d'article au préalable
    if(!isset($_POST['acheter']) && empty($_SESSION['nArticle'])){
        header('Location: ../index.php');
    }
    //Si l'utilisateur est du type "FO" le redirige sur sa page d'accueil
    if($_SESSION['type']=='FO'){
        header('Location: ../index_fo.php');
    }//Si la personne n'est pas connecté
    if(empty($_SESSION['type'])){
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
    //Ecoute du bouton "achat"
    if(isset($_POST['achat'])){
        //Utilisation de la fonction ajoutCommande
        ajoutCommande($_SESSION['nArticle'],$_SESSION['idUtilisateur']);
        //Redirection vers la page index.php
        header('Location:../index.php');
    }
?>