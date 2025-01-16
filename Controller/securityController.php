<?php
//controlleur pour charger la vue de page de sécurité
require_once("View\securityView.php");
class securityController{
    public function afficherPage(){
        $v=new securityView();
        $v->afficher_page();
    }
}



?>