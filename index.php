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
require_once("Controller/donsBenevolatsAidesController.php");
require_once("Controller/carteController.php");
require_once("Controller/EventAnnonceController.php");
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
            if (!isset($_SESSION['user']) && !isset($_SESSION['member']) && !isset($_SESSION['admin']) && !isset($_SESSION['partenaire'])) {
            $r = new inscriptionController();
            $r->afficherPage();
            } else {
            // Redirect to home page or show an error message
            header("Location: index.php?router=Page%20d'accueil");
            }
            break; 
        case 'Mes infos':
            if (isset($_SESSION['user']) || isset($_SESSION['member']) || isset($_SESSION['admin'])) {
            $r = new userInfosController();
            $r->afficherPage();
            } else if (isset($_SESSION['partenaire'])) {
            $r = new partenaireController();
            $r->afficherPageInfos();
            } else {
            // Redirect to home page if no valid session is found
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break; 
        case 'Mon compte':
            if (isset($_SESSION['user']) || isset($_SESSION['member']) || isset($_SESSION['admin'])) {
            $r = new userCompteController();
            $r->afficherPage();
            } else if (isset($_SESSION['partenaire'])) {
            $r = new partenaireController();
            $r->afficherPageCompte();
            } else {
            // Redirect to home page if no valid session is found
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break;
        case 'securite':
            if (isset($_SESSION['user']) || isset($_SESSION['member']) || isset($_SESSION['admin']) || isset($_SESSION['partenaire'])) {
            $r = new securityController();
            $r->afficherPage();
            } else {
            // Redirect to home page if no valid session is found
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break; 
        case 'carte':
            if (isset($_SESSION['user']) || isset($_SESSION['member']) || isset($_SESSION['admin'])) {
            $r = new userController();
            $r->afficherPageCarte();
            } else {
            // Redirect to home page if no valid session is found
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break; 
        case 'users':
            if (isset($_SESSION['admin'])) {
            $r = new userController();
            $r->afficherPageUsers();
            } else {
            // Redirect to home page if not an admin
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
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
            if (isset($_SESSION['user']) || isset($_SESSION['member'])) {
            $rts = new userController();
            $rts->modifyPersoInfo();
            } else if (isset($_SESSION['partenaire'])) {
            $rts = new partenaireController();
            $rts->modifyPartenaire();
            }
            break;
        case 'modifyCompteInfo':
            if (isset($_SESSION['user']) || isset($_SESSION['member'])) {
            $rts = new userController();
            $rts->modifyCompteInfo();
            } else if (isset($_SESSION['partenaire'])) {
            $rts = new partenaireController();
            $rts->modifyCompteInfo();
            }
            break;

        case 'modifyPassword':
            if (isset($_SESSION['user']) || isset($_SESSION['member'])) {
            $rts = new userController();
            $rts->modifyPassword();
            } else if (isset($_SESSION['partenaire'])) {
            $rts = new partenaireController();
            $rts->modifyPassword();
            }
            break;
        case 'favoris':
            if (isset($_SESSION['user']) || isset($_SESSION['member']) || isset($_SESSION['admin'])) {
            $rts = new userController();
            $rts->afficherPageFavoris();
            } else {
            // Redirect to home page if no valid session is found
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break;
            case 'getFavoris':
                if (isset($_SESSION['user']) || isset($_SESSION['member']) || isset($_SESSION['admin'])) {
                    $rts = new userController();
                    $favoris = $rts->getFavoris();
                    echo json_encode($favoris);
                } else {
                    echo json_encode(['error' => 'Non autorisé']);
                }
                exit(); // Important pour l'AJAX
                break;
            case 'addFavoris':
                if (isset($_SESSION['user']) || isset($_SESSION['member']) || isset($_SESSION['admin'])) {
                    $rts = new userController();
                    $rts->addFavoris();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
                    exit();
                }
                break;
            
            case 'deleteFavoris':
                if (isset($_SESSION['user']) || isset($_SESSION['member']) || isset($_SESSION['admin'])) {
                    $rts = new userController();
                    $rts->deleteFavoris();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
                    exit();
                }
                break;
            
            case 'isInFavorites':
                if (isset($_SESSION['user']) || isset($_SESSION['member']) || isset($_SESSION['admin'])) {
                    $rts = new userController();
                    $rts->isInFavorites();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
                    exit();
                }
                break;
        case 'modifyPdp':
            if (isset($_SESSION['user']) || isset($_SESSION['member'])) {
            $rts = new userController();
            $rts->modifyPdp();
            } else if (isset($_SESSION['partenaire'])) {
            $rts = new partenaireController();
            $rts->modifyPdp();
            }
            break;

        case 'getUsers':
            $rts=new userController();
            $rts->getUsers();
            break;
            case 'getUser':
                $rts=new userController();
                $rts->getUserData();
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
            if (isset($_GET['partenaireId']) && isset($_GET['partenaireNom']) && isset($_GET['partenairePhoto'])&&isset($_GET['partenaireDescription'])&& isset($_GET['remise'])) {
                echo $controller->getPartCarte($_GET['partenaireId'], $_GET['partenaireNom'], $_GET['partenaireDescription'],$_GET['remise'],$_GET['partenairePhoto']);
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
            if (isset($_SESSION['admin'])) {
            $rts = new partenaireController();
            $rts->afficherPageAdmin();
            } else {
            // Redirect to home page if not an admin
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break;
        case 'addNewPart':
            if (isset($_SESSION['admin'])) {
            $rts = new partenaireController();
            $rts->afficherPageAjoutPart();
            } else {
            // Redirect to home page if not an admin
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break;
        case 'deletePartenaire':
            if (isset($_SESSION['admin'])) {
            $rts = new partenaireController();
            $rts->deletePartenaire();
            } else {
            // Redirect to home page if not an admin
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break;
        case 'getModifyPage':
            if (isset($_SESSION['admin'])) {
            if (isset($_GET['id'])) {
                $controller = new PartenaireController();
                $controller->afficherModification($_GET['id']);
            }
            } else {
            // Redirect to home page if not an admin
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break;
        case 'getOffrePage':
            if (isset($_SESSION['admin'])) {
            if (isset($_GET['id'])) {
                $controller = new PartenaireController();
                $controller->afficherPageOffres($_GET['id']);
            }
            } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break;
            
        case 'modifierPartenaire':
            if (isset($_SESSION['admin'])) {
            $controller = new PartenaireController();
            $controller->modifyPartenaire();
            } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break;
        case 'ajouterRemise':
            if (isset($_SESSION['admin'])) {
            $controller = new PartenaireController();
            $controller->addRemise();
            } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break;
        case 'ajouterAvantage':
            if (isset($_SESSION['admin'])) {
            $controller = new PartenaireController();
            $controller->addAvantage();
            } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break;
        case 'getRemises':
            if (isset($_SESSION['admin'])) {
            $controller = new PartenaireController();
            $controller->getRemises();
            } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break;
        case 'getAvantages':
            if (isset($_SESSION['admin'])) {
            $controller = new PartenaireController();
            $controller->getAvantages();
            } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break;
        case 'deleteOffre':
            if (isset($_SESSION['admin'])) {
            $controller = new PartenaireController();
            $controller->deleteOffre();
            } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break;
        case 'modifyOffre':
            if (isset($_SESSION['admin'])) {
            $controller = new PartenaireController();
            $controller->modifyOffre();
            } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
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
    case 'typesAide':
        $controller = new donsBenevolatsAidesController();
        $controller->getTypesAide();
        break;
        case 'pageAide':
            if (isset($_SESSION['user']) || isset($_SESSION['member']) || isset($_SESSION['admin'])) {
            $controller = new donsBenevolatsAidesController();
            $controller->afficher_pageAddAide();
            } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break;
    case 'addAide':
        if (isset($_SESSION['user']) || isset($_SESSION['member']) || isset($_SESSION['admin'])) {
            $controller = new donsBenevolatsAidesController();
            $controller->addAide();
        } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
        }
        break;
   
    case 'adminAide':
        if (isset($_SESSION['admin'])) {
            $controller = new donsBenevolatsAidesController();
            $controller->afficherPageAdminAide();
        } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
        }
        break;
    case 'addTypeAide':
        if (isset($_SESSION['admin'])) {
            $controller = new donsBenevolatsAidesController();
            $controller->addTypeAide();
        } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
        }
        break;
    case 'getAides':
        if (isset($_SESSION['admin'])) {
            $controller = new donsBenevolatsAidesController();
            $controller->getAides();
        } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
        }
        break;
        case 'pageDons':
            if (isset($_SESSION['admin'])) {
            $controller = new donsBenevolatsAidesController();
            $controller->afficher_pageDons();
            } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break;
        case 'pageAddDon':
            if (isset($_SESSION['user']) || isset($_SESSION['member']) || isset($_SESSION['admin'])) {
            $controller = new donsBenevolatsAidesController();
            $controller->afficher_pageAddDon();
            } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break;
    case 'addDon':
        if (isset($_SESSION['user']) || isset($_SESSION['member']) || isset($_SESSION['admin'])) {
            $controller = new donsBenevolatsAidesController();
            $controller->addDon();
        } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
        }
        break;
    case 'getDons':
        if (isset($_SESSION['admin'])) {
            $controller = new donsBenevolatsAidesController();
            $controller->getDons();
        } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
        }
        break;
    case 'approuverDon':
        if (isset($_SESSION['admin'])) {
            $controller = new donsBenevolatsAidesController();
            $controller->approuverDon();
        } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
        }
        break;
    case 'adminEventsView':
        if (isset($_SESSION['admin'])) {
            $controller = new EventAnnonceController();
            $controller->afficherPageAdminEvents();
        } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
        }
        break;
    case 'addEvent':
        if (isset($_SESSION['admin'])) {
            $controller = new EventAnnonceController();
            $controller->addEvent();
        } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
        }
        break;
    case 'getEventsActivities':
        $controller = new EventAnnonceController();
        $controller->getEventsActivities();
        break;
        case 'getEvents':
            $controller = new EventAnnonceController();
            $controller->getEvents();
            break;
    case 'adminActivitesView':
        if (isset($_SESSION['admin'])) {
            $controller = new EventAnnonceController();
            $controller->afficherPageAdminActivites();
        } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
        }
        break;
    case 'addActivite':
        if (isset($_SESSION['admin'])) {
            $controller = new EventAnnonceController();
            $controller->addActivite();
        } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
        }
        break;
    case 'getActivites':
        $controller = new EventAnnonceController();
        $controller->getActivites();
        break;
    case 'evenementView':
        if (isset($_SESSION['user']) || isset($_SESSION['member']) || isset($_SESSION['admin'])) {
            $controller = new EventAnnonceController();
            $controller->afficherPageEvenement();
        } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
        }
        break;
        
    case 'approuverBenevolat':
        $controller = new EventAnnonceController();
        $controller->addBenevole();
        break;
        case 'approuverBenevolat2':
            $controller = new EventAnnonceController();
            $controller->addBenevoleActivite();
            break;
    case 'scan':
        if (!isset($_SESSION['partenaire'])) {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
        }
        $controller = new PartenaireController();
        $controller->afficherPagePartenaireScan();
        break;
    case 'verifyQRCode':
        if (!isset($_SESSION['partenaire'])) {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
        }
        $controller = new userController();
        $controller->verifyQRCode();
        break;
    case 'getOffresId':
        $controller = new userController();
        $controller->getOffres();
        break;
    case 'getRemisesUser':
        $controller = new userController();
        $controller->getRemisesUser();
        break;
    case 'getDonsHistory':
        $controller = new donsBenevolatsAidesController();
        $controller->getDonsByUserId();
        break;
    case 'getBenevolatHistory':
        $controller = new donsBenevolatsAidesController();
        $controller->getBenevolatByUserId();
        break;
    case 'historiqueDons':
        if (isset($_SESSION['user']) || isset($_SESSION['member']) || isset($_SESSION['admin'])) {
            $controller = new donsBenevolatsAidesController();
            $controller->afficher_pageHistoriqueDons();
        } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
        }
        break;
    case 'historiqueBenevolat':
        if (isset($_SESSION['user']) || isset($_SESSION['member']) || isset($_SESSION['admin'])) {
            $controller = new donsBenevolatsAidesController();
            $controller->afficher_pageHistoriqueBenevolat();
        } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
        }
        break;
    case 'OffresProfite':
        $controller = new userController();
        $controller->getOffresProfite();
        break;

    case 'historiqueOffresProfite':
        if (isset($_SESSION['user']) || isset($_SESSION['member']) || isset($_SESSION['admin'])) {
            $controller = new userController();
            $controller->afficherPageHistoriqueOffresProfite();
        } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
        }
        break;
        case 'partenaireCarte':
            if (isset($_SESSION['partenaire'])) {
            $controller = new PartenaireController();
            $controller->afficherPageCarte();
            } else {
            header("Location: index.php?router=Page%20d'accueil");
            exit();
            }
            break;
        case 'getPartenaireLogos':
            $controller = new partenaireController();
            $controller->getPartenaireLogos();
            break;
            case 'bloquer':
                $controller = new userController();
                $controller->bloquer();
                break;

    }
}
else{
    $r=new homeController();
    $r->afficherPage();
}

?>

