<?php
require_once(ROOT . '/Controller/userController.php');
require_once(ROOT . '/Controller/dataBaseController.php');

class userModel {
    public function getUser($userName) {
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf = "SELECT * FROM user WHERE username = :username";
        $stmt = $r->query($pdo, $qtf, ['username' => $userName]);
        $user = $stmt->fetch();
        $r->deconnexion($pdo);
        return $user;
    }

    public function checkPassword($userName, $password) {
        $r = new dataBaseController();
        if (isset($userName) && isset($password)) {
            $pdo = $r->connexion();
            $user = $this->getUser($userName);
            $pswd = $user['password'];
            if (password_verify($password, $pswd)) {
                $r->deconnexion($pdo);
                return true;
            } else {
                $r->deconnexion($pdo);
                return false;
            }
        }
    }

    public function problemInscription($credentials) {
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "SELECT * FROM user WHERE email = :email";
            $res = $r->query($pdo, $qtf, ['email' => $credentials['email']]);
            if ($res->rowCount() > 0) {
                $r->deconnexion($pdo);
                return "L'email est déjà utilisé";
            }

            $qtf = "SELECT * FROM user WHERE username = :username";
            $res = $r->query($pdo, $qtf, ['username' => $credentials['username']]);
            if ($res->rowCount() > 0) {
                $r->deconnexion($pdo);
                return "Le nom d'utilisateur est déjà utilisé";
            }

            $r->deconnexion($pdo);
            return false; // tout est bon
        }
        return true; // cas où le user n'a rien entré ...
    }

    public function inscriptionSimple($credentials) {
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "INSERT INTO user (username, email, `password`, telNumber, birthDate, nom, prenom, photoId, photo) VALUES (:username, :email, :password, :telNumber, :birthDate, :nom, :prenom, :photoId, :photo)";
            $params = [
                'username' => $credentials['username'],
                'email' => $credentials['email'],
                'password' => password_hash($credentials['password'], PASSWORD_DEFAULT),
                'telNumber' => $credentials['telNumber'],
                'birthDate' => $credentials['birthDate'],
                'nom' => $credentials['nom'],
                'prenom' => $credentials['prenom'],
                'photoId' => $credentials['idPhoto'],
                'photo' => $credentials['persoPhoto']
            ];
            $res = $r->query($pdo, $qtf, $params);
            $r->deconnexion($pdo);
        }
    }
}
?>