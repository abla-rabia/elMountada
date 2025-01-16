<?php
require_once("View\homeView.php");
//controleur pour afficher la vue home
class homeController{
    public function afficherPage(){
        $v=new homeView();
        $v->afficher_page();
    }
}
?>