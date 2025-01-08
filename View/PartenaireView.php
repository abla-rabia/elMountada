<?php
require_once(ROOT . '/Controller/partenaireController.php');
require_once("commonViews.php");
class partenaireView{
public function entetePage($nomPartenaire){
    ?>
    <head>
        <title><?=$nomPartenaire?></title>
        <link rel="stylesheet" href="View/css/partenaireStyles.css">
        <link rel="stylesheet" href="View/css/commonStyles.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="View/scripts/partenaireScript.js"></script>
        
    </head>
    <?php   
}

public function partnerView(){
    ?>
    <div class="partnerView">
                <img src="View/assets/slider3.png" alt="partner image">
                <div class="leftPart">
                    <div class="navigation">
                        <p>Catalogue ></p>
                        <p class="cat" id="categp"> ></p>
                        <p class="name" id="nomp"></p>
                    </div>
                    
                    <h2 class="title" id="nompL"></h2>
                    <p id="descriptionp">This (Hons) Business and Management BSc course from University of Essex Online will help you adapt to the ever-changing world of business. We’ll examine a range of real-world business examples and use them to develop the broad skillset that a good manager should be able to draw from.</p>
                        
                        <p class="wilaya"><i class="fa-solid fa-location-dot"></i>Wilaya : <span id="wilayaP"></span></p>
                </div>
                
            </div>
    <?php
}

public function aboutSection(){
    ?>
    <section class="about">
                    <h3>A propos</h3>
                    <p class="aboutUs">
                    This (Hons) Business and Management BSc course from University of Essex Online will help you adapt to the ever-changing world of business. We’ll examine a range of real-world business examples and use them to develop the broad skillset that a good manager should be able to draw from.
                    </p>
                    <h3>Contact</h3>
                    <ul class="contact">
                        <li><i class="fa-solid fa-phone-volume"></i> <span id="phoneP">+213 555 55 55 88</span></li>
                        <li><i class="fa-solid fa-envelope"></i> <span id="emailP">la_rabia@esi.dz</span></li>
                        <li><i class="fa-solid fa-globe"></i> <a href="#" id="webP">Notre site</a></li>
                    </ul>
                </section>
    <?php
}

public function avisSection(){
    $r = new commonViews();
    ?>
    <section class="avis">
                    <div class="top">
                    <h3>Avis</h3>
                    <div class="buttonContainer">
                    <?php
                    $r->blueButton2("Ajouter un avis","avisButton");
                    ?>
                    </div>
                    </div>
                    <div class="comments">
                    <div class="comment">
                        <div class="head">
                            <div class="profile">
                                <img src="View/assets/user.png" alt="user img">
                                <p class="name">Abla RABIA</p>
                            </div>
                            <div class="stars">
                                
                                <label for="rating1" class="fa-solid fa-star"></label>
                                
                                <label for="rating2" class="fa-solid fa-star"></label>
                                
                                <label for="rating3" class="fa-solid fa-star"></label>
                                
                                <label for="rating4" class="fa-solid fa-star"></label>
                                
                                <label for="rating5" class="fa-solid fa-star"></label>
                            </div>
                        </div>
                            <p id="comment">The best hotel in the world</p>
                            <p id="date">26-01-2024</p>
                    </div>
                    <div class="comment">
                        <div class="head">
                            <div class="profile">
                                <img src="View/assets/user.png" alt="user img">
                                <p class="name">Abla RABIA</p>
                            </div>
                            <div class="stars">
                            <label for="rating1" class="fa-solid fa-star"></label>
                                
                                <label for="rating2" class="fa-solid fa-star"></label>
                                
                                <label for="rating3" class="fa-solid fa-star"></label>
                                
                                <label for="rating4" class="fa-solid fa-star"></label>
                                
                                <label for="rating5" class="fa-solid fa-star"></label>
                            </div>
                        </div>
                            <p id="comment">The best hotel in the world</p>
                            <p id="date">26-01-2024</p>
                    </div>
                    <div class="comment">
                        <div class="head">
                            <div class="profile">
                                <img src="View/assets/user.png" alt="user img">
                                <p class="name">Abla RABIA</p>
                            </div>
                            <div class="stars">
                            <label for="rating1" class="fa-solid fa-star"></label>
                                
                                <label for="rating2" class="fa-solid fa-star"></label>
                                
                                <label for="rating3" class="fa-solid fa-star"></label>
                                
                                <label for="rating4" class="fa-solid fa-star"></label>
                                
                                <label for="rating5" class="fa-solid fa-star"></label>
                            </div>
                        </div>
                            <p id="comment">The best hotel in the world</p>
                            <p id="date">26-01-2024</p>
                    </div>
                    </div>
                </section>
                
    <?php
}


public function afficher_page($id){
    $r = new commonViews();
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <?php
            $this->entetePage("Sofitel");
            ?>
        </head>
        <body>
        <input type="hidden" name="id" id="partId" value="<?=$id?>">
            <?php
            $r->navBar();
            $this->partnerView();
            ?>
    
            <div class="sections">
                <?php
                $this->aboutSection();
                $this->avisSection();
                ?>
            </div>
            <?php
            $r->avisPopup();
            ?>
        </body>
    </html>
    <?php

}
}
?>
