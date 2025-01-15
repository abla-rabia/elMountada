<?php
require_once(ROOT . '/Controller/partenaireController.php');
require_once("commonViews.php");

class partenaireInfosView {
    private $sessionData;

    public function __construct() {
        $this->sessionData = isset($_SESSION['partenaire']) ? $_SESSION['partenaire'] : null;
    }

    public function entetePage() {
        ?>
        <head>
            <title>Informations du partenaire</title>
            <link rel="stylesheet" href="View/css/userInfosStyle.css">
            <link rel="stylesheet" href="View/css/commonStyles.css">
            <script src="View/scripts/infosScript.js"></script>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <style>
                textarea {
                        font-size: 12px;
                        border: none;
                        outline: none;
                        font-weight: 500;
                        flex-grow: 1;
                        background-color: transparent;
                        width: 100%;
                        padding: 8px;
                        border-radius: 6px;
                        color: #001a23;
                        opacity: 0.8;
                    }
                    input::placeholder,
                    textarea::placeholder {
                        color: #001a23;
                        opacity: 0.2;
                        font-size: 12px;
                    }
                    .textArea {
                        display: flex;
                        flex-direction: column;
                        width: 100%;
                        gap: 10px;
                    }
                    .textArea label {
                        font-size: 12px;
                        color: #001a23;
                        font-weight: 500;
                    }
                    .textArea textarea {
                        border-radius: 11.054px;
                        border: 1.105px solid #eff0f6;
                        display: flex;
                        height: 120px;
                        padding: 15.903px 22.718px;
                        align-items: flex-start;
                        gap: 9.087px;
                        flex-shrink: 0;
                        box-shadow: 0px 2px 4px 0px rgba(19, 18, 66, 0.03);
                        color: #001a23;
                        font-weight: 500;
                        align-self: stretch;
                        resize: none;
                        outline: none;
                    }
            </style>
        </head>
        <?php   
    }

    public function afficher_page() {
        if ($this->sessionData === null) {
            echo "No partenaire data available.";
            return;
        }

        $r = new commonViews();
        ?>
        <html>
            <?php $this->entetePage(); ?>
            <body class="to">
                <?php $r->navBar(); ?>
                <div class="content">
                    <?php $r->titre("Profil du partenaire"); ?>
                    <div class="subContent">
                        <?php $r->memberSideBar("infos"); ?>
                        <form action="" method="POST" class="infosForm" id="infosForm">
                            <input type="hidden" name="id" value="<?= $this->sessionData['id'] ?>">
                            <div class="lineContainer">
                                <div class="line">
                                    
                                    <?php
                                    $r->famousInput2("Nom", $this->sessionData['nom'], "text", "nom");
                                    $r->famousInput2("Numéro de téléphone", $this->sessionData['telNumber'], "tel", "tel");
                                    ?>
                                   
                                </div>
                                <div class="line">
                                <div class="textArea">
                                <label for="commentaire">Description:</label>
                                <textarea name="description" id="commentaire" ><?=$this->sessionData['description']?></textarea>
                            </div><br>
                                </div>
                                <div class="line">
                                    <?php
                                    $r->famousInput2("Ville", $this->sessionData['ville'], "text", "ville");
                                    $r->famousInput2("Catégorie", $this->sessionData['categorie'], "text", "categorie");
                                    ?>
                                </div>
                                <div class="line">
                                    <?php
                                    $r->famousInput2("Site Web", $this->sessionData['website'], "url", "site");
                                    $r->famousInput2("Email de contact", $this->sessionData['contactmail'], "email", "mail");
                                    ?>
                                </div>
                                <input type="text" name="id" value="<?= $this->sessionData['id'] ?>" hidden>
                            </div>
                            <div class="buttonContainer">
                                <div class="buttonSubContainer">
                                    <br>
                                    <?php $r->blueButton2("Enregistrer les modifications", "infosButton"); ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </body>
        </html>
        <?php
    }
}
?>
