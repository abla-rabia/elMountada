<?php

require_once(ROOT . '/Model/donsBenevolatsAidesModel.php');
require_once(ROOT . '/View/addAideView.php');
require_once(ROOT . '/View/adminAidesView.php');
require_once(ROOT . '/View/addDonView.php');
require_once(ROOT . '/View/adminDonsView.php');
require_once(ROOT . '/View/historiqueDons.php');
require_once(ROOT . '/View/historiqueBenevolat.php');
class DonsBenevolatsAidesController 
{
    public function afficher_pageAddAide() {
        $view = new addAideView();
        
        $view->afficher_page();
    }
    public function afficherPageAdminAide() {
        $view = new adminAidesView();
        
        $view->afficher_page();
    }
    public function addTypeAide() {
        
        $r = new DonsBenevolatsAidesModel();
        $credentials = [
            'nom' => $_POST['nom'],
            'description' => $_POST['description']
        ];
        

        foreach ($credentials as $key => $value) {
            if (empty($value)) {
                return 3;
            }
        }
        if (!($resul = $r->problemAddTypeAide($credentials))) {
            
            $r->addTypeAide($credentials);
            echo 1;
        } else {
            return $resul;
        }
    }
    public function getTypesAide() {
        $r = new DonsBenevolatsAidesModel();
        $typesAide = $r->getTypesAide();
        header('Content-Type: application/json');
        echo json_encode($typesAide);
    }
    public function addAide() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $view = new addAideView();
            $view->afficher_page();
            return;
        }

        $r = new DonsBenevolatsAidesModel();
        $credentials = [
            'nom' => $_POST['nom'] ?? '',
            'prenom' => $_POST['prenom'] ?? '',
            'description' => $_POST['description'] ?? '',
            'id_user' => $_SESSION['user']['id'] ?? $_SESSION['member']['id'] ?? null,
            'id_type_aide' => $_POST['id_type_aide'] ?? ''
        ];

        // Vérification des champs requis
        foreach ($credentials as $key => $value) {
            if (empty($value)) {
                $_SESSION['error_message'] = "Tous les champs sont obligatoires";
                header("Location: index.php?router=$value");
                exit();
            }
        }

        // Gestion du fichier
        if (isset($_FILES['dossier']) && $_FILES['dossier']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = 'dossiersZip/';
            
            // Créer le répertoire s'il n'existe pas
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $uploadFile = $uploadDir . basename($_FILES['dossier']['name']);
            
            if (move_uploaded_file($_FILES['dossier']['tmp_name'], $uploadFile)) {
                $credentials['dossier_zip'] = $uploadFile;
            } else {
                $_SESSION['error_message'] = "Erreur lors du téléchargement du fichier";
                header('Location: index.php?router=pageAide');
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Le fichier ZIP est obligatoire";
            header('Location: index.php?router=pageAide');
            exit();
        }

        try {
            // Ajout de l'aide dans la base de données
            $result = $r->addAide($credentials);
            
            $_SESSION['success_message'] = "L'aide a été ajoutée avec succès";
            header('Location: index.php?router=pageAide');
            exit();
            
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Une erreur est survenue : " . $e->getMessage();
            header('Location: index.php?router=pageAddAide');
            exit();
        }
    }
    public function getAides() {
        $r = new DonsBenevolatsAidesModel();
        $Aides = $r->getAides();
        header('Content-Type: application/json');
        echo json_encode($Aides);
    }

    public function afficher_pageAddDon() {
        $view = new addDonView();
        $view->afficher_page();
    }

    public function afficher_pageDons() {
        $view = new adminDonsView();
        $view->afficher_page();
    }

    public function addDon() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?router=pageAddDon');
            exit();
        }

        $r = new DonsBenevolatsAidesModel();
        
        if (isset($_FILES['recu']) && $_FILES['recu']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = 'recusDons/';
            
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $uploadFile = $uploadDir . basename($_FILES['recu']['name']);
            
            if (move_uploaded_file($_FILES['recu']['tmp_name'], $uploadFile)) {
                $credentials = [
                    'recu' => $uploadFile,
                    'id_user' => $_SESSION['user']['id'] ?? $_SESSION['member']['id'] ?? null,
                ];

                try {
                    if ($r->addDon($credentials)) {
                        $_SESSION['success_message'] = "Le don a été ajouté avec succès";
                    } else {
                        $_SESSION['error_message'] = "Erreur lors de l'ajout du don";
                    }
                } catch (Exception $e) {
                    $_SESSION['error_message'] = "Une erreur est survenue";
                }
            } else {
                $_SESSION['error_message'] = "Erreur lors du téléchargement du reçu";
            }
        } else {
            $_SESSION['error_message'] = "Le reçu est obligatoire";
        }

        header('Location: index.php?router=pageAddDon');
        exit();
    }

    public function getDons() {
        $r = new DonsBenevolatsAidesModel();
        $dons = $r->getDons();
        header('Content-Type: application/json');
        echo json_encode($dons);
    }

    public function approuverDon() {
        if (!isset($_POST['id'])) {
            echo json_encode(['success' => false]);
            return;
        }

        $r = new DonsBenevolatsAidesModel();
        $success = $r->approuverDon($_POST['id']);
        echo json_encode(['success' => $success]);
    }
    public function getDonsByUserId(){
        $id = $_SESSION['user']['id'] ?? $_SESSION['member']['id'];
        $r = new DonsBenevolatsAidesModel();
        $dons = $r->getDonsByUserId($id);
        header('Content-Type: application/json');
        echo json_encode($dons);
    }
    public function getBenevolatByUserId() {
        $id = $_SESSION['user']['id'] ?? $_SESSION['member']['id'];
        $r = new DonsBenevolatsAidesModel();
        $benevolats = $r->getBenevolatsByUserId($id);
        header('Content-Type: application/json');
        echo json_encode($benevolats);
    }

    public function afficher_pageHistoriqueDons() {
        $view = new historiqueDons();
        $view->afficher_page();
    }
public function afficher_pageHistoriqueBenevolat() {
    $view = new historiqueBenevolat();
    $view->afficher_page();
}
}

?>
