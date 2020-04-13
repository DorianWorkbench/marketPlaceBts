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
        $querySelect = "SELECT nomArticle, prix, stock, cat, raisonSociale 
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
        
        $querySelect = "SELECT nomArticle, prix, stock, cat
                        FROM article";
        
        $rep = $c->prepare($querySelect);
        $rep->execute();
        $rep = $rep-> fetchAll(PDO::FETCH_ASSOC);
        
        $array =$rep;

        return $array;
    }
?>