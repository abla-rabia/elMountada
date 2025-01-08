<?php

require_once(ROOT . '/Model/partenaireModel.php');
require_once(ROOT . '/View/adminPartenairesView.php');
require_once(ROOT . '/View/addPartenaireView.php');
class partenaireController{
    public function afficherPage($id){
        $v=new partenaireView();
        $v->afficher_page($id);
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
    public function getPartCarte($id,$nom,$description) {
        $view = new commonViews();
        ob_start();
        $view->partenaireCard($id,$nom,$description);
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
    }


    public function modifyPartenaire() {
        $r = new userModel();
        $credentials = [
            'nom' => $_POST['nom'],
            'description' => $_POST['description'],
            'ville' => $_POST['ville'],
            'categorie' => $_POST['categorie'],
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'telNumber' => $_POST['telNumber'],
            'website' => $_POST['website'],
            'contactmail' => $_POST['contactmail'],
            'id' => $_POST['id']
        ];

        foreach ($credentials as $key => $value) {
            if (empty($value)) {
                return "Erreur : $key ne peut pas etre vide !";
            }
        }

        $_SESSION['partenaire']['nom'] = $credentials['nom'];
        $_SESSION['partenaire']['description'] = $credentials['description'];
        $_SESSION['partenaire']['ville'] = $credentials['ville'];
        $_SESSION['partenaire']['categorie'] = $credentials['categorie'];
        $_SESSION['partenaire']['email'] = $credentials['email'];
        $_SESSION['partenaire']['telNumber'] = $credentials['telNumber'];
        $_SESSION['partenaire']['website'] = $credentials['website'];
        $_SESSION['partenaire']['contactmail'] = $credentials['contactmail'];
        $resu = $r->modifyPartenaire($credentials);
        return $resu;
    }


    public function modifyPassword() {
        $r = new userModel();
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
}
?>
