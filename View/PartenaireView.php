<?php
require_once("Controller\partenaireController.php");
require_once("commonViews.php");
class partenaireView{
public function entetePage($nomPartenaire){
    ?>
    <head>
        <title><?=$nomPartenaire?></title>
        <link rel="stylesheet" href="View/css/partenaireStyles.css">
        <link rel="stylesheet" href="View/css/commonStyles.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <script src="View/scripts/homeScript.js"></script>
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
        $this->entetePage("Sofitel");
        ?>
        <body>
        <?php
            $r->navBarD();
            
            ?>

            <div class="partnerView">
                <img src="View/assets/slider3.png" alt="partner image">
                <div class="leftPart">
                    <div class="navigation">
                        <p>Catalogue ></p>
                        <p class="cat">Hôtel ></p>
                        <p class="name">Sofitel</p>
                    </div>
                    
                    <h2 class="title">Sofitel</h2>
                    <p id="description">This (Hons) Business and Management BSc course from University of Essex Online will help you adapt to the ever-changing world of business. We’ll examine a range of real-world business examples and use them to develop the broad skillset that a good manager should be able to draw from.</p>
                        
                        <p class="wilaya"><i class="fa-solid fa-location-dot"></i>Wilaya : Alger</p>
                    </div>
                
            </div>
            <div class="sections">
                <section class="about">
                    <h3>A propos</h3>
                    <p class="aboutUs">
                    This (Hons) Business and Management BSc course from University of Essex Online will help you adapt to the ever-changing world of business. We’ll examine a range of real-world business examples and use them to develop the broad skillset that a good manager should be able to draw from.
                    </p>
                    <h3>Contact</h3>
                    <ul class="contact">
                        <li><i class="fa-solid fa-phone-volume"></i> +213 555 55 55 88</li>
                        <li><i class="fa-solid fa-envelope"></i> la_rabia@esi.dz</li>
                        <li><i class="fa-solid fa-globe"></i> <a href="#">Notre site</a></li>
                    </ul>
                </section>
                <section class="avis">
                    <div class="top">
                    <h3>Avis</h3>
                    <?php
                    $r->blueButton("Ajouter un avis","");
                    ?>
                    </div>
                    <div class="comments">
                    <div class="comment">
                        <div class="head">
                            <div class="profile">
                                <img src="View/assets/user.png" alt="user img">
                                <p class="name">Abla RABIA</p>
                            </div>
                            <div class="stars">
                                <input type="radio" name="rating1" id="rating1">
                                <label for="rating1" class="fa-solid fa-star"></label>
                                <input type="radio" name="rating1" id="rating2">
                                <label for="rating2" class="fa-solid fa-star"></label>
                                <input type="radio" name="rating1" id="rating3">
                                <label for="rating3" class="fa-solid fa-star"></label>
                                <input type="radio" name="rating1" id="rating4">
                                <label for="rating4" class="fa-solid fa-star"></label>
                                <input type="radio" name="rating1" id="rating5">
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
                                <input type="radio" name="rating1" id="rating1">
                                <label for="rating1" class="fa-solid fa-star"></label>
                                <input type="radio" name="rating1" id="rating2">
                                <label for="rating2" class="fa-solid fa-star"></label>
                                <input type="radio" name="rating1" id="rating3">
                                <label for="rating3" class="fa-solid fa-star"></label>
                                <input type="radio" name="rating1" id="rating4">
                                <label for="rating4" class="fa-solid fa-star"></label>
                                <input type="radio" name="rating1" id="rating5">
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
                                <input type="radio" name="rating1" id="rating1">
                                <label for="rating1" class="fa-solid fa-star"></label>
                                <input type="radio" name="rating1" id="rating2">
                                <label for="rating2" class="fa-solid fa-star"></label>
                                <input type="radio" name="rating1" id="rating3">
                                <label for="rating3" class="fa-solid fa-star"></label>
                                <input type="radio" name="rating1" id="rating4">
                                <label for="rating4" class="fa-solid fa-star"></label>
                                <input type="radio" name="rating1" id="rating5">
                                <label for="rating5" class="fa-solid fa-star"></label>
                            </div>
                        </div>
                            <p id="comment">The best hotel in the world</p>
                            <p id="date">26-01-2024</p>
                    </div>
                    </div>
                </section>
                
            </div>
            <div class="popContainer">
                <div class="popup">
                    <H3>Ajouter un avis</H3>
                    <div class="stars">
                                <input type="radio" name="rating1" id="rating1">
                                <label for="rating1" class="fa-solid fa-star"></label>
                                <input type="radio" name="rating1" id="rating2">
                                <label for="rating2" class="fa-solid fa-star"></label>
                                <input type="radio" name="rating1" id="rating3">
                                <label for="rating3" class="fa-solid fa-star"></label>
                                <input type="radio" name="rating1" id="rating4">
                                <label for="rating4" class="fa-solid fa-star"></label>
                                <input type="radio" name="rating1" id="rating5">
                                <label for="rating5" class="fa-solid fa-star"></label>
                    </div>
                    <div class="textArea">
                        <label for="commentaire">Votre avis :</label>
                        <textarea name="commentaire" id="commentaire" placeholder="Votre avis..."></textarea>
                    </div>
                    <?php
                    $r->blueButton("Envoyer","");
                    ?>
                </div>
                </div>
        </body>

    </html>
    <?php

}
}
?>
