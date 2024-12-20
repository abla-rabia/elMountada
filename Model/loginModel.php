<?php
require_once("Controller\loginController.php");
class loginModel{
    private $host = "localhost";
    private $dbname = "projettdw";
    private $username = "root";
    private $password = "";
    private $port = "3308";
    private function connexion(){
        $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->dbname";
        $pdo=new PDO($dsn, $this->username, $this->password);
        return ($pdo);
    }
    private function deconnexion($pdo){
        $pdo=null;
    }
    private function requete($pdo,$r,$userName){
        $stmt = $pdo->prepare($r);
        $stmt->execute([':userName' => $userName]);
        return $stmt;
    }
    function getUser($userName){
        $pdo=$this->connexion();
        $qtf="select * from user where username=:userName";
        $stmt=$this->requete($pdo,$qtf,$userName);
        $user = $stmt->fetch();
        $this->deconnexion($pdo);
        return $user;

    }
    function checkPassword($userName,$password){
        if (isset($userName) && isset($password)){
            $pdo=$this->connexion();
            $user=$this->getUser($userName);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $pswd=$user['password'];
            if (password_verify($password, $pswd)) {
                $this->deconnexion($pdo);
                return true;
            } else {
                $this->deconnexion($pdo);
                return false;
            }
        }
    }
}

?>