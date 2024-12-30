<?php
require_once("View\userInfosView.php");
class userInfosController{
    public function afficherPage(){
        $v=new userInfosView();
        $v->afficher_page();
        
    }
}
?>