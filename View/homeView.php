<?php

require_once("Controller\homeController.php");
require_once("commonViews.php");
class homeView{

    public function entetePage(){
        ?>
        <head>
            <title>El Mountada</title>
            <link rel="stylesheet" href="View/css/homeStyle.css">
            <link rel="stylesheet" href="View/css/commonStyles.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script src="View/scripts/homeScript.js"></script>
            
            
        </head>
        <?php   
    }
    
    public function newsCard($title, $content){
        ?>
        <div class="newsCard">
            <h4><?= $title ?></h4>
            <p><?= $content ?></p>
        </div>
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
                <h2 id="title"></h2>
                <p id="content"></p>
            </div>
            <div class="barres">
                <h3>_</h3>
                <h3>_</h3>
                <h3>_</h3>
            </div>
        </div>
        <?php
    }
    //fonction de la section news : 
    public function newsSection(){
        ?>        
        <div class="newsSection">
        <?php  
        $this->titleSection("News");
        ?>        
        <div class="cards" id="newsCards">
            
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
            </div>
            <div class="logos-slider">

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
        <tr class="head">
        <td onclick="sortTable('partenaireVille')">Ville</td>
        <td onclick="sortTable('partenaireCategorie')">Catégorie</td>
        <td onclick="sortTable('partenaireNom')">Partenaire</td>
        <td onclick="sortTable('offreContenu')">Offre</td>
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
        <form action="" class="contactCard">
        <div class="nomPrenom">
            <input type="text" value="Abla" placeholder="Prénom*">
            <input type="text"  placeholder="Nom*">
        </div>
        <input type="text" placeholder="Email*">
        <input type="text" placeholder="Numéro de téléphone*">
        <Textarea placeholder="Votre messge"></Textarea>
        <input type="submit" value="Envoyer le message">
        </form>
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
            <p>Elmountada est une association caritative qui soutient les personnes vulnérables à travers des actions d’entraide, d’éducation et d’aide humanitaire, avec pour mission de favoriser la solidarité et l’inclusion.</p>
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
                  <a href="index.php?router=Page%20d'accueil">Accueil</a>
                  <a href="index.php?router=Catalogue">Partenaires</a>
                    <a href="index.php?router=afficherPageOffresV">Offres</a>
                    <a href="index.php?router=Inscription">Rejoingez nous</a>
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

    //Fonction d'affichage de la page : 
    public function afficher_page(){
        $r = new commonViews();
        ?>
        <html >
            
            <?php
            $this->entetePage();
            ?>
            <body class="home">
            <?php
                $this->slider();
                $r->navBar();

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









