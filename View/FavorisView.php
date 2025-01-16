<?php
require_once(ROOT . '/Controller/userController.php');
require_once("commonViews.php");
class FavorisView{
public function entetePage(){
    ?>
    <head>
        <title>Mes favoris</title>
        <link rel="stylesheet" href="View/css/catalogueStyle.css">
        <link rel="stylesheet" href="View/css/commonStyles.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="View/scripts/favoris.js"></script>
        
    </head>
    <?php   
}




public function section(){
    $r = new commonViews();
    ?>
    <div class="cartesPartenaire">
    </div>
    <?php
}
public function afficher_page(){
    $r = new commonViews();
    ?>
    <html >
        
        <?php
        $this->entetePage();
        ?>
        <body class="favoris">
        <?php
            $r->navBar();
            $r->titre("Mes favoris");
            ?>
            <div class="sections">
            <?php
            $this->section();
 
            ?>
            </div>
        </body>

    </html>
    <?php

}
}
?>
