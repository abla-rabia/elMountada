<?php
session_start();
require_once("Controller/loginController.php");
require_once("Controller/homeController.php");
require_once("Controller/partenaireController.php");
require_once("Controller/catalogueController.php");
require_once("Controller/inscriptionController.php");
require_once("Controller/userInfosController.php");
require_once("Controller/securityController.php");
require_once("Controller/userCompteController.php");
require_once("Controller/carteController.php");
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
        case 'Partenaire':
            $r=new partenaireController();
            $r->afficherPage();
            break; 
        case 'Inscription':
            $r=new inscriptionController();
            $r->afficherPage();
            break; 
        case 'Mes infos':
            $r=new userInfosController();
            $r->afficherPage();
            break; 
        case 'Mon compte':
            $r=new userCompteController();
            $r->afficherPage();
            break; 
        case 'securite':
            $r=new securityController();
            $r->afficherPage();
            break; 
        case 'carte':
            $r=new carteController();
            $r->afficherPage();
            break; 
    }
}
else{
    $r=new homeController();
    $r->afficherPage();
}

?>

