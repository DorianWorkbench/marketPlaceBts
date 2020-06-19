<header>
    <nav class="containerNav">
        <span class="titleHeader">Marketplace</span>
        <ul class="containerLi">
            <?php
                //Modifie l'affichage de la bar de navigation suivant le type d'utilisateur
                if(isset($_SESSION['idUtilisateur'])){
                    if($_SESSION['type']=="FO"){
                        echo '<li><a href="/marketplace_pro/index_fo.php">Accueil</a></li>';
                    }else if($_SESSION['type']=="AC"){
                        echo '<li><a href="/marketplace_pro/index.php">Accueil</a></li>';
                    } 
                }else{
                    echo '<li><a href="/marketplace_pro/index.php">Accueil</a></li>';
                }
            ?>
            <?php
                //Modifie l'affichage de la bar de navigation suivant le type d'utilisateur
                if(isset($_SESSION['idUtilisateur'])){
                    if($_SESSION['type']=="FO"){
                        echo '<li><a href = "/marketplace_pro/pages/profilFo.php">'.$_SESSION['raisonSociale'].'</a></li>';
                    }else if($_SESSION['type']=="AC"){
                        echo '<li><a href = "/marketplace_pro/pages/profilAc.php">'.$_SESSION['prenom'].'</a></li>';
                    }
                }else{
                    echo '<li><a href = "/marketplace_pro/pages/connexion.php">Connexion</a></li>';
                }
            ?>
            <?php
                //Modifie l'affichage de la bar de navigation suivant le type d'utilisateur
                if(isset($_SESSION['idUtilisateur'])){
                    if($_SESSION['type']=="AC"){
                        echo "<li><a href=\"/marketplace_pro/pages/commandesAc.php\">Commandes</a></li>";
                    }
                    else{
                        echo "<li><a href=\"/marketplace_pro/pages/ajoutArticles.php\">Ajout</a></li>";
                    }
                }else{
                    echo "<li><a href=\"/marketplace_pro/pages/inscription.php\">Inscription</a></li>";
                }
            ?>
            <?php
                if(!empty($_SESSION['idUtilisateur'])){
                    //Création d'un formulaire où l'action du bouton sera écoutée sur la page index.php 
                    echo "<form action=\"/marketplace_pro/index.php\" method=\"post\">";
                        echo "<li><button type=\"submit\" name=\"deco\" class=\"deco\">Déconnexion</a></li>";
                    echo "</form>";
                }
                
            ?>
        </ul>        
    </nav>
</header>