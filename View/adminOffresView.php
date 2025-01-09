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
  
 
    public function afficher_page() {
        $r = new commonViews();
        ?>
        <html>
            <?php $this->entetePage(); ?>
            <body class="to">
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
                            <table id="remisesTable" >
                            
                                <tr class="head">
                                    <th onclick="sortTable('remise')">Remise</th>
                                    <th onclick="sortTable('membre')">Membre bénéficiaire</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                </tr>
                            </table>
                            </div>
                            <div class="offreTable">
                            <?php $r->sectionTitle("Avantages"); ?>
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
                        <div class="buttons offres">
                            <button onclick="ajouterAvantage()">Ajouter Avantage</button>
                            <button onclick="ajouterRemise()">Ajouter Remise</button>
                            <button onclick="ajouterOffreSpecial()">Ajouter Offre Spécial</button>
                        </div>
                        </div>
                    </div>
                </div>
               
                <style>
                    body .users{
                        margin-top:-20px;
                    }
                    div.cartesStats{
                        display:flex;
                        justify-content:space-between;
                        gap:40px;
                        
                    }
                    div.cartesStats .carteStat{
                        display : flex;
                        gap:20px;
                        background-color:#a6dfb5;
                        border-radius:8px;
                        width:100%;
                        align-items:center;
                        padding:6px 16px;
                    }
                    div.cartesStats .carteStat .numberCircle{
                        background-color:white;
                        border-radius:50%;
                        width: 44px;
                        height:44px;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                    }
                    div.cartesStats .carteStat .numberCircle p{
                        color:rgba(0, 26, 35, 0.8);
                        font-weight:700;

                    }
                    div.cartesStats .carteStat p{
                        color:white;
                        font-weight:500;
                    }
                    div.offresTables{
                        display: flex;
                        justify-content:space-between;
                        gap:40px;

                    }
                    div.offresTables th{
                        font-weight:500;
                        font-size:12px;

                    }
                    div.offresTables table {
                        display: flex;
                        justify-content: space-between;
                        gap: 40px;
                        border-collapse: separate;
                        border-spacing: 0;
                        border-radius: 10px 10px 0 0;
                        overflow: hidden;
                        width: 100%;
                    }
                    div.offresTables .offreTable {
                        width: 100%;
                        height: 280px; /* Set the max height */
                        overflow-y: auto; /* Add vertical scroll bar if content exceeds max height */
                    }
                    div.offresTables td {
                        text-align: center;
                        padding: 14px 0;
                        border: none;
                        font-size: 12px;
                        font-weight: 500;
                        color: #001a23;
                    }
                    div.offresTables tr {
                        padding: 8px;
                    }
                    div.offresTables tr:nth-child(odd) {
                        background-color: rgba(12, 26, 75, 0.04);
                        width: 100%;
                    }
                    div.offresTables tr:first-child {
                        background-color: rgba(0, 26, 35, 1);
                        border-radius: 8px 8px 0 0;
                        color: white;
                        width: 100%;
                        display: flex;
                        justify-content: space-between;
                    }
                    div.offresTables tbody {
                        width: 100%;
                    }
                    .buttons.offres{
                        display: flex;
                        justify-content: space-between;
                        gap:50px;
                        margin-top:30px;
                    }
                    .buttons.offres button{
                        width:100%;
                        color: #fff;
  font-size: 14px;
  font-weight: 500;
  
  border: 0;
  padding: 10px 28px;
  cursor: pointer;
  border-radius: 6px;
  background: var(--blue-2, #001a23);
                    }

                </style>
            </body>
        </html>
        <?php
    }
}
?>
