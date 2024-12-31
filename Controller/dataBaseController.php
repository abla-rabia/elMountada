<?php
require_once(ROOT . '/Model/dataBaseModel.php');

class dataBaseController{
public function connexion(){
    $r= new dataBaseModel();
    return $r->connexion();
}
public function deconnexion($pdo){
    $r= new dataBaseModel();
    $r->deconnexion($pdo);
}
public function query($pdo, $query, $params = []){
    $r = new dataBaseModel();
    return $r->query($pdo, $query, $params);
}
}
?>