<?php
    //Création de la classe commande me permettant de récuperer un tableau de commande dans la page "commandeAc.php"
    class Commande{
        
        //Attributs
        private $nArticle;
        private $nomArticle;
        private $prixArticle;
        private $nCommande;
        //Constante
        private $QTE=1;

        //Définition du constructeur de la classe prenant en paramètres le numéro de l'article, son nom, son prix et son numéro de commande
        public function __construct($nArticle, $nomArticle, $prixArticle, $nCommande){
            $this->nArticle=$nArticle;
            $this->nomArticle = $nomArticle;
            $this->prixArticle = $prixArticle;
            $this->nCommande = $nCommande;
        }
        
        //Définition des getters de la classe
        public function getNarticle(){
            return $this->nArticle;
        }
        public function getNomArticle(){
            return $this->nomArticle;
        }
        public function getPrixArticle(){
            return $this->prixArticle;
        }
        public function getNcommande(){
            return $this->nCommande;
        }
    } 
?>