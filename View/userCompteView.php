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
        <script src="View/scripts/infosScript.js"></script>
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
                        
                        <form method="POST" id="compteForm" class="compteForm">
                        <input type="hidden" name="id" value="<?=$_SESSION['user']['id']?>">
                        <div class="contentContainer">
                            <div class="col">
                            <?php
                                $r->famousInput2("Username",$_SESSION['user']['username'],"text","username");
                                $r->famousInput2("Email",$_SESSION['user']['email'],"email","email");
                            ?>
                            </div>
                            <div class="photo">
                            <img src="<?= !empty($_SESSION['user']['photoProfile']) ? $_SESSION['user']['photoProfile'] : 'View/assets/user2.png' ?>"  width="150px" height="150px" alt="" id="photoPdp">
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
