<?php

require_once(ROOT . '/View/loginView.php');
require_once(ROOT . '/View/FavorisView.php');
require_once(ROOT . '/View/adminGetMembersView.php');
require_once(ROOT . '/View/historiqueOffresProfite.php');
require_once(ROOT . '/Model/userModel.php');
require_once(ROOT . '/Model/partenaireModel.php');

class userController {
    public function login() {
        $userName = $_POST['userName'];
        $password = $_POST['password'];
        $mdl = new userModel();
        $mdl2 = new partenaireModel();
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
        }elseif ($partenaire = $mdl2->getPartenaire($userName)){
            if ($mdl2->checkPartenairePassword($userName, $password)) {
            $_SESSION['partenaire'] = [
                'id' => $partenaire['id'],
                'username' => $partenaire['username'],
                'email' => $partenaire['email'],
                'nom' => $partenaire['nom'],
                'description' => $partenaire['description'],
                'photo' => $partenaire['photo'],
                'logo' => $partenaire['logo'],
                'ville' => $partenaire['ville'],
                'categorie' => $partenaire['categorie'],
                'telNumber' => $partenaire['telNumber'],
                'website' => $partenaire['website'],
                'contactmail' => $partenaire['contactmail']


            ];
            header("Location: index.php?router=Page%20d'accueil");
        }else{
            return "Mot de passe incorrect";
        }
            
        }
        
        else {
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
            header('Content-Type: application/json');
            echo json_encode($user);
            
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
        $offres = $r->getOffres($_POST['id']);
        header('Content-Type: application/json');
        echo json_encode($offres);
    }

    public function getRemisesByCarte($id) {
        $r = new userModel();
        $offres= $r->getOffresByCarteId($id);
        header('Content-Type: application/json');
        echo json_encode($offres);
    }
    public function verifyQRCode() {
        $ss=new partenaireModel();
        $r = new userModel();
        if (!isset($_POST['qr_code'])) {
            $this->sendJsonResponse(false, 'Code QR manquant');
            return;
        }
        
        $qr_code = json_decode($_POST['qr_code'], true);
        
        if (!$qr_code) {
            $this->sendJsonResponse(false, 'Format de code QR invalide');
            return;
        }
        
        if (!isset($qr_code['id_membre']) || !isset($qr_code['id_type_carte'])) {
            $this->sendJsonResponse(false, 'Données QR Code manquantes');
            return;
        }
        
        // Get user data without echoing
        $user = $this->getUserData($qr_code['id_membre']);
        
        // Get remises without echoing
        $remises = $this->getRemisesData($qr_code['id_type_carte']);
        
        $response = [
            'success' => true,
            'user' => $user,
            'carte' => [
                'type' => $qr_code['id_type_carte'],
                'remises' => $remises
            ]
        ];
        $id_partenaire=$_SESSION['partenaire']['id'];
        $offres_id=$ss->getOffresByIdPart($id_partenaire);

        $r->addProfit($user['id'],$id_partenaire,$offres_id);
        
        $this->sendJsonResponse(true, '', $response);
    }


    public function getRemisesUser() {
        $ss=new partenaireModel();
        $r = new userModel();
        $identifier=$_POST['identifier'];
        
        // Get user data without echoing
        $user = $r->getUser($identifier);
        
        // Get remises without echoing
        if (!isset($user['carte'])) {
            $this->sendJsonResponse(false, 'Carte non trouvée pour cet utilisateur');
            return;
        }
        $carteId = $user['carte'];
        $typeCarte=$r->getTypeCarteByCarteId($carteId);
        $remises = $this->getRemisesData($typeCarte);

        
        $response = [
            'success' => true,
            'user' => $user,
            'carte' => [
                'type' => $typeCarte,
                'remises' => $remises
            ]
        ];
         $id_partenaire=$_SESSION['partenaire']['ide'];
         $offres_id=$ss->getOffresByIdPart($id_partenaire);

         $r->addProfit($user['id'],$id_partenaire,$offres_id);
        
        $this->sendJsonResponse(true, '', $response);
    }
    
    private function getUserData($id) {
        $r = new userModel();
        return $r->getUserById($id);
    }
    
    private function getRemisesData($id) {
        $r = new userModel();
        return $r->getOffresByCarteId($id);
    }
    
    private function sendJsonResponse($success, $message = '', $data = null) {
        header('Content-Type: application/json');
        $response = ['success' => $success];
        
        if (!empty($message)) {
            $response['message'] = $message;
        }
        
        if ($data !== null) {
            $response = array_merge($response, $data);
        }
        
        echo json_encode($response);
        exit;
    }
    public function getOffresProfite(){
        $id = $_SESSION['user']['id'] ?? $_SESSION['member']['id'];
        $r = new userModel();
        $offres = $r->getOffresProfite($id);
        header('Content-Type: application/json');
        echo json_encode($offres);
    }
    public function afficherPageHistoriqueOffresProfite() {
        $v = new historiqueOffresProfite();
        $v->afficher_page();
    }
}
?>
