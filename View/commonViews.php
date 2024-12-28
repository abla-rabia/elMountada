<?php
class commonViews{
    public function button($content){
        ?>
        <button id="boutton"><a href="index.php?router=Page de connexion">Se Connecter</a></button>
        <?php
    }


    public function avisPopup(){
        ?>
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
                    $this->blueButton("Envoyer","");
                    ?>
                </div>
                </div>
        <?php
    }
    //la vue de la navbar dans le cas déconnecté
    public function navBarD(){
        ?>
        <nav>
            <a href="#"><img src="View/assets/logo.png" alt="logo light mode" width="120px"></a>
            <a href="index.php?router=Page%20d'accueil">Accueil</a>
            <a href="index.php?router=Catalogue">Partenaires</a>
            <a href="">Offres</a>
            <li id="subMenuP">
                Dons & bénévolats
                <ul id="subMenu">
                    <a>Demande d'aide</a>
                    <a>Bénévolat</a>
                    <a>Faire un don</a>
                </ul>
            </li>
            <a href="index.php?router=Inscription">Rejoingez nous</a>
            
            <?php
            $this->button("Se Connecter")
            ?>
        </nav>
        
        <?php
    }
    // le famous boutton bleu 
    public function blueButton($content,$destination){
        ?>
            <a href="index.php?router=<?=$destination?>"><button class="famousButton"><?= $content ?></button></a>
        <?php
    }
    public function blueButton2($content){
        ?>
            <button id="famousButtonPop"><?= $content ?></button>
        <?php
    }

    //la carte d'un partenaire 
    public function partenaireCard(){
        ?>
        <div class="cardContainer">
            <img src="View/assets/slider1.png" alt="Hotel img">
            <div class="title">
                <h4>Nom partenaire</h4>
                <p class="offreCard">50% OFF</p>
            </div>
            <p class="description">
                Write an amazing description in this dedicated card section. Each word counts. 
            </p>
            <?php
            $this->blueButton("En savoir plus","Partenaire");
            ?>

        </div>
        <?php
    }
    
public function sectionTitle($title){
    ?>
    <h3 id="sectionTitle"><?=$title?></h3>
    <?php
}

public function famousInput($label,$placeholder,$type){
    ?>
    <label for="<?=$label?>Input"><?=$label?></label>
    <input type="<?=$type?>" placeholder="<?=$placeholder?>" name="<?=$placeholder?>Input">
    <?php
}

    public function titre($titre){
        ?>
        <h2 id="titre"><?=$titre?></h2>
        <?php
    }
    
}
?>