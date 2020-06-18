<?php
    session_start();
    include('../fonctions_php/fonctions.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/commandes.css">
</head>
<body>
    <?php include("../static/header.php")?>

    <div class="Commande">
        <h1 class="title_commande">Vos commandes : </h1>
        <span class="detail_commande">
<?php 
    $arrayL=listeArticleCom($_SESSION['idUtilisateur']);
    for($i=0; $i<sizeof($arrayL);$i++){
        echo "
        <form action=\"commandesAc.php\" method=\"post\">
            <input type=\"hidden\" name=\"nCommande\" value=".$arrayL[$i]->getNcommande().">
            <input type=\"hidden\" name=\"nArticle_com\" value=".$arrayL[$i]->getNarticle().">
            
            <span class=\"row_com\">
                <span class=\"nomArticle_com\" name=\"nomArticle_com\">".$arrayL[$i]->getNomArticle()."</span>
                <span class=\"prixArticle_com\">".$arrayL[$i]->getPrixArticle()."</span>
                <span class=\"quantite_com\">1</span>
                <button class=\"bt_suppr\" name=\"bt_suppr\">Annuler</button>
            </span>
        </form>";
    }
?>  
        </span>
    </div>
</body>
</html>


<?php
    if(isset($_POST['bt_suppr'])){
        supprCom($_POST['nCommande'], $_POST['nArticle_com']);
        header('Location: commandesAc.php');
    }
?>