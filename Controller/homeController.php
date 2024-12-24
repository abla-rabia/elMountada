<?php
require_once("View\homeView.php");
class homeController{
    public function afficherPage(){
        $v=new homeView();
        $v->afficher_page();
    }
}
?>