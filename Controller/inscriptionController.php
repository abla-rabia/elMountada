<?php
require_once("View\inscriptionView.php");
//controleur pour afficher la vue d'inscription
class inscriptionController{
    public function afficherPage(){
        $v=new inscriptionView();
        $v->afficher_page();
    }
}
?>