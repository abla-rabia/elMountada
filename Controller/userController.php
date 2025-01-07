<?php

require_once(ROOT . '/View/loginView.php');
require_once(ROOT . '/View/FavorisView.php');
require_once(ROOT . '/View/adminGetMembersView.php');
require_once(ROOT . '/Model/userModel.php');

class userController {
    public function login() {
        $userName = $_POST['userName'];
        $password = $_POST['password'];
        $mdl = new userModel();
        $user = $mdl->getUser($userName);

        if ($user) {
            if ($mdl->checkPassword($userName, $password)) {
                if ($user["approuve"] == 0) {
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'nom' => $user['nom'],
                        'prenom' => $user['prenom'],
                        'photoProfile' => $user['photoProfile'],
                        'telNumber' => $user['telNumber'],
                        'birthDate' => $user['birthDate']
                    ];
                } else {
                    $_SESSION['member'] = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'nom' => $user['nom'],
                        'carte' => $user['carte'],
                        'prenom' => $user['prenom'],
                        'photoProfile' => $user['photoProfile'],
                        'telNumber' => $user['telNumber'],
                        'birthDate' => $user['birthDate']
                    ];
                }
                header("Location: index.php?router=Page%20d'accueil");
                print_r($_SESSION);
            } else {
                return "Mot de passe incorrect";
            }
        } else {
            return "Utilisateur inéxistant";
        }
        return 1;
    }

    public function afficherPageLogin() {
        $v = new loginView();
        $v->afficher_page();
    }

    public function afficherPageCarte() {
        $v = new CarteView();
        $v->afficher_page();
    }

    public function afficherPageFavoris() {
        $v = new FavorisView();
        $v->afficher_page();
    }

    public function afficherPageUsers() {
        $v = new adminUsersView();
        $v->afficher_page();
    }

    public function inscriptionSimple() {
        $r = new userModel();
        $credentials = [
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'telNumber' => $_POST['telNumber'],
            'birthDate' => $_POST['birthDate'],
            'username' => $_POST['username'],
            'idPhoto' => $this->uploadPhoto('idPhoto'),
            'persoPhoto' => $this->uploadPhoto('persoPhoto')
        ];

        foreach ($credentials as $key => $value) {
            if (empty($value)) {
                return 3;
            }
        }

        if (!($resul = $r->problemInscription($credentials))) {
            $r->inscriptionSimple($credentials);
            return 1;
        } else {
            return $resul;
        }
    }

    public function inscriptionMembre() {
        $r = new userModel();
        $credentials = [
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'telNumber' => $_POST['telNumber'],
            'birthDate' => $_POST['birthDate'],
            'username' => $_POST['username'],
            'idPhoto' => $this->uploadPhoto('idPhoto'),
            'persoPhoto' => $this->uploadPhoto('persoPhoto'),
            'recu' => $this->uploadPhoto('recu'),
            'plan' => $_POST['plan']
        ];

        foreach ($credentials as $key => $value) {
            if (empty($value)) {
                return 3;
            }
        }

        if (!($resul = $r->problemInscription($credentials))) {
            $r->inscriptionMembre($credentials);
            return 1;
        } else {
            return $resul;
        }
    }

    public function paiement() {
        $r = new userModel();
        $credentials = [
            'recu' => $this->uploadPhoto2('recu'),
            'plan' => $_POST['plan'],
            'id' => $_SESSION['user']['id']
        ];

        foreach ($credentials as $key => $value) {
            if (empty($value)) {
                return 3;
            }
        }

        $r->paiement($credentials);
        echo 1;
    }

    private function uploadPhoto($name) {
        if (isset($_FILES[$name]) && $_FILES[$name]['error'] === UPLOAD_ERR_OK) {
            $targetDir = '../uploads/';
            $targetFile = $targetDir . basename($_FILES[$name]['name']);
            move_uploaded_file($_FILES[$name]['tmp_name'], $targetFile);
            return $targetFile;
        }
        return null;
    }

    private function uploadPhoto2($name) {
        if (isset($_FILES[$name]) && $_FILES[$name]['error'] === UPLOAD_ERR_OK) {
            $targetDir = 'uploads/';
            $targetFile = $targetDir . basename($_FILES[$name]['name']);
            move_uploaded_file($_FILES[$name]['tmp_name'], $targetFile);
            return $targetFile;
        }
        return null;
    }

    public function logout() {
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
        header("Location: index.php?router=Page%20d'accueil");
        exit();
    }

    public function getRecu() {
        $userId = $_POST['userId'];
        $r = new userModel();
        if (isset($userId)) {
            $recu = $r->getRecu($userId);
            header('Content-Type: application/json');
            echo json_encode($recu);
        }
    }

    public function modifyPersoInfo() {
        $r = new userModel();
        $credentials = [
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'telNumber' => $_POST['telNumber'],
            'birthDate' => $_POST['birthDate'],
            'id' => $_POST['id']
        ];

        foreach ($credentials as $key => $value) {
            if (empty($value)) {
                return "Erreur : $key ne peut pas etre vide !";
            }
        }

        $_SESSION['user']['nom'] = $credentials['nom'];
        $_SESSION['user']['prenom'] = $credentials['prenom'];
        $_SESSION['user']['telNumber'] = $credentials['telNumber'];
        $_SESSION['user']['birthDate'] = $credentials['birthDate'];
        $resu = $r->modifyPersoInfo($credentials);
        return $resu;
    }

    public function modifyCompteInfo() {
        $r = new userModel();
        $credentials = [
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'id' => $_POST['id']
        ];

        foreach ($credentials as $key => $value) {
            if (empty($value)) {
                return "Erreur : $key ne peut pas etre vide !";
            }
        }

        $_SESSION['user']['username'] = $credentials['username'];
        $_SESSION['user']['email'] = $credentials['email'];
        $r->modifyCompteInfo($credentials);
        return 1;
    }

    public function modifyPassword() {
        $r = new userModel();
        $credentials = [
            'password' => $_POST['password'],
            'id' => $_SESSION['user']['id']
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

    public function passwordRules($password) {
        if (strlen($password) < 8) {
            return "Le mot de passe doit avoir au moins 8 caractères !";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            return "Le mot de passe doit inclure une majuscule !";
        }
        if (!preg_match('/[a-z]/', $password)) {
            return "Le mot de passe doit inclure une minuscule !";
        }
        if (!preg_match('/[0-9]/', $password)) {
            return "Le mot de passe doit inclure un chiffre !";
        }
        if (!preg_match('/[\W_]/', $password)) {
            return "Le mot de passe doit inclure un caractère spécial (ex. !@#$%^&*) !";
        }
        return 1;
    }

    public function modifyPdp() {
        $r = new userModel();
        $credentials = [
            'photoProfile' => $this->uploadPhoto2('photoProfile'),
            'id' => $_SESSION['user']['id']
        ];

        foreach ($credentials as $key => $value) {
            if (empty($value)) {
                return "Erreur : $key ne peut pas etre vide !";
            }
        }

        $_SESSION['user']['photoProfile'] = $credentials['photoProfile'];
        $r->modifyPdp($credentials);
        echo $credentials['photoProfile'];
    }

    public function getUsers() {
        $r = new userModel();
        $users = $r->getUsers();
        header('Content-Type: application/json');
        echo json_encode($users);
    }

    public function getCartes() {
        $r = new userModel();
        $cartes = $r->getCartes();
        header('Content-Type: application/json');
        echo json_encode($cartes);
    }

    public function isMember($id) {
        $r = new userModel();
        if (isset($id)) {
            $result = $r->isMember($id);
            return $result;
        }
    }

    public function getUser($id) {
        $r = new userModel();
        if (isset($id)) {
            $user = $r->getUser($id);
            return $user;
        }
    }

    public function searchUser() {
        $r = new userModel();
        $users = $r->getUsers();

        if (!empty($_POST['searchUser'])) {
            $searchKey = strtolower($_POST['searchUser']);
            $users = array_filter($users, function($user) use ($searchKey) {
                return strpos(strtolower($user['username']), $searchKey) !== false ||
                       strpos(strtolower($user['email']), $searchKey) !== false ||
                       strpos(strtolower($user['nom']), $searchKey) !== false ||
                       strpos(strtolower($user['prenom']), $searchKey) !== false;
            });
        }

        if (!empty($_POST['dateMin'])) {
            $dateMin = $_POST['dateMin'];
            $users = array_filter($users, function($user) use ($dateMin) {
                return $user['date_inscription'] >= $dateMin;
            });
        }

        if (!empty($_POST['dateMax'])) {
            $dateMax = $_POST['dateMax'];
            $users = array_filter($users, function($user) use ($dateMax) {
                return $user['date_inscription'] <= $dateMax;
            });
        }

        if (!empty($_POST['filterType'])) {
            $filterType = $_POST['filterType'];
            $users = array_filter($users, function($user) use ($filterType) {
                if ($filterType == "1") return $user['approuve'] == 0;
                if ($filterType == "2") return $user['approuve'] == 1;
                return true;
            });
        }

        header('Content-Type: application/json');
        echo json_encode(array_values($users));
    }

    public function getMembers() {
        $r = new userModel();
        $users = $r->getMembers();
        return $users;
    }

    public function getSimpleUsers() {
        $r = new userModel();
        $users = $r->getSimpleUsers();
        return $users;
    }

    public function approuverMembre() {
        $id = $_POST['id'];
        $type_carte = $_POST['carteType'];
        $r = new userModel();
        if (isset($id)) {
            $r->approuverMembre($id, $type_carte);
            echo 1;
        }
    }

    public function getCarteById() {
        $id = $_SESSION['member']['carte'];
        $r = new userModel();
        if (isset($id)) {
            header('Content-Type: application/json');
            echo json_encode($r->getCarteById($id));
        }
    }

    public function getFavoris() {
        if (isset($_SESSION['user'])) {
            $id_user = $_SESSION['user']['id'];
        } elseif (isset($_SESSION['member'])) {
            $id_user = $_SESSION['member']['id'];
        }
        $r = new userModel();
        return $r->getFavoris($id_user);
    }

    public function addFavoris($id_partenaire) {
        if (isset($_SESSION['user'])) {
            $id_user = $_SESSION['user']['id'];
        } elseif (isset($_SESSION['member'])) {
            $id_user = $_SESSION['member']['id'];
        }
        $r = new userModel();
        $r->addFavoris($id_user, $id_partenaire);
    }

    public function getOffres() {
        if (isset($_SESSION['user'])) {
            $id_user = $_SESSION['user']['id'];
        } elseif (isset($_SESSION['member'])) {
            $id_user = $_SESSION['member']['id'];
        }
        $r = new userModel();
        $offres = $r->getOffres($id);
        header('Content-Type: application/json');
        echo json_encode($offres);
    }

    
}
?>
