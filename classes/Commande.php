<?php
    class Commande{
        
        //Attributs
        private $nArticle;
        private $nomArticle;
        private $prixArticle;
        private $nCommande;
        private $QTE=1;

        
        public function __construct($nArticle, $nomArticle, $prixArticle, $nCommande){
            $this->nArticle=$nArticle;
            $this->nomArticle = $nomArticle;
            $this->prixArticle = $prixArticle;
            $this->nCommande = $nCommande;
        }

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