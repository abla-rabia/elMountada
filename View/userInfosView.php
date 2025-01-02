<?php
require_once("Controller\userInfosController.php");
require_once("commonViews.php");
class userInfosView{
public function entetePage(){
    ?>
    <head>
        <title>Mes information</title>
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
            <div class="content ">
                <?php
                    $r->titre("Mon profile");
                    ?>
                    <div class="subContent">
                        <?php
                            $r->memberSideBar("infos");
                        ?>
                        <form action="" method="POST" class="infosForm" id="infosForm">
                        <input type="hidden" name="id" value="<?=$_SESSION['user']['id']?>">
                            <div class="lineContainer">
                        <div class="line">
                            <?php
                                $r->famousInput2("Prénom",$_SESSION['user']['prenom'],"text","prenom");
                                $r->famousInput2("Nom",$_SESSION['user']['nom'],"text","nom");
                            ?>
                        </div>
                        <div class="line">
                            <?php
                                $r->famousInput2("Date de naissance",$_SESSION['user']['birthDate'],"date","birthDate");
                                $r->famousInput2("Numéro de téléphone",$_SESSION['user']['telNumber'],"tel","telNumber");
                            ?>
                        </div>
                        </div>
                        <div class="buttonContainer">
                        <div class="buttonSubContainer">
                        <?php
                        $r->blueButton2("Enregistrer les modifications","infosButton");
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
