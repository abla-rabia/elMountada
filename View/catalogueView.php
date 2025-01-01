<?php
require_once("Controller\catalogueController.php");
require_once("commonViews.php");
class catalogueView{
public function entetePage(){
    ?>
    <head>
        <title>Catalogue</title>
        <link rel="stylesheet" href="View/css/catalogueStyle.css">
        <link rel="stylesheet" href="View/css/commonStyles.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <script src="View/scripts/homeScript.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        
    </head>
    <?php   
}


public function searchBar(){
    ?>
    <form action="" class="searchBar">
        <div class="searchBar">
        <i class="fas fa-search"></i>
        <input type="text" name="search" id="seachBar" placeholder="Tapez le nom du partenaire">
        </div>
        <div class="filtresTri">
        <select name="wilayas" id="wilayas">
            <option value="0">Wilaya</option>
            <option value="1">Adrar</option>
            <option value="2">Chlef</option>
            <option value="3">Laghouat</option>
            <option value="4">Oum El Bouaghi</option>
            <option value="5">Batna</option>
            <option value="6">Béjaïa</option>
            <option value="7">Biskra</option>
            <option value="8">Béchar</option>
            <option value="9">Blida</option>
            <option value="10">Bouira</option>
            <option value="11">Tamanrasset</option>
            <option value="12">Tébessa</option>
            <option value="13">Tlemcen</option>
            <option value="14">Tiaret</option>
            <option value="15">Tizi Ouzou</option>
            <option value="16">Alger</option>
            <option value="17">Djelfa</option>
            <option value="18">Jijel</option>
            <option value="19">Sétif</option>
            <option value="20">Saïda</option>
            <option value="21">Skikda</option>
            <option value="22">Sidi Bel Abbès</option>
            <option value="23">Annaba</option>
            <option value="24">Guelma</option>
            <option value="25">Constantine</option>
            <option value="26">Médéa</option>
            <option value="27">Mostaganem</option>
            <option value="28">M'Sila</option>
            <option value="29">Mascara</option>
            <option value="30">Ouargla</option>
            <option value="31">Oran</option>
            <option value="32">El Bayadh</option>
            <option value="33">Illizi</option>
            <option value="34">Bordj Bou Arreridj</option>
            <option value="35">Boumerdès</option>
            <option value="36">El Tarf</option>
            <option value="37">Tindouf</option>
            <option value="38">Tissemsilt</option>
            <option value="39">El Oued</option>
            <option value="40">Khenchela</option>
            <option value="41">Souk Ahras</option>
            <option value="42">Tipaza</option>
            <option value="43">Mila</option>
            <option value="44">Aïn Defla</option>
            <option value="45">Naâma</option>
            <option value="46">Aïn Témouchent</option>
            <option value="47">Ghardaïa</option>
            <option value="48">Relizane</option>
            <option value="49">Timimoun</option>
            <option value="50">Bordj Badji Mokhtar</option>
            <option value="51">Ouled Djellal</option>
            <option value="52">Béni Abbès</option>
            <option value="53">In Salah</option>
            <option value="54">In Guezzam</option>
            <option value="55">Touggourt</option>
            <option value="56">Djanet</option>
            <option value="57">El M'Ghair</option>
            <option value="58">El Menia</option>
        </select>
        <select name="Catégories" id="categories">
            <option value="0">Catégorie</option>
            <option value="1">Hôtels</option>
            <option value="2">Cliniques</option>
            <option value="3">Ecoles</option>
            <option value="4">Agences de voyage</option>            
        </select>
        <select name="tri" id="tri">
            <option value="0">Trier par</option>
            <option value="1">Wilaya</option>
            <option value="2">Catégorie</option>           
        </select>
        </div>
    </form>
    <?php
}



public function section($nomSection){
    $r = new commonViews();
    ?>
    <div class="sectionPart">
    <?php
    $r->sectionTitle($nomSection);
    ?>
    <div class="cartesPartenaire">
    <?php
        $r->partenaireCard();
        $r->partenaireCard();
        $r->partenaireCard();
    ?>
    </div>
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
            $r->titre("Catalogue partenaires");
            $this->searchBar();
            ?>
            <div class="sections">
            <?php
            $this->section("Hôtels");
            $this->section("Agences de voyage");
            $this->section("Cliniques");
            $this->section("Ecoles");
            ?>
            </div>
        </body>

    </html>
    <?php

}
}
?>
