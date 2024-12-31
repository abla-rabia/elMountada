<?php
require_once(ROOT . '/Controller/userController.php');
require_once(ROOT . '/Controller/dataBaseController.php');
class userModel{
    public function getUser($userName){
        $r=new dataBaseController();
        $pdo=$r->connexion();
        $qtf="select * from user where username='$userName'";
        $stmt=$r->query($pdo,$qtf);
        $user = $stmt->fetch();
        $r->deconnexion($pdo);
        return $user;

    }
    public function checkPassword($userName,$password){
        $r=new dataBaseController();
        if (isset($userName) && isset($password)){
            $pdo=$r->connexion();
            $user=$this->getUser($userName);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $pswd=$user['password'];
            if (password_verify($password, $pswd)) {
                $r->deconnexion($pdo);
                return true;
            } else {
                $r->deconnexion($pdo);
                return false;
            }
        }
    }

    public function problemInscription($credentials){
        $r=new dataBaseController();
        if (isset($credentials)){
            $pdo=$r->connexion();
            $qtf="select * from user where email='".$credentials['email']."'";
            $res=$r->query($pdo, $qtf);
            if ($res->rowCount() > 0) {
                return "L'email est déjà utilisé";
                $r->deconnexion($pdo);
                return true;
            }

            $qtf="select * from user where username='".$credentials['username']."'";
            $res=$r->query($pdo, $qtf);
            if ($res->rowCount() > 0) {
                return "Le nom d'utilisateur est déjà utilisé";
                $r->deconnexion($pdo);
                return true;
            }
                return false; //tout est bon
                $r->deconnexion($pdo);
            }
            return true;//cas ou le user n'a rien entré ...
            $r->deconnexion($pdo);

        }
    public function inscriptionSimple($credentials){
        $r=new dataBaseController();
        if (isset($credentials)){
            $pdo=$r->connexion();
            $qtf="INSERT INTO user (username, email, `password`, telNumber, birthDate, nom, prenom, photoId, photo) VALUES ('".$credentials['username']."', '".$credentials['email']."', '".password_hash($credentials['password'], PASSWORD_DEFAULT)."', '".$credentials['telNumber']."', '".$credentials['birthDate']."', '".$credentials['nom']."', '".$credentials['prenom']."', '".$credentials['idPhoto']."', '".$credentials['persoPhoto']."')";
            $res=$r->query($pdo, $qtf);
            $r->deconnexion($pdo);
        }
    }
}

?>