<?php
require_once(ROOT . '/Controller/userController.php');
require_once("commonViews.php");

class adminOffresView {
    public function entetePage() {
        ?>
        <head>
            <title>Remises & Avantages</title>
            <link rel="stylesheet" href="View/css/userInfosStyle.css">
            <link rel="stylesheet" href="View/css/commonStyles.css">
            <script src="View/scripts/infosScript.js"></script>
            
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script src="View/scripts/offrePart.js"></script>
            <link rel="stylesheet" href="View/css/offresViewstyle.css">
            
        </head>
        <?php   
    }
public function cartsStats(){
    ?>
    <div  class="carteStat" id="carte1">
        <div class="numberCircle">
            <p id="numberRemise">50%</p>
        </div>
        <p class="subText">Meilleure remise !</p>
    </div>
    <div  class="carteStat" id="carte2">
        <div class="numberCircle">
            <p id="numberStat">286</p>
        </div>
        <p class="subText">Persones ont bénéficié des remises ! </p>
    </div>
    <?php
}
    public function addPopup($type,$partenaireId) {
        $r = new commonViews();
        $title = $type === 'remise' ? 'Ajouter une remise' : 'Ajouter un avantage';
        $inputLabel = $type === 'remise' ? 'Taux de remise' : 'Contenu';
        $inputId = $type === 'remise' ? 'remiseTaux' : 'contenuAvantage';
        $inputPlaceholder = $type === 'remise' ? '50%' : 'contenu de l avantage';
        $closeBtn= $type === 'remise' ? 'closeBtn1' : 'closeBtn2';
        ?>
        <div class="popContainer">
            <div class="popupUpload" id="add<?= ucfirst($type) ?>Popup">
                <h3><?= $title ?></h3>
                <div class="textArea">
                    <form action="" class="approuver" id="formAdd<?= ucfirst($type) ?>">                        
                        <input type="hidden" name="partenaireId" value="<?=$partenaireId?>">
                        <label for="carteType">Type de carte:</label>
                        <select name="carteId" class="carteType" id="carteType"></select>
                        <?php $r->famousInput($inputLabel, $inputPlaceholder, "text", "contenu") ?>
                    </form>
                </div>
                <?php
                $r->blueButton2("Ajouter", "add" . ucfirst($type));
                $r->blueButton2("Annuler", $closeBtn);
                ?>
            </div>
        </div>
        <?php
    }
    public function modifyPopup($type, $partenaireId) {
        $r = new commonViews();
        $title = $type === 'remise' ? 'Modifier une remise' : 'Modifier un avantage';
        $inputLabel = $type === 'remise' ? 'Taux de remise' : 'Contenu';
        $inputId = $type === 'remise' ? 'remiseTaux' : 'contenuAvantage';
        $inputPlaceholder = $type === 'remise' ? '50%' : 'contenu de l avantage';
        $closeBtn = $type === 'remise' ? 'closeBtn1' : 'closeBtn2';
        ?>
        <div class="popContainer">
            <div class="popupUpload" id="modify<?= ucfirst($type) ?>Popup">
                <h3><?= $title ?></h3>
                <div class="textArea">
                    <form action="" class="approuver" id="formModify<?= ucfirst($type) ?>">                        
                        <input type="hidden" name="partenaireId" value="<?=$partenaireId?>">
                        <input type="hidden" name="id" >
                        <label for="carteType">Type de carte:</label>
                        <select name="carteId" class="carteType" id="carteType"></select>
                        <?php $r->famousInput2($inputLabel, $inputPlaceholder, "text", "contenu") ?>
                    </form>
                </div>
                <?php
                $r->blueButton2("Modifier", "modify" . ucfirst($type));
                $r->blueButton2("Annuler", $closeBtn);
                ?>
            </div>
        </div>
        <?php
    }
 
    public function afficher_page($id) {
        $r = new commonViews();
        ?>
        <html>
            <?php $this->entetePage(); ?>
            <body class="to">
                <input type="hidden" name="id" id="id" value="<?=$id?>">
                <?php $r->navBarC(); ?>
                <div class="content">
                    <?php $r->titre("Remises et Avantages"); ?>
                    <div class="subContent">
                        <?php $r->adminSideBar("Partenaire"); ?>
                        <div class="users">
                        <?php $r->sectionTitle("Satistiques"); ?>
                            <div class="cartesStats">
                                <?php $this->cartsStats() ?>
                            </div>
                            <div class="offresTables">
                            <div class="offreTable">
                            <?php $r->sectionTitle("Remises"); ?>
                            <div class="tablee">
                            <table id="remisesTable" >
                            
                                <tr class="head">
                                    <th onclick="sortTable('remise')">Remise</th>
                                    <th onclick="sortTable('membre')">Membre bénéficiaire</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                </tr>
                                
                            </table>
                            </div>
                            </div>
                            <div class="offreTable">
                            <?php $r->sectionTitle("Avantages"); ?>
                            <div class="tablee">
                            <table id="avantagesTable" >
                            
                                <tr class="head">
                                    <th onclick="sortTable('avantage')">Avantage</th>
                                    <th onclick="sortTable('membre')">Membre bénéficiaire</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                </tr>
                            </table>
                            </div>
                            </div>
                        </div>
                        <div class="buttons offres">
                            <button onclick="ajouterAvantage()">Ajouter Avantage</button>
                            <button onclick="ajouterRemise()">Ajouter Remise</button>
                            <button onclick="ajouterOffreSpecial()">Ajouter Offre Spécial</button>
                        </div>
                        </div>
                    </div>
                    <?php 
                    $this->addPopup('remise',$id); 
                    $this->addPopup('avantage',$id); 
                    $this->modifyPopup('remise',$id); 
                    $this->modifyPopup('avantage',$id); 
                    ?>
                </div>
                
                
            </body>
            
        </html>
        <?php
    }
}
?>
