<?php
    //ob_start et ob_flush permettent de mettre en tampon les actions de rechargement de page effectuées par chaque action "annuler" de l'utilisateur.
    ob_start();
    //Debut de la session
    session_start();
    
    //Ajout des fonctions du dossier "fonctions.php"
    include('../fonctions_php/fonctions.php');
    //Vérifie si l'utilisateur est du bon type et si un utilisateur est connecté
    if($_SESSION['type']=='FO'|| empty($_SESSION['type'])){
        header('Location: ../index.php');
    }
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
    <!-- Ajout de l'élément header sur la page -->
    <?php include("../static/header.php")?>

    <div class="Commande">
        <h1 class="title_commande">Vos commandes : </h1>
        <span class="detail_commande">
<?php 
    //Récupération de l'array de retour de la fonction listeArticleCom
    $arrayL=listeArticleCom($_SESSION['idUtilisateur']);
    //Nous parcourons le tableau d'objet "Commande" renvoyé par la fonction
    for($i=0; $i<sizeof($arrayL);$i++){
        //Affichage des elements html avec les valeurs de chaques éléments du tableau de "Commande" 
        //nous accedons aux méthodes get pour afficher les différentes informations
        echo "
        <form action=\"commandesAc.php\" method=\"post\">
            <input type=\"hidden\" name=\"nCommande\" value=".$arrayL[$i]->getNcommande().">
            <input type=\"hidden\" name=\"nArticle_com\" value=".$arrayL[$i]->getNarticle().">

            <span class=\"row_com\">
                <span class=\"nomArticle_com\" name=\"nomArticle_com\">".$arrayL[$i]->getNomArticle()."</span>
                <span class=\"prixArticle_com\">".number_format((float)$arrayL[$i]->getPrixArticle(),1)." €"."</span>
                <span class=\"quantite_com\">1 article</span>
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
    //Ecoute du bouton bt_suppr du formulaire
    if(isset($_POST['bt_suppr'])){
        //Execution de la méthode supprCom permettant de supprimer une commande de la liste
        supprCom($_POST['nCommande'], $_POST['nArticle_com']);
        //Reload de la page pour voir la modification et ainsi voir disparaitre l'élément html associé à la commande supprimée
        header('Location: commandesAc.php');
        ob_flush();
    }
?>