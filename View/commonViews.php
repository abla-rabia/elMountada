<?php
class commonViews{
    public function button($content){
        ?>
        <button id="boutton"><a href="index.php?router=Page de connexion">Se Connecter</a></button>
        <?php
    }

    public function carte($type){
        ?>
        <div class="carteMembre">
            <div class="top">
                <div class="head">
                    <img src="View/assets/logo.png" alt="logo mode" width="130px" >
                    <p>Association el Mountada</p>
                </div>
                <div class="bottom">
                    <div class="keyValues">
                    <div class="titlesCard">
                        <p>Nom : </p>
                        <p>Prénom : </p>
                        <p>identifiant : </p>
                    </div>
                    <div class="valuesCard">
                        <p>Rabia</p>
                        <p>Abla</p>
                        <p>id8657753683</p>
                    </div>
                    </div>
                    <div class="barreCode">
                        <img src="View/assets/barre.png" alt="" width=140px>
                    </div>
                </div>
            </div>
            <div class="down">
                <p>Carte <?=$type?></p>
            </div>
        </div>
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



    public function navBarC(){
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
            
            <div class="userSection">
            <i class="fa-regular fa-bell"></i>
            <div class="user">
                <img class="userImg" id="nav" src="View/assets/user.png" alt="user img">
                <ul id="userBox">
                    <a href="index.php?router=Mes infos">Profile</a>
                    <a>Carte</a>
                    <a>Historique</a>
                    <a>Favoris</a>
                    <a>Se déconnecter</a>
                </ul>
            </div>
            </div>
        </nav>
        
        <?php
    }


    public function memberSideBar($current){
            if ($current=="infos"){
            ?>
            <div class="sidebar">
                <ul>
                    <li id="infos " class=""><a id="current" href="index.php?router=Mes infos">Mes Informations</a></li>
                    <li id="compte"><a href="index.php?router=Mon compte">Mon compte</a></li>
                    <li id="secure"><a  href="index.php?router=securite">Sécurité</a></li>    
                </ul>
            </div>
            <?php 
        }
        elseif ($current=="compte"){
        ?>
            <div class="sidebar">
                <ul>
                    <li id="infos " class=""><a  href="index.php?router=Mes infos">Mes Informations</a></li>
                    <li id="compte"><a id="current" href="index.php?router=Mon compte">Mon compte</a></li>
                    <li id="secure"><a  href="index.php?router=securite">Sécurité</a></li>    
                </ul>
            </div>
        <?php
        }
        else {
        ?>
            <div class="sidebar">
                <ul>
                    <li id="infos " class=""><a  href="index.php?router=Mes infos">Mes Informations</a></li>
                    <li id="compte"><a href="index.php?router=Mon compte">Mon compte</a></li>
                    <li id="secure"><a id="current" href="index.php?router=securite">Sécurité</a></li>    
                </ul>
            </div>
            <?php
        }
    }
    // le famous boutton bleu 
    public function blueButton($content,$destination){
        ?>
            <a href="index.php?router=<?=$destination?>"><button type="submit" class="famousButton"><?= $content ?></button></a>
        <?php
    }
    public function blueButton2($content,$id){
        ?>
            <button  id="<?=$id?>" type="button" class="famousButtonPop"><?= $content ?></button>
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
    if($type!="file"){
    ?>
    <div class="fmsInpLab">
    <label class="fmsLabel"for="<?=$label?>Input"><?=$label?></label>
    <input class="fmsInput" type="<?=$type?>" placeholder="<?=$placeholder?>" name="<?=$placeholder?>Input">
    </div>
    <?php
    }
    else{
        ?>
        <div class="fmsInpLab">
        <label class="fmsLabel"for="<?=$label?>Input"><?=$label?></label>
        <input class="fmsInput" type="<?=$type?>" placeholder="<?=$placeholder?>" name="<?=$placeholder?>Input">
    </div>
    <?php
    }
}

public function famousInput2($label,$value,$type){
    if($type!="file"){
    ?>
    <div class="fmsInpLab">
    <label class="fmsLabel"for="<?=$label?>Input"><?=$label?></label>
    <input class="fmsInput" type="<?=$type?>" value="<?=$value?>" name="<?=$value?>Input">
    </div>
    <?php
    }
    else{
        ?>
        <div class="fmsInpLab">
        <label class="fmsLabel"for="<?=$label?>Input"><?=$label?></label>
        <input class="fmsInput" type="<?=$type?>" value="<?=$value?>" name="<?=$value?>Input">
    </div>
    <?php
    }
}

    public function titre($titre){
        ?>
        <h2 id="titre"><?=$titre?></h2>
        <?php
    }
    public function darkCard(){
        ?>
        <div class="cardOffre">
            <p class="reduction">-30%</p>
            <h3 class="offerName">Carte Premium</h3>
            <p class="price">5 000 DA <sub>/an</sub></p>
            <div class="bar"></div>
            <ul class="advantages">
                <li><i class="fa-solid fa-circle-check"></i>10% de remise sur les hôtels partenaires.</li>
                <li><i class="fa-solid fa-circle-check"></i>8% de réduction sur les services des cliniques partenaires.</li>
                <li><i class="fa-solid fa-circle-check"></i>Réductions exclusives sur les frais de scolarité des écoles partenaires.</li>
                <li><i class="fa-solid fa-circle-check"></i>Priorité pour les dons et les demandes d’aide.</li>
            </ul>
            <button class="choosePlan" type="button">Choisir ce plan</button>
                
        </div>
        <?php
    }
    public function lightCard($name,$price){
        ?>
        <div class="cardOffre white">
            <h3 class="offerName"><?=$name?></h3>
            <p class="price"><?=$price?> <sub>/an</sub></p>
            <div class="bar"></div>
            <ul class="advantages">
                <li><i class="fa-solid fa-circle-check"></i>10% de remise sur les hôtels partenaires.</li>
                <li><i class="fa-solid fa-circle-check"></i>8% de réduction sur les services des cliniques partenaires.</li>
                <li><i class="fa-solid fa-circle-check"></i>Réductions exclusives sur les frais de scolarité des écoles partenaires.</li>
                <li><i class="fa-solid fa-circle-check"></i>Priorité pour les dons et les demandes d’aide.</li>
            </ul>
            <button class="choosePlan" type="button">Choisir ce plan</button>
                
        </div>
        <?php
    }
    

public function uploadPopup(){
    ?>
    <div class="popContainer" >
            <div class="popupUpload" id="popupUpload">
                <H3>Payement de la carte</H3>
                <div class="textArea">
                    <?php
                    $this->famousInput("Veuillez attacher le reçu de paiement","Télécharger le reçu","file");
                    ?>
                </div>
                <?php
                $this->blueButton2("Confirmer","closeUploadPop");
                ?>
            </div>
            </div>
    <?php
}
public function textPopup(){
    ?>
    <div class="popContainer">
            <div class="popupUpload" id="textPopup">
                <H3>Félicitation !</H3>
                <div class="textArea">
                <label for="commentaire" class="fmsLabel" id="contentPop"></label>
                </div>
                <?php
                $this->blueButton("Aller à la page d'accueil","Page d\'accueil");
                ?>
            </div>
            </div>
    <?php
}
}
?>
