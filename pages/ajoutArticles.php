<?php
    //Démarrage de la session
    session_start();
    //Récupération des fonctions des dossiers suivants:
    include('../fonctions_php/co.php');
    include('../fonctions_php/fonctions.php');
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
    <title>Ajout</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/ajoutArticles.css">
</head>
<body>
    <?php include('../static/header.php')?>
        <div class="container_article">
            <span class="title">Ajoutez un article :</span>
            <form action="ajoutArticles.php" method="post" class="formArt">
                <input type="text" name="nomArticle" id="nomArticle" class="form_ET" placeholder="Nom de l'article">
                <?php
                    //Affichage des champs categorie dans le spinner
                    
                    //Déclaration de la requête de récupération des categories
                    $queryCat="SELECT categorie FROM categorie";
                    
                    //Préparation de la requête
                    $rep = $c->prepare($queryCat);
                    //Execution de la requête
                    $rep->execute();
                    //Recuperation des valeurs de la requête sous forme de tableau
                    $rep = $rep->fetchAll(PDO::FETCH_ASSOC);
                    //Affichage de l'élément html select 
                    echo "<select id=\"spinner\" name=\"spinner\">";
                    //Boucle permettant de parcourir le tableau des noms de categorie et affectant la valeur à chaque champ option
                    for($i=0; $i<sizeof($rep); $i++){
                        echo "<option value=".$rep[$i]['categorie']." class=\"optionCat\">".$rep[$i]['categorie']."</option>";
                    }
                    echo "</select>";
                ?>
                <div class="number">
                    <input type="number" name="qte" id="qte" class="number_ET" placeholder="Quantité" min="0" step="1">
                    <div class="space"></div>
                    <input type="number" name="prix" id="prix" class="number_ET" placeholder="Prix" min="0" step="0.01">
                </div>
                    <textarea name="description" id="description" cols="30" rows="10" placeholder="Description ..."></textarea>
                <!-- Validation du formulaire -->
                <button type="submit" name="btnAjouter" class="btnAjouter">Ajouter</button>
            </form>
        </div>
</body>
</html>

<?php
    //Ecoute du bouton btnAjouter du formulaire
    if(isset($_POST['btnAjouter'])){
       //Vérification du retour du champ (on evitera un retour ayant pour valeur null)
        if(!empty($_POST['nomArticle']) ){
            //Si l'article n'existe pas nous passons à l'étape suivante
            if(!articleExiste($_POST['nomArticle'],$_SESSION['raisonSociale'])){
                //Nous vérifions si les champs ont bien été renseigné par l'utilisateur 
                //une action différente sera effectué si tous les champs ne sont pas renseigné
                if(!empty($_POST['qte']) && !empty($_POST['prix']) && !empty($_POST['description']) && !empty($_POST['spinner'])){
                    //Définition de variables et affectation de valeur
                    $idUtilisateur = $_SESSION['idUtilisateur'];
                    $cat = $_POST['spinner'];
                    $nomArticle = $_POST['nomArticle'];
                    $prix = $_POST['prix'];
                    $description = $_POST['description'];
                    $qte = $_POST['qte'];
                    
                    //Définition de la requête d'ajout de produit
                    $queryAjout = "INSERT INTO article(idUtilisateur, cat, nomArticle, prix, description, stock) 
                                VALUES($idUtilisateur, '$cat', '$nomArticle', $prix, '$description', $qte)";
                    //Exécution de la requête
                    $c->exec($queryAjout);
                    
                    //Redirection vers la page d'accueil pour l'utilisateur fo
                    header('Location: ../index_fo.php');
                    
                }else{//Si le prix et/ou la quantité et/ou la description ne sont pas saisie 
                    //Définition de variables et affectation de valeur
                    $idUtilisateur = $_SESSION['idUtilisateur'];
                    $cat = $_POST['spinner'];
                    $nomArticle = $_POST['nomArticle'];
                    $description = $_POST['description'];
                    //Si les champs prix et quantité ne sont pas renseigné, nous mettons par défaut une valeur aux prix et à la quantité
                    $prix=0;
                    $qte=0;
                    
                    //Définition de la requête d'ajout d'article
                    $queryAjout = "INSERT INTO article(idUtilisateur, cat, nomArticle, prix, description, stock) 
                    VALUES($idUtilisateur, '$cat', '$nomArticle', $prix, '$description', $qte)";
                    //Execution de la requête
                    $c->exec($queryAjout);
                    //Redirection vers la page index du fournisseur
                    header('Location: ../index_fo.php');
                }
            }else{//Si articleExiste return true
                echo "L'article existe déjà";
            }
                
        }else{//Si le nom de l'article n'est pas saisie
            echo "Veuillez remplir le nom de l'article";
        }
    }
?>