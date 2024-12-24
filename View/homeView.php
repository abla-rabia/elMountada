<?php
require_once("Controller\homeController.php");
class homeView{

    public function entetePage(){
        ?>
        <head>
            <title>El Mountada</title>
            <link rel="stylesheet" href="View/css/homeStyle.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        </head>
        <?php   
    }
    public function slider(){
        ?>
        <div class="sliderImg">
            <div class="text">
                <h2>Oceanview Hotel News</h2>
                <p>Our Winter Getaway Package is here! Enjoy 20% off, free breakfast, and access to the rooftop pool. Book now for stays from Dec 15 to Feb 28!</p>
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
            ?>
            </body>
    
        </html>
        <?php
    
    }
}
?>
