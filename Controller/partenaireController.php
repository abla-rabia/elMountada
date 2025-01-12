<?php

require_once(ROOT . '/Model/partenaireModel.php');
require_once(ROOT . '/View/adminPartenairesView.php');
require_once(ROOT . '/View/modifyPartView.php');
require_once(ROOT . '/View/adminOffresView.php');
require_once(ROOT . '/View/partenaireView.php');
require_once(ROOT . '/View/offresView.php');
require_once(ROOT . '/View/addPartenaireView.php');
class partenaireController{
    public function afficherPage($id){
        $v=new partenaireView();
        $v->afficher_page($id);
    }
    public function afficherPageOffresV(){
        $v=new offresView();
        $v->afficher_page();
    }
    public function afficherPageAjoutPart(){
        $v=new addPartenaireView();
        $v->afficher_page();
    }
    public function afficherPageCatalogue(){
        $v=new catalogueView();
        $v->afficher_page();
    }
    public function afficherPageAdmin(){
        $v=new adminPartenairesView();
        $v->afficher_page();
    }
    public function afficherModification($id){
        $v=new modifyPartView();
        $v->afficher_page($id);
    }
    public function getCategories() {
        $r = new partenaireModel();
        $categories = $r->getCategories();
        header('Content-Type: application/json');
        echo json_encode($categories);
    }
    private function uploadPhoto($name) {
        if (isset($_FILES[$name]) && $_FILES[$name]['error'] === UPLOAD_ERR_OK) {
            $targetDir = 'uploads/';
            $targetFile = $targetDir . basename($_FILES[$name]['name']);
            move_uploaded_file($_FILES[$name]['tmp_name'], $targetFile);
            return $targetFile;
        }
        return null;
    }
    
    public function getPartenairesByCategorie() {
        $r = new partenaireModel();
        $categ = $_POST['categorie'];
        $partenaires = $r->getPartenairesByCategorie($categ);
        header('Content-Type: application/json');
        echo json_encode($partenaires);
    }
    
    public function getPartenaires() {
        $r = new partenaireModel();
        $partenaires = $r->getPartenaires();
        header('Content-Type: application/json');
        echo json_encode($partenaires);
    }
    
    public function searchPart() {
        $r = new partenaireModel();
        $partenaires = $r->getPartenaires();
    
        if (!empty($_POST['searchPartenaire'])) {
            $searchKey = strtolower($_POST['searchPartenaire']);
            $partenaires = array_filter($partenaires, function($partenaire) use ($searchKey) {
                return strpos(strtolower($partenaire['nom']), $searchKey) !== false ||
                       strpos(strtolower($partenaire['ville']), $searchKey) !== false ||
                       strpos(strtolower($partenaire['categorie']), $searchKey) !== false;
            });
        }
    
        if (!empty($_POST['filterVille'])) {
            $filterVille = $_POST['filterVille'];
            $partenaires = array_filter($partenaires, function($partenaire) use ($filterVille) {
                return $partenaire['ville'] == $filterVille;
            });
        }
    
        if (!empty($_POST['filterCategorie'])) {
            $filterCategorie = $_POST['filterCategorie'];
            $partenaires = array_filter($partenaires, function($partenaire) use ($filterCategorie) {
                return $partenaire['categorie'] == $filterCategorie;
            });
        }
    
        header('Content-Type: application/json');
        echo json_encode(array_values($partenaires));
    }
    
    public function getPartenaireById() {
        $r = new partenaireModel();
        $id = $_POST['id_partenaire'];
        $partenaire = $r->getPartenaireById($id);
        header('Content-Type: application/json');
        echo json_encode($partenaire);
    }
    public function getSection($categorie) {
        $view = new catalogueView();
        ob_start();
        $view->section($categorie);
        return ob_get_clean();
    }
    public function sendIdPartenaireView($id) {
        $view = new partenaireView();
        
        $view->afficher_page($id);
        
    }
    public function getPartCarte($id,$nom,$description,$remise) {
        $view = new commonViews();
        ob_start();
        $view->partenaireCard($id,$nom,$description,$remise);
        return ob_get_clean();
    }

