<?php
require_once("Controller\userCompteController.php");
require_once("commonViews.php");
class userCompteView{
public function entetePage(){
    ?>
    <head>
        <title>Mon compte</title>
        <link rel="stylesheet" href="View/css/userInfosStyle.css">
        <link rel="stylesheet" href="View/css/commonStyles.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        
    </head>
    <?php   
}


public function afficher_page(){
    $r = new commonViews();
    ?>
    <html >
        
        <?php
        $this->entetePage();
        ?>
        <body class="to">
        <?php
            $r->navBarC();
            ?>
            <div class="content">
                <?php
                    $r->titre("Mon profile");
                    ?>
                    <div class="subContent">
                        <?php
                            $r->memberSideBar("compte");
                        ?>
                        
                        <form action="" class="compteForm">
                        <div class="contentContainer">
                            <div class="col">
                            <?php
                                $r->famousInput2("Username","abla-rabia","text");
                                $r->famousInput2("Email","la_rabia@esi.dz","email");
                            ?>
                            </div>
                            <div class="photo">
                            <img src="View/assets/user2.png" width="150px" alt="">
                            <div class="inputPhoto">
                                <label for="photoInput" id="photoPen"><i class="fa-solid fa-pen"></i></label>
                                <input type="file" name="photoInput" id="photoInput">
                            </div>
                            </div>
                            </div>
                        <div class="buttonContainer">
                        <div class="buttonSubContainer">
                        <?php
                        $r->blueButton2("Enregistrer les modifications","compteButton");
                        ?>
                        </div>
                        </div>
                        
                        </form>
                    </div>
                

            </div>
        </body>
        
    </html>
    <?php

}
}
?>
