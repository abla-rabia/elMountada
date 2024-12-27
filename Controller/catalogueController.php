<?php
require_once("View\catalogueView.php");
class catalogueController{
    public function afficherPage(){
        $v=new catalogueView();
        $v->afficher_page();
    }
}
?>