    public function addPartenaire() {
        
        $r = new partenaireModel();
        $credentials = [
            'nom' => $_POST['nom'],
            'description' => $_POST['description'],
            'ville' => $_POST['ville'],
            'photo' => $this->uploadPhoto('photo'),
            'logo' => $this->uploadPhoto('logo'),
            'categorie' => $_POST['categorie'],
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'telNumber' => $_POST['telNumber'],
            'website' => $_POST['website'],
            'contactmail' => $_POST['contactmail']
        ];
        

        foreach ($credentials as $key => $value) {
            echo "ablus";
            if (empty($value)) {
                return 3;
            }
        }
        if (!($resul = $r->problemAddPartenaire($credentials))) {
            
            $r->addPartenaire($credentials);
            return 1;
        } else {
            return $resul;
        }
    }
    public function deletePartenaire() {
        $id=$_POST['id'];
        $r = new partenaireModel();
        $r->deletePartenaire($id);
        header('Content-Type: application/json');
        $response = ['success' => true, 'message' => 'Partenaire supprimé avec succès'];
        echo json_encode($response);
    }


    public function modifyPartenaire() {
        try {
            if (!isset($_POST['id'])) {
                echo json_encode(['success' => false, 'message' => 'ID manquant']);
                return;
            }
    
            $credentials = [
                'nom' => $_POST['nom'] ?? '',
                'ville' => $_POST['ville'] ?? '',
                'categorie' => $_POST['categorie'] ?? '',
                'description' => $_POST['description'] ?? '',
                'telNumber' => $_POST['tel'] ?? '',
                'website' => $_POST['site'] ?? '',
                'contactmail' => $_POST['mail'] ?? '',
                'id' => $_POST['id']
            ];
            
            // Validation
            foreach ($credentials as $key => $value) {
                if (empty($value)) {
                    echo json_encode(['success' => false, 'message' => "Le champ $key ne peut pas être vide!"]);
                    return;
                }
            }
    
            $r = new partenaireModel();
            $result = $r->modifyPartenaire($credentials);
            
            if ($result === true) {
                echo json_encode(['success' => true, 'message' => 'Partenaire modifié avec succès']);
            } else {
                echo json_encode(['success' => false, 'message' => $result]);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
        }
    }


    public function modifyPassword() {
        $r = new partenaireModel();
        $credentials = [
            'password' => $_POST['password'],
            'id' => $_SESSION['partenaire']['id']
        ];

        if (empty($credentials['password'])) {
            return "Erreur : le mot de passe ne peut pas être vide !";
        }

        $result = $this->passwordRules($credentials['password']);
        if ($result != 1) {
            echo $result;
            return;
        }

        $r->modifyPassword($credentials);
        echo 1;
    }

    public function  afficherPageOffres($id){
        $v=new adminOffresView();
        $v->afficher_page($id);
    }

    //fonctionnalités sur les remises et offres 
    //1- création remise 
    public function addRemise() {
        
        $r = new partenaireModel();
        $credentials = [
            'contenu' => $_POST['contenu'],
            'partenaireId' => $_POST['partenaireId'],
            'carteId' => $_POST['carteId'],
            'type' => 'remise'
        ];
        

        foreach ($credentials as $key => $value) {
            if (empty($value)) {
                return 3;
            }
        }
        if (!($resul = $r->problemAddRemise($credentials))) {
            
            $r->addOffre($credentials);
            echo 1;
        } else {
            return $resul;
        }
    }
    public function addAvantage() {
        
        $r = new partenaireModel();
        $credentials = [
            'contenu' => $_POST['contenu'],
            'partenaireId' => $_POST['partenaireId'],
            'carteId' => $_POST['carteId'],
            'type' => 'avantage'
        ];
        

        foreach ($credentials as $key => $value) {
            if (empty($value)) {
                return 3;
            }
        }
        if (!($resul = $r->problemAddRemise($credentials))) {
            
            $r->addOffre($credentials);
            echo 1;
        } else {
            return $resul;
        }
    }

    public function getRemises(){
        $id_partenaire=$_POST['idPartenaire'];
        $r = new partenaireModel();
        $remises = $r->getRemises($id_partenaire);
        header('Content-Type: application/json');
        echo json_encode($remises);
    }
    public function getAvantages(){
        $id_partenaire=$_POST['idPartenaire'];
        $r = new partenaireModel();
        $avantages = $r->getAvantages($id_partenaire);
        header('Content-Type: application/json');
        echo json_encode($avantages);
    }

    public function modifyOffre() {
        try {
            if (!isset($_POST['id'])) {
                echo json_encode(['success' => false, 'message' => 'ID manquant']);
                return;
            }
    
            $credentials = [
                'contenu' => $_POST['contenu'] ?? '',
                'id_carte' => $_POST['carteType'] ?? '',
                'id' => $_POST['id']
            ];
            
            // Validation
            foreach ($credentials as $key => $value) {
                if (empty($value)) {
                    echo json_encode(['success' => false, 'message' => "Le champ $key ne peut pas être vide!"]);
                    return;
                }
            }
    
            $r = new partenaireModel();
            $result = $r->modifyOffre($credentials);
            
            if ($result === true) {
                echo 1;
            } else {
                echo json_encode(['success' => false, 'message' => $result]);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
        }
    }
    public function deleteOffre() {
        $id=$_POST['id'];
        $r = new partenaireModel();
        $r->deleteOffre($id);
        header('Content-Type: application/json');
        $response = ['success' => true, 'message' => 'Partenaire supprimé avec succès'];
        echo json_encode($response);
    }
    //page d'ajout d'un offre
    public function afficherPageAjoutOffre(){
        $v=new addOffreView();
        $v->afficher_page();
    }

    public function searchOffres() {
        $r = new partenaireModel();
        $offres = $r->getAllOffres();
    
        if (!empty($_POST['searchOffre'])) {
            $searchKey = strtolower($_POST['searchOffre']);
            $offres = array_filter($offres, function($offre) use ($searchKey) {
                return strpos(strtolower($offre['offreContenu']), $searchKey) !== false ||
                       strpos(strtolower($offre['offreType']), $searchKey) !== false ||
                       strpos(strtolower($offre['partenaireCategorie']), $searchKey) !== false||
                       strpos(strtolower($offre['partenaireNom']), $searchKey) !== false;
            });
        }
    
        if (!empty($_POST['filterType'])) {
            $filterType = $_POST['filterType'];
            $offres = array_filter($offres, function($offre) use ($filterType) {
                return $offre['offreType'] == $filterType;
            });
        }
        if (!empty($_POST['filterVille'])) {
            $filterVille = $_POST['filterVille'];
            $offres = array_filter($offres, function($offre) use ($filterVille) {
                return $offre['partenaireVille'] == $filterVille;
            });
        }
        if (!empty($_POST['filterCategorie'])) {
            $filterCategorie = $_POST['filterCategorie'];
            $offres = array_filter($offres, function($offre) use ($filterCategorie) {
                return $offre['partenaireCategorie'] == $filterCategorie;
            });
        }
    
        header('Content-Type: application/json');
        echo json_encode(array_values($offres));
    }
    
    public function getRandom10Offres(){
        $r = new partenaireModel();
        $offres = $r->getAllOffres();
        shuffle($offres);
        $randomOffres = array_slice($offres, 0, 10);
        $randomOffres = $this->ensureTenElements($randomOffres);
        header('Content-Type: application/json');
        echo json_encode($randomOffres);
    }

    private function ensureTenElements($array) {
        $count = count($array);
        if ($count < 10) {
            $repeats = array();
            while (count($repeats) + $count < 10) {
                $repeats = array_merge($repeats, $array);
            }
            $repeats = array_slice($repeats, 0, 10 - $count);
            $array = array_merge($array, $repeats);
        }
        return $array;
    }

    public function getRemiseByPartenaireId(){
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('ID parameter is missing');
            }
            
            $id = $_GET['id'];
            $r = new partenaireModel();
            $remise = $r->getRemiseByPartenaireId($id);
            
            // Make sure no output has been sent before headers
            if (!headers_sent()) {
                header('Content-Type: application/json');
            }
            
            echo json_encode(['remise' => $remise]);
            exit;
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }
}
?>
