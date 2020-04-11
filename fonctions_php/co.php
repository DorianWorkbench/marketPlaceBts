<?php
    try{
        $c = new PDO("sqlsrv:Server=DESKTOP-CJC5BPT\SQLEXPRESS;Database=marketplaceApi", "sa", "tennis");
    }catch(Exception $e){
        echo "Erreur lors de la connexion";
    }
?>