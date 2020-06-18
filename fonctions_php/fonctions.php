<?php

    include('co.php');

    function articleExiste($nomArticle, $raisonSociale){
        include('co.php');
                        
        $queryArticle= "SELECT nomArticle 
                        FROM utilisateur 
                        FULL JOIN article ON utilisateur.idUtilisateur=article.idUtilisateur 
                        WHERE raisonSociale='$raisonSociale' AND nomArticle = '$nomArticle'";
        
        $exist = $c->prepare($queryArticle);
        $exist->execute();
        $exist = $exist->fetchAll();

        if(sizeof($exist)==0){
            return false;
        }else{
            return true;
        }
        return true;
    }
    function tableauArticles($raisonSociale){
        include('co.php');
        $array = array();
        $rep;
        $querySelect = "SELECT nArticle, nomArticle, prix, stock, cat, raisonSociale 
                        FROM article 
                        FULL JOIN utilisateur 
                        ON article.idUtilisateur = utilisateur.idUtilisateur
                        WHERE raisonSociale = '$raisonSociale'";
        
        $rep = $c->prepare($querySelect);
        $rep->execute();
        $rep = $rep-> fetchAll(PDO::FETCH_ASSOC);
        
        $array =$rep;

        return $array;
    }
    function tableauAllArticles(){
        include('co.php');
        $array = array();
        $rep;
        
        $querySelect = "SELECT nArticle, nomArticle, prix, stock, cat
                        FROM article WHERE prix>0 AND stock>0";
        
        $rep = $c->prepare($querySelect);
        $rep->execute();
        $rep = $rep-> fetchAll(PDO::FETCH_ASSOC);
        
        $array =$rep;

        return $array;
    }
    function recupArticle($nArticle){
        include('co.php');
        $array = array();
        $rep;

        $querySelectArticle = "SELECT * FROM article WHERE nArticle = $nArticle";
        $rep = $c->prepare($querySelectArticle);
        $rep->execute();
        $array = $rep->fetchAll(PDO::FETCH_ASSOC);

        return $array;
    }
    function rechercheFournisseur($nArticle){
        include('co.php');
        
        $array = array();
        $rep;

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
    function ajoutCommande($nArticle, $idUtil){
        include('co.php');
        
        $queryVerifQte="SELECT stock FROM article WHERE nArticle = $nArticle";
        $rep = $c->prepare($queryVerifQte);
        $rep->execute();
        $rep=$rep->fetchAll(PDO::FETCH_ASSOC);
        if($rep[0]['stock']>0){
            $queryAddArticle="INSERT INTO Commande VALUES($idUtil, $nArticle)";
            $c->exec($queryAddArticle);
            $queryModifArt="UPDATE article SET stock=stock-1 where stock>0";
            $c->exec($queryModifArt);
            echo('Requête executé avec succes');
        }else{
            echo('Le stock est insuffisant');
        }
    }
    function listeArticleCom($idUtilisateur){
        include('co.php');
        include('../classes/Commande.php');
        
        $listeArticle = array();
        $rep;
        $rep2;
        $Article;

        $querySelectCom="SELECT nCommande, nArticle FROM Commande WHERE IdUtilisateur = $idUtilisateur";

        $rep = $c->prepare($querySelectCom);
        $rep->execute();
        $rep = $rep->fetchAll(PDO::FETCH_ASSOC);
        $nArticle = array();
        


        for ($i=0; $i<sizeof($rep); $i++){
            $nArticle=$rep[$i]['nArticle'];
            $nCommande=$rep[$i]['nCommande'];
            $querySelectMCom="SELECT nArticle,nomArticle,prix FROM article WHERE nArticle=$nArticle";
            $rep2= $c->prepare($querySelectMCom);
            $rep2->execute();
            $rep2=$rep2->fetchAll(PDO::FETCH_ASSOC);
            $Article = new Commande($rep2[0]['nArticle'], $rep2[0]['nomArticle'], $rep2[0]['prix'], $nCommande);
            $listeArticle[]=$Article;
        }
        
        return $listeArticle;
    }
    function modifArticle($nArticle, $raisonSociale, $ancienNomArticle, $nomArticle, $prixArticle, $stock, $desc){
        include('co.php');
        
        $rep;
        $queryModifArt="UPDATE article SET nomArticle='$nomArticle', prix='$prixArticle',description='$desc',stock=$stock WHERE nArticle=$nArticle";
        
        if(!articleExiste($nomArticle,$raisonSociale)||$ancienNomArticle==$nomArticle){
            $c->exec($queryModifArt);
            echo ('La modification a été effectué avec succès');
        }else{
            echo('L\'article existe déjà');
        }
    }
    function supprCom($nCom, $nArticle){
        include('co.php');

        $rep;

        $queryDelCom="DELETE FROM commande WHERE nCommande=$nCom";
        $c->exec($queryDelCom);

        $queryRajoutProd="UPDATE article SET stock=stock+1 WHERE nArticle=$nArticle";
        $c->exec($queryRajoutProd);
    }
?>