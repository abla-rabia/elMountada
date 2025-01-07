<?php
require_once("View\securityView.php");
class securityController{
    public function afficherPage(){
        $v=new securityView();
        $v->afficher_page();
    }
}



?>