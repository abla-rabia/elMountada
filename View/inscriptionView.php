<?php
require_once("Controller\catalogueController.php");
require_once("commonViews.php");

class inscriptionView {
    public function entetePage() {
        ?>
        <head>
            <title>Inscription</title>
            <link rel="stylesheet" href="View/css/inscriptionStyle.css">
            <link rel="stylesheet" href="View/css/commonStyles.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script src="View/scripts/inscriptionScript.js"></script>
        </head>
        <?php
    }

    public function persoInfoSection() {
        $r = new commonViews();
        ?>
        <div class="infoPerso">
            <?php $r->sectionTitle("Informations personnelles"); ?>
            <div class="line">
                <?php
                $r->famousInput("Prénom", "Abla", "text","prenom");
                $r->famousInput("Nom", "Rabia", "text","nom");
                ?>
            </div>
            <div class="line">
                <?php
                $r->famousInput("Date de naissance", "", "date","birthDate");
                $r->famousInput("Numéro de téléphone", "+213 111 11 11 11", "tel","telNumber");
                ?>
            </div>
        </div>
        <?php
    }

    public function infoCompteSection() {
        $r = new commonViews();
        ?>
        <div class="infoCompte">
            <?php $r->sectionTitle("Informations du compte"); ?>
            <div class="line">
                <?php
                $r->famousInput("Username", "abla-rabia", "text","username");
                $r->famousInput("Email", "la_rabia@esi.dz", "email","email");
                ?>
            </div>
            <div class="line">
                <?php
                $r->famousInput("Mot de passe", "***********", "password","password");
                $r->famousInput("Confirmer le mot de passe", "***********", "password","password2");
                ?>
            </div>
        </div>
        <?php
    }

    public function attachements() {
        $r = new commonViews();
        ?>
        <div class="attachement">
            <?php $r->sectionTitle("Attachements"); ?>
            <div class="line">
                <?php
                $r->famousInput("Photo personnelle", "Télécharger la photo", "file","persoPhoto");
                $r->famousInput("Photo de la carte d’identité", "Télécharger la photo de la carte", "file","idPhoto");
                ?>
            </div>
        </div>
        <?php
    }

    public function paiementSection() {
        $r = new commonViews();
        ?>
        <div class="paiement">
            <?php $r->sectionTitle("Cartes et paiement"); ?>
            <div class="textExplication">
                <p>Pour devenir membre de notre association, une carte de membre est nécessaire. Voici les informations importantes concernant cette étape :</p>
                <h5>Pourquoi une carte de membre ?</h5>
                <p>La carte de membre vous permet de bénéficier d'avantages exclusifs avec nos partenaires (hôtels, cliniques, écoles, agences de voyage, etc.) et d’accéder à des remises adaptées à chaque type de carte.</p>
                <h5>Types de cartes disponibles :</h5>
                <p>Chaque carte propose des avantages spécifiques et un tarif associé. Vous trouverez ci-dessous la liste des cartes avec leurs descriptions détaillées et leurs prix pour choisir celle qui vous convient le mieux.</p>
                <h5>Procédure de paiement :</h5>
                <ul>
                    <li>Sélectionnez une carte.</li>
                    <li>Effectuez le paiement au compte CCP : <b>8544567876534</b>.</li>
                    <li>Joignez le reçu de paiement directement sur cette page.</li>
                    <li>Validez votre demande en cliquant sur "Soumettre".</li>
                </ul>
                <h5>Validation de votre adhésion :</h5>
                <p>Une fois votre paiement vérifié par l’administrateur, vous serez notifié par e-mail de votre acceptation en tant que membre de l’association. Accès immédiat à votre profil :</p>
                <p>En attendant la validation, vous pourrez :</p>
                <ul>
                    <li>Créer et consulter votre profil sur l'application.</li>
                    <li>Accéder à votre historique. Faire des dons ou des demandes d’aide.</li>
                    <li>Proposer votre participation pour des bénévolats.</li>
                </ul>
                <p><b>Note importante :</b> Assurez-vous que toutes les informations fournies soient exactes pour faciliter le traitement de votre demande.</p>
            </div>
            <div class="cartesOffres">
                <?php
                $r->lightCard("Carte Classique", "2 500");
                $r->darkCard();
                $r->lightCard("Carte Prestige", "10 000");
                ?>
            </div>
        </div>
        <?php
        $r->uploadPopup();
    }

    public function avisPopup() {
        ?>
        <div class="popContainer">
            <div class="popup">
                <h3>Ajouter un avis</h3>
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
                <?php $this->blueButton("Envoyer", ""); ?>
            </div>
        </div>
        <?php
    }

    public function afficher_page() {
        $r = new commonViews();
        ?>
        <html>
            <?php $this->entetePage(); ?>
            <body>
                <?php $r->navBarD(); ?>
                <form  method="post" class="inscriptionForm"  id="formInsc">
                    <?php
                    $r->titre("Inscription");
                    $this->persoInfoSection();
                    $this->infoCompteSection();
                    $this->attachements();
                    ?>
                    <div class="check">
                        <input type="checkbox" name="payerNow" id="payerNow">
                        <label for="payerNow">S’inscrire pour devenir membre dans l’association ?</label><br>
                    </div>
                    <div class="buttonContainer">
                        <div class="buttonConf">
                            <?php $r->blueButton2("Confirmer", "inscriptionPop"); ?>
                        </div>
                    </div>
                    <?php
                    $r->textPopup();
                    $this->paiementSection();
                    ?>
                    
                </form>
        </body>
        </html>
        
        
        <?php
    }
}
?>
