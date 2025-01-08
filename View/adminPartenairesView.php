<?php
require_once(ROOT . '/Controller/userController.php');
require_once("commonViews.php");

class adminPartenairesView {
    public function entetePage() {
        ?>
        <head>
            <title>Partenaires</title>
            <link rel="stylesheet" href="View/css/userInfosStyle.css">
            <link rel="stylesheet" href="View/css/commonStyles.css">
            <script src="View/scripts/infosScript.js"></script>
            
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script src="View/scripts/adminPart.js"></script>
        </head>
        <?php   
    }

    public function searchBar(){
        ?>
        <form id="partenaires" action="" class="searchBar" id="seachBar">
            <div class="searchBar">
            <i class="fas fa-search"></i>
            <input type="text" name="search" id="seachBar" onkeyup="fetchPartenaires()" placeholder="Tapez le nom du partenaire">
            </div>
            <div class="filtresTri">
            <select name="wilayas" id="wilayas" onchange="fetchPartenaires()">
                <option value="0">Wilaya</option>
                <option value="Adrar">Adrar</option>
                <option value="Chlef">Chlef</option>
                <option value="Laghouat">Laghouat</option>
                <option value="Oum El Bouaghi">Oum El Bouaghi</option>
                <option value="Batna">Batna</option>
                <option value="Béjaïa">Béjaïa</option>
                <option value="Biskra">Biskra</option>
                <option value="Béchar">Béchar</option>
                <option value="Blida">Blida</option>
                <option value="Bouira">Bouira</option>
                <option value="Tamanrasset">Tamanrasset</option>
                <option value="Tébessa">Tébessa</option>
                <option value="Tlemcen">Tlemcen</option>
                <option value="Tiaret">Tiaret</option>
                <option value="Tizi Ouzou">Tizi Ouzou</option>
                <option value="Alger">Alger</option>
                <option value="Djelfa">Djelfa</option>
                <option value="Jijel">Jijel</option>
                <option value="Sétif">Sétif</option>
                <option value="Saïda">Saïda</option>
                <option value="Skikda">Skikda</option>
                <option value="Sidi Bel Abbès">Sidi Bel Abbès</option>
                <option value="Annaba">Annaba</option>
                <option value="Guelma">Guelma</option>
                <option value="Constantine">Constantine</option>
                <option value="Médéa">Médéa</option>
                <option value="Mostaganem">Mostaganem</option>
                <option value="M'Sila">M'Sila</option>
                <option value="Mascara">Mascara</option>
                <option value="Ouargla">Ouargla</option>
                <option value="Oran">Oran</option>
                <option value="El Bayadh">El Bayadh</option>
                <option value="Illizi">Illizi</option>
                <option value="Bordj Bou Arreridj">Bordj Bou Arreridj</option>
                <option value="Boumerdès">Boumerdès</option>
                <option value="El Tarf">El Tarf</option>
                <option value="Tindouf">Tindouf</option>
                <option value="Tissemsilt">Tissemsilt</option>
                <option value="El Oued">El Oued</option>
                <option value="Khenchela">Khenchela</option>
                <option value="Souk Ahras">Souk Ahras</option>
                <option value="Tipaza">Tipaza</option>
                <option value="Mila">Mila</option>
                <option value="Aïn Defla">Aïn Defla</option>
                <option value="Naâma">Naâma</option>
                <option value="Aïn Témouchent">Aïn Témouchent</option>
                <option value="Ghardaïa">Ghardaïa</option>
                <option value="Relizane">Relizane</option>
                <option value="Timimoun">Timimoun</option>
                <option value="Bordj Badji Mokhtar">Bordj Badji Mokhtar</option>
                <option value="Ouled Djellal">Ouled Djellal</option>
                <option value="Béni Abbès">Béni Abbès</option>
                <option value="In Salah">In Salah</option>
                <option value="In Guezzam">In Guezzam</option>
                <option value="Touggourt">Touggourt</option>
                <option value="Djanet">Djanet</option>
                <option value="El M'Ghair">El M'Ghair</option>
                <option value="El Menia">El Menia</option>
            </select>
            <select name="Catégories" id="categories" onchange="fetchPartenaires()">
                <option value="0">Catégorie</option>
                         
            </select>
           
            </div>
        </form>
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
                    <div id="head">
                    <?php $r->titre("Liste des partenaires"); ?>
                    <a href="index?router=addNewPart"><button>Ajouter un partenaire</button></a>
                    </div>
                    <div class="subContent">
                        <?php $r->adminSideBar("Partenaire"); ?>
                        <div class="users">
                            <div class="search">
                                <?php $this->searchBar() ?>
                            </div>
                            <table id="all">
                                <tr class="head">
                                    <th onclick="sortTable('nom')">Nom</th>
                                    <th onclick="sortTable('categorie')">Categorie</th>
                                    <th onclick="sortTable('ville')">Ville</th>
                                    <th onclick="sortTable('email')">Email</th>
                                    <th onclick="sortTable('telNum')">Numéro de téléphone</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
               
                <style>
                    form.searchBar {
                        display: flex;
                        justify-content: space-between;
                        gap: 40px;
                        padding: 0;
                    }
                    form.searchBar div.searchBar {
                        width: 100%;
                        display: flex;
                        gap: 8px;
                        align-items: center;
                    }
                    form.searchBar .filtresTri {
                        display: flex;
                        justify-content: space-between;
                        gap: 10px;
                    }
                    form.searchBar .filtresTri select {
                        width: fit-content;
                    }
                    div.searchBar i {
                        color: #001a23;
                        opacity: 0.4;
                    }
                    div.searchBar,
                    select {
                        border-radius: 6px;
                        background: #f3f3f3;
                        padding: 8px 8px;
                        border: 0;
                        color: #001a23;
                        opacity: 0.8;
                        outline: none;
                        font-size: 12px;
                        font-weight: 500;
                    }
                    input {
                        font-size: 12px;
                        border: none;
                        outline: none;
                        font-weight: 500;
                        flex-grow: 1;
                        background-color: transparent;
                    }
                    input::placeholder {
                        color: #001a23;
                        opacity: 0.2;
                        font-size: 12px;
                    }
                    select {
                        font-weight: 500;
                    }

                    div#head{
                        display:flex;
                        justify-content:space-between;
                    }
                </style>
            </body>
        </html>
        <?php
    }
}
?>
