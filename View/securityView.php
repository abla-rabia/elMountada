<?php
require_once("Controller\securityController.php");
require_once("commonViews.php");

class securityView {
    public function entetePage() {
        ?>
        <head>
            <title>Mes informations</title>
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

    public function afficher_page() {
        if (!isset($_SESSION['user']) && !isset($_SESSION['member']) && !isset($_SESSION['partenaire']) && !isset($_SESSION['admin'])) {
            echo "Access denied.";
            return;
        }

        $r = new commonViews();
        ?>
        <html>
            <?php
            $this->entetePage();
            ?>
            <body class="to">
                <?php
                $r->navBar();
                ?>
                <div class="content">
                    <?php
                    $r->titre("Mon profile");
                    ?>
                    <div class="subContent">
                        <?php
                        $r->memberSideBar("secure");
                        ?>
                        <form action="" class="infosForm" id="secureForm">
                            <div class="lineContainer">
                                <div class="line">
                                    <?php
                                    $r->famousInput("Mot de passe", "********", "password", "password");
                                    $r->famousInput("Confirmer le mot de passe", "********", "password", "password2");
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
                                    $r->blueButton2("Modifier le mot de passe", "passButton");
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
