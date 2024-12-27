<?php
require_once("View\partenaireView.php");
class partenaireController{
    public function afficherPage(){
        $v=new partenaireView();
        $v->afficher_page();
    }
}
?>