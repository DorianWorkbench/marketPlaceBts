<?php
    //Vérification de l'existance de l'article(utilisé dans ajoutArticle.php et dans la fonction modifArticle de ce fichier(fonctions.php))
    function articleExiste($nomArticle, $raisonSociale){
        //Récupération de la fonction de connexion à la base de donnée
        include('co.php');
        //Permet d'afficher le nomArticle pour une raison sociale et un nom article définit 
        $queryArticle= "SELECT nomArticle 
                        FROM utilisateur 
                        FULL JOIN article ON utilisateur.idUtilisateur=article.idUtilisateur 
                        WHERE raisonSociale='$raisonSociale' AND nomArticle = '$nomArticle'";
        //Préparation de la requête
        $exist = $c->prepare($queryArticle);
        //Exécution de la requête
        $exist->execute();
        //Attributiond des valeurs dans un tableau
        $exist = $exist->fetchAll();
        //Si le tableau est vide, l'article n'existe pas donc nous renvoyons false
        if(sizeof($exist)==0){
            return false;
        }else{//Si le tableau contient une valeur, l'article existe nour renvoyons true
            return true;
        }
        //Etat par défaut du retour de la fonction
        return true;
    }
    //Récupération de tous les articles suivant la raisonSociale de l'utilisateur(utilisée dans la page "index_fo.php")
    function tableauArticles($raisonSociale){
        //Récupération de la fonction de connexion à la base de donnée
        include('co.php');
        $array = array();
        $rep;
        //Permet d'afficher les infos des articles suivant la raison social quand l'article existe(!='')
        $querySelect = "SELECT nArticle, nomArticle, prix, stock, cat, raisonSociale 
                        FROM article 
                        FULL JOIN utilisateur 
                        ON article.idUtilisateur = utilisateur.idUtilisateur
                        WHERE raisonSociale = '$raisonSociale' AND nArticle!=''";
        //Préparation de la requête
        $rep = $c->prepare($querySelect);
        //Execution de la requête
        $rep->execute();
        //Attribution des valeurs au tableau
        $rep = $rep-> fetchAll(PDO::FETCH_ASSOC);
        //Affectation du tableau à la variable "$array"
        $array=$rep;
        //Nous retournons le tableau ayant pour élément les données de l'article
        return $array;
    }
    //Récupération de tous les articles(utilisé dans la page "index.php")
    function tableauAllArticles(){
        //Récupération de la fonction de connexion à la base de donnée
        include('co.php');
        $array = array();
        $rep;
        //Définition d'une variable d'affichage des informations des article lorsque le prix et le stock est supérieur à 0 
        // (permet de ne pas mettre en vente des produits n'ayant plus de quantité ou n'ayant pas un prix définit)
        $querySelect = "SELECT nArticle, nomArticle, prix, stock, cat
                        FROM article WHERE prix>0 AND stock>0";
        
        $rep = $c->prepare($querySelect);
        $rep->execute();
        $rep = $rep-> fetchAll(PDO::FETCH_ASSOC);
        
        $array =$rep;
        //Retour du tableau ayant pour valeur les différents valeurs des articles
        return $array;
    }
    //Récupération d'un article utilisé dans la page "detailArticle.php" et "modifArticle.php" 
    //permettant de récupérer des informations sur les articles suivant le numéro d'article
    function recupArticle($nArticle){
        include('co.php');
        $array = array();
        $rep;
        //Définition d'une variable d'affichage des données de l'article correspondant au nArticle saisie
        $querySelectArticle = "SELECT * FROM article WHERE nArticle = $nArticle";
        $rep = $c->prepare($querySelectArticle);
        $rep->execute();
        $array = $rep->fetchAll(PDO::FETCH_ASSOC);

        return $array;
    }
    //Fonction permettant de rechercher l'utilisateur d'un article(utilisé dans la page "detailArticle.php")
    function rechercheFournisseur($nArticle){
        include('co.php');
        
        $array = array();
        $rep;
        //Permet d'afficher la raisonSociale suivant le numéro de l'article
        $querySelectorFournisseur = "SELECT raisonSociale 
                                     FROM utilisateur 
                                     FULL JOIN article 
                                     ON article.idUtilisateur=utilisateur.idUtilisateur
                                     WHERE nArticle = $nArticle";
        
        $rep = $c->prepare($querySelectorFournisseur);
        $rep->execute();
        $rep = $rep->fetchAll(PDO::FETCH_ASSOC);
        $array = $rep;

        return $array;
    }
    //Permet d'ajouter une commande à l'utilisateur courrant(utilisé dans "détailArticle.php")
    function ajoutCommande($nArticle, $idUtil){
        include('co.php');
        //Permet d'afficher le stock d'un article suivant son nArticle
        $queryVerifQte="SELECT stock FROM article WHERE nArticle = $nArticle";
        $rep = $c->prepare($queryVerifQte);
        $rep->execute();
        $rep=$rep->fetchAll(PDO::FETCH_ASSOC);
        //Si le stock de l'article est strictement supérieur à 0, 
        //nous ajoutons une tupple dans la table "commande" prenant en valeur l'"id" de l'utilisateur et le "nArticle"
        if($rep[0]['stock']>0){
            //Ajout de la ligne commande
            $queryAddArticle="INSERT INTO Commande VALUES($idUtil, $nArticle)";
            $c->exec($queryAddArticle);
            //Update du stock dans la table "article" lorsque le stock est supérieur à 0
            $queryModifArt="UPDATE article SET stock=stock-1 where stock>0";
            $c->exec($queryModifArt);
            echo('Requête executé avec succes');
        }else{//Sinon le stock est insufisant
            echo('Le stock est insuffisant');
        }
    }
    //renvoie un array d'objets "Commande" pour les afficher dans la liste de commande page "commandesAc.php"
    function listeArticleCom($idUtilisateur){
        include('co.php');
        //Récupération de la classe "Commande"
        include('../classes/Commande.php');
        
        $listeArticle = array();
        $rep;
        $rep2;
        $Article;
        //Permet de récuperer les nCommande ainsi que les nArticle associés à l'utilisateur
        $querySelectCom="SELECT nCommande, nArticle FROM Commande WHERE IdUtilisateur = $idUtilisateur";

        $rep = $c->prepare($querySelectCom);
        $rep->execute();
        $rep = $rep->fetchAll(PDO::FETCH_ASSOC);
        $nArticle = array();
        

        //Nous parcourons le tabeleau pour effectuer la requête d'affichage ci-après pour chaque nArticle
        for ($i=0; $i<sizeof($rep); $i++){
            //Définition du nArticle pour chaque element du premier tableau
            $nArticle=$rep[$i]['nArticle'];
            //Définition du nCommande pour chaque element du premier tableau
            $nCommande=$rep[$i]['nCommande'];
            //Permet d'afficher les informations de l'article correspondant au nArticle
            $querySelectMCom="SELECT nArticle,nomArticle,prix FROM article WHERE nArticle=$nArticle";
            $rep2= $c->prepare($querySelectMCom);
            $rep2->execute();
            $rep2=$rep2->fetchAll(PDO::FETCH_ASSOC);
            //Création de l'objet "$Article"
            $Article = new Commande($rep2[0]['nArticle'], $rep2[0]['nomArticle'], $rep2[0]['prix'], $nCommande);
            //Ajoute l'objet créé au tableau
            $listeArticle[]=$Article;
        }
        //Renvoie un tableau d'objet "Commande"
        return $listeArticle;
    }
    //Fonction de modification d'article utilisé dans la page "modifArticle.php" 
    function modifArticle($nArticle, $raisonSociale, $ancienNomArticle, $nomArticle, $prixArticle, $stock, $desc){
        include('co.php');
        
        $rep;
        //Permet la mise à jour des champs de l'article
        $queryModifArt="UPDATE article SET nomArticle='$nomArticle', prix='$prixArticle',description='$desc',stock=$stock WHERE nArticle=$nArticle";
        //Vérification de l'existance de l'article
        if(!articleExiste($nomArticle,$raisonSociale)||$ancienNomArticle==$nomArticle){
            $c->exec($queryModifArt);
            echo ('La modification a été effectué avec succès');
        }else{//Si l'article existe nous renvoyons le message suivant
            echo('L\'article existe déjà');
        }
    }
    //Méthode permettant d'annuler une commande dans la page "commandesAc.php" utilisé dans la page "commandesAc.php"
    function supprCom($nCom, $nArticle){
        include('co.php');

        $rep;
        //Suppression de la commande suivant son numéro
        $queryDelCom="DELETE FROM commande WHERE nCommande=$nCom";
        $c->exec($queryDelCom);
        //Mise à jour du stock de l'article dont la commande à été annulé
        $queryRajoutProd="UPDATE article SET stock=stock+1 WHERE nArticle=$nArticle";
        $c->exec($queryRajoutProd);
    }
?>