<?php
require_once("View\carteView.php");
//controlleur pour afficher la vue de la carte
class carteController{
    public function afficherPage(){
        $v=new carteView();
        $v->afficher_page();
    }
}
?>