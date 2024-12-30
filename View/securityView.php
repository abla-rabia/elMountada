<?php
require_once("Controller\securityController.php");
require_once("commonViews.php");
class securityView{
public function entetePage(){
    ?>
    <head>
        <title>Mes information</title>
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
                            $r->memberSideBar("secure");
                        ?>
                        <form action="" class="infosForm">
                            <div class="lineContainer">
                        <div class="line">
                            <?php
                                $r->famousInput2("Mot de passe","********","password");
                                $r->famousInput2("Cofirmer le mot de passe","********","password");
                            ?>
                        </div>
                        <ul id="rules">
                        <li>Au moins 8 caractères.</li>
                        <li>Doit inclure une majuscule, une minuscule et un chiffre.</li>
                        <li>Au moins un caractère spécial (ex. !@#$%^&*).</li>
                        <li>Le mot de passe et sa confirmation doivent être identiques.</li>
                        </ul>
                        </div>
                        <div class="buttonContainer">
                        <div class="buttonSubContainer">
                        <?php
                        $r->blueButton2("Modifier le mot de passe","passButton");
                        ?>
                        </div>
                        </div>
                        </form>
                    </div>
                

            </div>
        </body>
        <script>
            let img = document.getElementsByClassName("userImg")[0];
            let box = document.getElementById("userBox");
            img.addEventListener("click", function (event) {
                box.style.display = box.style.display === "none" || !box.style.display ? "flex" : "none";
                event.stopPropagation(); // Prevent the event from propagating to the document
            });
            document.addEventListener("click", function (event) {
                if (box.style.display === "flex" && !box.contains(event.target) && event.target !== img) {
                box.style.display = "none";
                }
            });

        </script>
    </html>
    <?php

}
}
?>
