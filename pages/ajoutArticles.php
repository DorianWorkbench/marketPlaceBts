<?php
    session_start();
    include('../fonctions_php/co.php');
    include('../fonctions_php/fonctions.php');
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
                    $queryCat="SELECT categorie FROM categorie";
                    
                    $rep = $c->prepare($queryCat);
                    $rep->execute();
                    $rep = $rep->fetchAll(PDO::FETCH_ASSOC);
                    echo "<select id=\"spinner\" name=\"spinner\">";
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
                <button type="submit" name="btnAjouter" class="btnAjouter">Ajouter</button>
            </form>
        </div>
</body>
</html>

<?php
   if(isset($_POST['btnAjouter'])){
       
    
        if(!empty($_POST['nomArticle']) ){
            if(!articleExiste($_POST['nomArticle'],$_SESSION['raisonSociale'])){
                if(!empty($_POST['qte']) && !empty($_POST['prixArticle']) && !empty($_POST['desc'])){
                    $idUtilisateur = $_SESSION['idUtilisateur'];
                    $cat = $_POST['spinner'];
                    $nomArticle = $_POST['nomArticle'];
                    $prix = $_POST['prix'];
                    $description = $_POST['description'];
                    $qte = $_POST['qte'];
        
                    $queryAjout = "INSERT INTO article(idUtilisateur, cat, nomArticle, prix, description, stock) 
                                VALUES($idUtilisateur, '$cat', '$nomArticle', $prix, '$description', $qte)";
        
                    $c->exec($queryAjout);
        
                    echo "Article ajouté";
                }else{
                    $idUtilisateur = $_SESSION['idUtilisateur'];
                    $cat = $_POST['spinner'];
                    $nomArticle = $_POST['nomArticle'];
                    $description = $_POST['description'];

                    $prix=0;
                    $qte=0;
                    
                    $queryAjout = "INSERT INTO article(idUtilisateur, cat, nomArticle, prix, description, stock) 
                    VALUES($idUtilisateur, '$cat', '$nomArticle', $prix, '$description', $qte)";
                    $c->exec($queryAjout);

                    header('Location: ../index_fo.php');
                }
            }else{
                echo "L'article existe déjà";
            }
                
        }else{
            echo "Veuillez remplir le nom de l'article";
        }
    }
?>