<?php
session_start();
require_once("Controller/loginController.php");
require_once("Controller/homeController.php");
require_once("Controller/catalogueController.php");
if (isset($_GET['router'])){
    $action=$_GET['router'];
    switch ($action){
        case 'Page de connexion':
            $r=new loginController();
            $r->afficherPage();
            break;
        case 'Page d\'accueil':
            $r=new homeController();
            $r->afficherPage();
            break; 
        case 'Catalogue':
            $r=new catalogueController();
            $r->afficherPage();
            break; 
    }
}
else{
    $r=new homeController();
    $r->afficherPage();
}

?>