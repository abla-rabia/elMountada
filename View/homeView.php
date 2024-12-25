<?php
require_once("Controller\homeController.php");
class homeView{

    public function entetePage(){
        ?>
        <head>
            <title>El Mountada</title>
            <link rel="stylesheet" href="View/css/homeStyle.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <script src="View/scripts/homeScript.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        </head>
        <?php   
    }
    public function button($content){
        ?>
        <button id="boutton">Se Connecter</button>
        <?php
    }
    public function navBarD(){
        ?>
        <nav>
            <a href="#"><img src="View/assets/logo.png" alt="logo light mode" width="120px"></a>
            <a href="">Accueil</a>
            <a href="">Partenaires</a>
            <a href="">Offres</a>
            <a href="">Rejoingez nous</a>
            <li id="subMenuP">
                Dons & bénévolats
                <ul id="subMenu">
                    <a>Demande d'aide</a>
                    <a>Bénévolat</a>
                    <a>Faire un don</a>
                </ul>
            </li>
            <?php
            $this->button("Se Connecter")
            ?>
        </nav>
        
        <?php
    }
    public function slider(){
        ?>
        <div class="sliderImg">
            <div class="header">
                <img src="View/assets/logowhite.png" alt="logo light mode">
                <div class="socialMedia">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                </div>
            </div>
            <div class="text" id="textContainer">
                <h2 id="title">Oceanview Hotel News</h2>
                <p id="content">Our Winter Getaway Package is here! Enjoy 20% off, free breakfast, and access to the rooftop pool. Book now for stays from Dec 15 to Feb 28!</p>
            </div>
            <div class="barres">
                <h3>_</h3>
                <h3>_</h3>
                <h3>_</h3>
            </div>
        </div>
        <?php
    }
    public function afficher_page(){
        ?>
        <html >
            
            <?php
            $this->entetePage();
            ?>
            <body>
            <?php
                $this->slider();
                $this->navBarD();
            ?>
            </body>
    
        </html>
        <?php
    
    }
}
?>

