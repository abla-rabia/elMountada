<?php
class dataBaseModel{
private $host = "localhost";
private $dbname = "tdw";
private $username = "root";
private $password = "";
private $port = "3308";
public function connexion(){
    $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->dbname";
$pdo=new PDO($dsn, $this->username, $this->password);
    return ($pdo);
}
public function deconnexion($pdo){
    $pdo=null;
}
public function query($pdo, $query, $params = []) {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt;
}
}
?>