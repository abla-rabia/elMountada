<?php
//controlleur pour charger la vue des infos personnelles du user
require_once("View\userInfosView.php");
class userInfosController{
    public function afficherPage(){
        $v=new userInfosView();
        $v->afficher_page();
        
    }
}
?>