<?php
require_once("View\userCompteView.php");
class userCompteController{
    public function afficherPage(){
        $v=new userCompteView();
        $v->afficher_page();
    }
}
?>