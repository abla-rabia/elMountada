<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
define('ROOT', __DIR__); // Chemin absolu de la racine
require_once("Controller/userController.php");
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
            $r=new userController();
            $r->afficherPageLogin();
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
        case 'users':
            $r=new userController();
            $r->afficherPageUsers();
            break; 
        case 'login':
            $rts=new userController();
            $res=$rts->login();
            if($res!=1){
                header("Location: index.php?router=Page%20de%20connexion");
                echo "<script>alert('hello')</script>";
            }
            break;
        case 'logout':
            $rts=new userController();
            $rts->logout();
            break;
        case 'modifyPersoInfo':
            $rts=new userController();
            $rts->modifyPersoInfo();
            break;
        case 'modifyCompteInfo':
            $rts=new userController();
            $rts->modifyCompteInfo();
            break;

        case 'modifyPassword':
            $rts=new userController();
            $rts->modifyPassword();
            break;
        case 'favoris':
            $rts=new userController();
            $rts->afficherPageFavoris();
            break;
        case 'modifyPdp':
            $rts=new userController();
            $rts->modifyPdp();
            break;

        case 'getUsers':
            $rts=new userController();
            $rts->getUsers();
            break;
        
    }
}
else{
    $r=new homeController();
    $r->afficherPage();
}

?>

