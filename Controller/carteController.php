<?php
require_once("View\carteView.php");
class carteController{
    public function afficherPage(){
        $v=new carteView();
        $v->afficher_page();
    }
}
?>