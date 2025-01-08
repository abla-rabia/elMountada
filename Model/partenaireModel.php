<?php
require_once(ROOT . '/Controller/partenairesController.php');
require_once(ROOT . '/Controller/dataBaseController.php');
require_once(ROOT . '/utils/qrCodeUtils.php');
class partenaireModel{
public function getCategories(){
    $r = new dataBaseController();
    $pdo = $r->connexion();
    $qtf = "SELECT * FROM categpart";
    $stmt = $r->query($pdo, $qtf, []);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $r->deconnexion($pdo);
    return $categories;
}
public function getPartenaireById($id){
    $r = new dataBaseController();
    $pdo = $r->connexion();
    $qtf = "SELECT * FROM partenaire where id=:id";
    $params = [
        'id' => $id
    ];
    $stmt = $r->query($pdo, $qtf, $params);
    $partenaire = $stmt->fetch();
    $r->deconnexion($pdo);
    return $partenaire;
}
public function getPartenaires(){
    $r = new dataBaseController();
    $pdo = $r->connexion();
    $qtf = "SELECT * FROM partenaire";
    $stmt = $r->query($pdo, $qtf, []);
    $partenaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $r->deconnexion($pdo);
    return $partenaires;
}

public function getPartenairesByCategorie($categ){
    $r = new dataBaseController();
    $pdo = $r->connexion();
    $qtf = "SELECT * FROM partenaire where categorie=:categ";
    $params = [
        'categ' => $categ
    ];
    $stmt = $r->query($pdo, $qtf, $params);
    $partenaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $r->deconnexion($pdo);
    return $partenaires;
}
}
?>