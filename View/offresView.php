<?php
require_once(ROOT . '/Controller/partenaireController.php');
require_once("commonViews.php");
class offresView{
public function entetePage(){
    ?>
    <head>
        <title>Remises et avantages</title>
        <link rel="stylesheet" href="View/css/catalogueStyle.css">
        <link rel="stylesheet" href="View/css/commonStyles.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="View/scripts/offresViewScript.js"></script>
        
    </head>
    <?php   
}


public function searchBar(){
    ?>
    <form action="" class="searchBar">
        <div class="searchBar">
        <i class="fas fa-search"></i>
        <input type="text" name="searchOffre" id="seachBar" placeholder="Tapez le nom de l'offre">
        </div>
        <div class="filtresTri">
        <select name="filterVille" id="wilayas">
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
        <select name="filterCategorie"  id="categories">
            <option value="0">Catégorie</option>
                     
        </select>
        <select name="filterType" id="type">
            <option value="0">Type offre</option>
            <option value="remise">remise</option>
            <option value="avantage">avantage</option>      
        </select>
        </div>
    </form>
    <?php
}


public function offresSection(){
    ?>
    <div class="offresSection">
    <table id="offersTable">
    <tr class="head">
        <td onclick="sortTable('partenaireVille')">Ville</td>
        <td onclick="sortTable('partenaireCategorie')">Catégorie</td>
        <td onclick="sortTable('partenaireNom')">Partenaire</td>
        <td onclick="sortTable('offreContenu')">Offre</td>
    </tr>
   </table>
    </div>
    <?php
}


public function afficher_page(){
    $r = new commonViews();
    ?>
    <html >
        
        <?php
        $this->entetePage();
        ?>
        <body>
        <?php
            $r->navBar();
            $r->titre("Remises et avantages");
            $this->searchBar();
            ?>
            <div class="section">
                <?php

            $this->offresSection();
            ?>
            </div>
        </body>
        
    </html>
    <?php

}
}
?>

