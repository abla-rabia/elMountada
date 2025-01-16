<?php
require_once("View\userCompteView.php");
//controlleur pour charger la vue des infos de compte d'un user
class userCompteController{
    public function afficherPage(){
        $v=new userCompteView();
        $v->afficher_page();
    }
}
?>