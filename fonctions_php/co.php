<?php
    // try{
    //     $c = new PDO("sqlsrv:Server=DESKTOP-CJC5BPT\SQLEXPRESS;Database=test2", "sa", "tennis");
    // }catch(Exception $e){
    //     echo "Erreur lors de la connexion";
    // }
    try {
        $c = new PDO("sqlsrv:server = tcp:b9al9h5psh.database.windows.net,1433; Database = marketplaceApi", "brebisepa", "Poncho2013*");
        $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
        print("Error connecting to SQL Server.");
        die(print_r($e));
    }
?>