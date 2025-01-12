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
            $r=new partenaireController();
            $r->afficherPageCatalogue();
            break; 
        case 'Partenaire':
            $r=new partenaireController();
            $id = $_GET['idPartenaire'] ?? null; // Use null as fallback if the parameter is not present
            if ($id) {
                $r->sendIdPartenaireView($id); 
            }
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
            $r=new userController();
            $r->afficherPageCarte();
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
        case 'getCartes':
            $rts=new userController();
            $rts->getCartes();
            break;
        case 'approuver':
            $rts=new userController();
            $rts->approuverMembre();
            break;
        case 'getRecu':
            $rts=new userController();
            $rts->getRecu();
            break;
        case 'getOffres':
            $rts=new userController();
            $rts->getOffres();
            break;
        case 'getCarte':
            $rts=new userController();
            $rts->getCarteById();
            break;
        case 'searchUser':
            $rts=new userController();
            $rts->searchUser();
            break;
        case 'paiement':
            $rts=new userController();
            $rts->paiement();
            break;
        case 'categories':
            $rts=new partenaireController();
            $rts->getCategories();
            break;
        case 'getPartCateg':
            $rts=new partenaireController();
            $rts->getPartenairesByCategorie();
            break;
        case 'getPartenaireById':
            $rts=new partenaireController();
            $rts->getPartenaireById();
            break;
        case 'getPartenaires':
            $rts=new partenaireController();
            $rts->getPartenaires();
            break;
        case 'getSection':
            $controller = new partenaireController();
            if (isset($_GET['categorie'])) {
                echo $controller->getSection($_GET['categorie']);
            }
            break;
        case 'getPartCarte':
            $controller = new partenaireController();
            if (isset($_GET['partenaireId']) && isset($_GET['partenaireNom']) && isset($_GET['partenaireDescription'])&& isset($_GET['remise'])) {
                echo $controller->getPartCarte($_GET['partenaireId'], $_GET['partenaireNom'], $_GET['partenaireDescription'],$_GET['remise']);
            }
            break;
        case 'searchPart':
            $rts=new partenaireController();
            $rts->searchPart();
            break;
        case 'addPartenaire':
            $rts=new partenaireController();
            $rts->addPartenaire();
            
            break;
        case 'adminPartenairesView':
            $rts=new partenaireController();
            $rts->afficherPageAdmin();
            break;
        case 'addNewPart':
            $rts=new partenaireController();
            $rts->afficherPageAjoutPart();
            break;
        case 'deletePartenaire':
            $rts=new partenaireController();
            $rts->deletePartenaire();
            break;
        case 'getModifyPage':
            if (isset($_GET['id'])) {
                $controller = new PartenaireController();
                $controller->afficherModification($_GET['id']);
            }
            break;
        case 'getOffrePage':
            if (isset($_GET['id'])) {
                $controller = new PartenaireController();
                $controller->afficherPageOffres($_GET['id']);
            }
            break;
            
        case 'modifierPartenaire':
            $controller = new PartenaireController();
            $controller->modifyPartenaire();
            break;
        case 'ajouterRemise':
            $controller = new PartenaireController();
            $controller->addRemise();
            break;
        case 'ajouterAvantage':
            $controller = new PartenaireController();
            $controller->addAvantage();
            break;
        case 'getRemises':
            $controller = new PartenaireController();
            $controller->getRemises();
            break;
        case 'getAvantages':
            $controller = new PartenaireController();
            $controller->getAvantages();
            break;
        case 'deleteOffre':
            $controller = new PartenaireController();
            $controller->deleteOffre();
            break;
        case 'modifyOffre':
            $controller = new PartenaireController();
            $controller->modifyOffre();
            break;
        case 'afficherPageOffresV':
            $controller = new PartenaireController();
            $controller->afficherPageOffresV();
            break;
        case 'searchOffres':
            $controller = new PartenaireController();
            $controller->searchOffres();
            break;

        case 'getRandom10Offres':
            $controller = new PartenaireController();
            $controller->getRandom10Offres();
            break;
        case 'getRemiseByPartenaireId':
            $controller = new PartenaireController();
            $controller->getRemiseByPartenaireId();
            break;
    
    
    }
}
else{
    $r=new homeController();
    $r->afficherPage();
}

?>

