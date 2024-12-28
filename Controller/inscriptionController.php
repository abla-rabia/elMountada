<?php
require_once("View\inscriptionView.php");
class inscriptionController{
    public function afficherPage(){
        $v=new inscriptionView();
        $v->afficher_page();
    }
}
?>