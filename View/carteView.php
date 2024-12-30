<?php
require_once("Controller\carteController.php");
require_once("commonViews.php");
require_once("inscriptionView.php");

class carteView{
    private $membre = 0;    
    private $type="classique";
public function entetePage(){
    ?>
    <head>
        <?php
        if ($this->membre==1){
        ?>
            <title>Ma carte</title>
        <?php
        }else{
        ?>
            <title>Achat carte</title>
        <?php
        }
        ?>
        <link rel="stylesheet" href="View/css/inscriptionStyle.css">
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
    $s = new inscriptionView();
    ?>
    <html >
        
        <?php
        $this->entetePage();
        ?>
        <body >
        <?php
            $r->navBarC();
            ?>
            <div class="content">
                <?php
                if ($this->membre==1){
                    $r->titre("Ma carte");
                ?>
                    <div class="subContent carte">
                    <?php
                        $r->carte($this->type);
                    ?>      
                        
                    </div>
 <?php }
                else {
                    $r->titre("Achat carte");}
                    ?>
                    <div class="subContent carte">
                    <div class="paiement">
                    <div class="subContent carte">
                    <div class="textExplication">
                    <p>Pour devenir membre de notre association, une carte de membre est nécessaire. Voici les informations importantes concernant cette étape :</p>
                    <h5>Pourquoi une carte de membre ?</h5>
                    <p>La carte de membre vous permet de bénéficier d'avantages exclusifs avec nos partenaires (hôtels, cliniques, écoles, agences de voyage, etc.) et d’accéder à des remises adaptées à chaque type de carte. </p>
                    <h5>Types de cartes disponibles : </h5>
                    <p>Chaque carte propose des avantages spécifiques et un tarif associé. Vous trouverez ci-dessous la liste des cartes avec leurs descriptions détaillées et leurs prix pour choisir celle qui vous convient le mieux. </p>
                    <h5>Procédure de paiement : </h5>
                    <ul>
                    <li>Sélectionnez une carte. </li>
                    <li>Effectuez le paiement au compte CCP : <b>8544567876534</b>. </li>
                    <li>Joignez le reçu de paiement directement sur cette page. </li>
                    <li>Validez votre demande en cliquant sur "Soumettre". </li>
                    </ul>
                    <h5>Validation de votre adhésion : </h5>
                    <p>Une fois votre paiement vérifié par l’administrateur, vous serez notifié par e-mail de votre acceptation en tant que membre de l’association.</p>
                </div>
                <div class="cartesOffres">
                <?php
                $r->lightCard("Carte Classique","2 500");
                $r->darkCard();
                $r->lightCard("Carte Prestige","10 000");
                ?>
                </div>
                </div>

                <?php
                $r->uploadPopup();
                ?>
                <div class="buttonContainer">
            <div class="buttonConf">
            <?php
            $r->blueButton2("Confirmer","inscriptionPop");
            $r->textPopup();
            ?>
            </div>
            </div>
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

            const popup = document.getElementById("popupUpload");
  const popContainer = document.getElementsByClassName("popContainer")[0];
  const popContainer1 = document.getElementsByClassName("popContainer")[1];
  //script pour la gestion de la popup des avis
  const choosePlanButtons = document.getElementsByClassName("choosePlan");
for (let button of choosePlanButtons) {
  button.addEventListener("click", function (event) {
    console.log("Button clicked");
    popContainer1.style.display = "flex";
    popup.style.display = "flex";
  });
}
document.getElementById("closeUploadPop").addEventListener("click", function (event) {
    console.log("Button clicked");
    popContainer1.style.display = "none";
    popup.style.display = "none";
  });
  window.addEventListener("click", (event) => {
    if (event.target === popContainer) {
      popContainer1.style.display = "none";
      popup.style.display = "none";
    }
  });
  window.addEventListener("click", (event) => {
    if (event.target === popContainer1) {
      popContainer1.style.display = "none";
      popup.style.display = "none";
    }
  });
  const popupT = document.getElementById("textPopup");
  document.getElementById("inscriptionPop").addEventListener("click", function () {
      popContainer.style.display = "flex";
      popupT.style.display = "flex";
      document.getElementById("contentPop").textContent=checkElement.checked ? "Reçu soumis avec succès ! Votre demande est en cours de traitement. Une fois confirmée, vous recevrez un email. En attendant, vous pouvez vous connecter et profiter des avantages utilisateur" : "Votre inscription a été effectuée avec succès. Vous pouvez maintenant vous connecter et bénéficier des avantages réservés aux utilisateurs inscrits."
      
    });
        </script>
    </html>
    <?php

}
}
?>

