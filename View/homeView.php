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
    public function newsCard(){
        ?>
        <div class="newsCard">
            <h4>News about hospital</h4>
            <p>Our Winter Getaway Package is here! Enjoy 20% off, free breakfast, and access to the rooftop pool. Book now for stays from Dec 15 to Feb 28!</p>
        </div>
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

    //Fonction pour les titres de chauque section
    public function titleSection($titre){
        ?>
        <h2 class="titreSection"><?= $titre ?> <i class="fa-solid fa-paperclip"></i></h2>

        <?php
    }
    //Fonction du slider
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
    //Fonction de la section news : 
    public function newsSection(){
        ?>        
        <div class="newsSection">
        <?php  
        $this->titleSection("News");
        ?>        
        <div class="cards">
            <?php   
                $this->newsCard();
                $this->newsCard();
                $this->newsCard();
            ?>
        </div>
        </div>
        <?php   
    }

    public function partenairesSection(){
        ?>
        <div class="partenairesSection">
        <?php
        $this->titleSection("Nos Partenaire")
        ?>
        <div class="logos">
            <div class="logos-slider">
            <img src="View/assets/logos/apple-14.svg" alt="apple logo" width="100px">
            <img src="View/assets/logos/aston-hotel.svg" alt="hotel logo" width="100px">
            <img src="View/assets/logos/bmw-logo.svg" alt="bmw logo" width="100px">
            <img src="View/assets/logos/random.svg" alt="random logo" width="100px">
            </div>
            <div class="logos-slider">
            <img src="View/assets/logos/apple-14.svg" alt="apple logo" width="100px">
            <img src="View/assets/logos/aston-hotel.svg" alt="hotel logo" width="100px">
            <img src="View/assets/logos/bmw-logo.svg" alt="bmw logo" width="100px">
            <img src="View/assets/logos/random.svg" alt="random logo" width="100px">
            </div>
        </div>
        </div>
        <?php
    }

    public function offresSection(){
        ?>
        <div class="offresSection">
        <?php
        $this->titleSection("Nos Offres")
        ?>
        <table id="offersTable">
        <tr>
            <td>Ville</td>
            <td>Catégorie</td>
            <td>Partenaire</td>
            <td>Offre</td>
        </tr>
        <tr>
            <td>Alger</td>
            <td>Hotel</td>
            <td>Sofitel</td>
            <td>50%</td>
        </tr>
        <tr>
            <td>Alger</td>
            <td>Hotel</td>
            <td>Sofitel</td>
            <td>50%</td>
        </tr>
        <tr>
            <td>Alger</td>
            <td>Hotel</td>
            <td>Sofitel</td>
            <td>50%</td>
        </tr>
        <tr>
            <td>Alger</td>
            <td>Hotel</td>
            <td>Sofitel</td>
            <td>50%</td>
        </tr>
        <tr>
            <td>Alger</td>
            <td>Hotel</td>
            <td>Sofitel</td>
            <td>50%</td>
        </tr>
        <tr>
            <td>Alger</td>
            <td>Hotel</td>
            <td>Sofitel</td>
            <td>50%</td>
        </tr>
        <tr>
            <td>Alger</td>
            <td>Hotel</td>
            <td>Sofitel</td>
            <td>50%</td>
        </tr>
        <tr>
            <td>Alger</td>
            <td>Hotel</td>
            <td>Sofitel</td>
            <td>50%</td>
        </tr>
        <tr>
            <td>Alger</td>
            <td>Hotel</td>
            <td>Sofitel</td>
            <td>50%</td>
        </tr>
        <tr>
            <td>Alger</td>
            <td>Hotel</td>
            <td>Sofitel</td>
            <td>50%</td>
        </tr>
       </table>
        </div>
        <?php
    }
    public function contactText(){
        ?>
        <div class="contactText">
        <h1>Contactez nous !</h1>
        <p>Questions, commentaires ou suggestions ? Remplissez simplement ce formulaire !</p>
        <div class="contacts">
        <h3><i class="fa-solid fa-location-dot"></i>ESI, Oued Smar, Alger, Algérie</h3>
        <h3><i class="fa-solid fa-phone-volume"></i></i>+1 234 678 9108 99</h3>
        <h3><i class="fa-solid fa-envelope"></i></i>Contact@elMountada.com</h3>
        </div>
        </div>
        <?php

    }
    public function contactCard(){
        ?>
        <div class="contactCard">
        <div class="nomPrenom">
            <input type="text" value="Abla" placeholder="Prénom*">
            <input type="text"  placeholder="Nom*">
        </div>
        <input type="text" placeholder="Email*">
        <input type="text" placeholder="Numéro de téléphone*">
        <Textarea placeholder="Votre messge"></Textarea>
        <input type="submit" value="Envoyer le message">
        </div>
        <?php
    }
    public function contactSection(){
        
        ?>
        <div class="contactSectionG">
        <h2 class="titreSection">Contactez nous </h2>
        <div class="contactSection">
        <?php
            $this->contactText();
            $this->contactCard();
            ?>
        </div>
        </div>
        <?php

    }
    public function descriptionPart(){
        ?>
        <div class="descriptionPart">
            <img src="View/assets/logowhite.png" alt="logo light mode" width="150px">
            <p>Our Winter Getaway Package is here! Enjoy 20% off, free breakfast, and access to the rooftop pool. Book now for stays from Dec 15 to Feb 28!</p>
            <div class="socialMedia">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
            </div>
        </div>
        <?php
    }
    public function navigationPart(){
        ?>
        <div class="navigationPart">
            <div class="part">
                <h3>Menu</h3>
                  <a href="#">Accueil</a>
                  <a href="#">Partenaires</a>
                    <a href="#">Offres</a>
                    <a href="#">Rejoingez nous</a>
            </div>
            <div class="part">
                <h3>Sections</h3>
                  <a href="#">News</a>
                  <a href="#">Nos partenaires</a>
                    <a href="#">Nos offres</a>
                    <a href="#">Contactez nous</a>
            </div>
        </div>
        <?php
    }

    public function footer(){
        ?>
        <footer>
        <?php
        $this->descriptionPart();
        $this->navigationPart();
        ?>  
        </footer>
        <?php
    }

    //Fonction d'affichade de la page : 
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

                $this->newsSection();
                $this->partenairesSection();
                $this->offresSection();
                $this->contactSection();
                $this->footer();
                ?>
            </body>
    
        </html>
        <?php
    
    }
}
?>









