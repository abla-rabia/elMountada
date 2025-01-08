<?php
require_once("View\partenaireView.php");
require_once(ROOT . '/Model/partenaireController.php');
class partenaireController{
    public function afficherPage($id){
        $v=new partenaireView();
        $v->afficher_page($id);
    }
    public function afficherPageCatalogue(){
        $v=new catalogueView();
        $v->afficher_page();
    }
    public function getCategories() {
        $r = new partenaireModel();
        $categories = $r->getCategories();
        header('Content-Type: application/json');
        echo json_encode($categories);
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
    
}
?>