<?php

require_once(ROOT . '/View/loginView.php');
require_once(ROOT . '/View/FavorisView.php');
require_once(ROOT . '/Model/userModel.php');


class userController{
    public function login(){
        $userName=$_POST['userName'];
        $password=$_POST['password'];
        $mdl=new userModel();
        $user=$mdl->getUser($userName);
        if ($user){
            if ($mdl->checkPassword($userName,$password)){
                session_start();
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
                header("Location: index.php?router=Page%20d'accueil");
                print_r($_SESSION);
            }
            else{
                echo "Mot de passe incorrect";
            }
        }
        else{
            echo "Utilisateur inexistant";
        }
    }
    public function afficherPageLogin(){
        $v=new loginView();
        $v->afficher_page();
    }
    public function afficherPageFavoris(){
        $v=new FavorisView();
        $v->afficher_page();
    }
    public function inscriptionSimple(){
        $r= new userModel();
        $credentials=[
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

        // Check if any field is empty
        foreach ($credentials as $key => $value) {
            if (empty($value)) {
                return 3; 
            }
        }

        if(!($resul=$r->problemInscription($credentials))){
            $r->inscriptionSimple($credentials);
            return 1; // Pour indiquer que l'instruction a été effectuée avec succès
        }
        else{
            return $resul; // Cas d'erreur username ou email existent déjà
        }
    }

    public function inscriptionMembre(){
        $r= new userModel();
        $credentials=[
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

        // Check if any field is empty
        foreach ($credentials as $key => $value) {
            if (empty($value)) {
                return 3; 
            }
        }

        if(!($resul=$r->problemInscription($credentials))){
            $r->inscriptionMembre($credentials);
            return 1; // Pour indiquer que l'instruction a été effectuée avec succès
        }
        else{
            return $resul; // Cas d'erreur username ou email existent déjà
        }
    }

    //fonction pour gerer les photos envoyées using this till fixing routers issue
    private function uploadPhoto($name) {
        //photo d'indetité
        if (isset($_FILES[$name]) && $_FILES[$name]['error'] === UPLOAD_ERR_OK) {
            // Déplacer la photo vers un dossier sur le serveur
            $targetDir = '../uploads/';
            $targetFile = $targetDir . basename($_FILES[$name]['name']);
            move_uploaded_file($_FILES[$name]['tmp_name'], $targetFile);
            return $targetFile;  // Retourner le chemin de la photo
        }
        return null; //cas ou la photo n'a pas ete téléchargée
    }

    //fonction pour gerer les photos envoyées
    private function uploadPhoto2($name) {
        //photo d'indetité
        if (isset($_FILES[$name]) && $_FILES[$name]['error'] === UPLOAD_ERR_OK) {
            // Déplacer la photo vers un dossier sur le serveur
            $targetDir = 'uploads/';
            $targetFile = $targetDir . basename($_FILES[$name]['name']);
            move_uploaded_file($_FILES[$name]['tmp_name'], $targetFile);
            return $targetFile;  // Retourner le chemin de la photo
        }
        return null; //cas ou la photo n'a pas ete téléchargée
    }
    public function logout(){
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_unset(); // Supprime toutes les variables de session
            session_destroy(); // Détruit la session
        }
        header("Location: index.php?router=Page%20d'accueil");
        exit();
    }

    public function modifyPersoInfo(){
        
        $r= new userModel();
        $credentials=[
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
        $_SESSION['user']['nom']=$credentials['nom'];
        $_SESSION['user']['prenom']=$credentials['prenom'];
        $_SESSION['user']['telNumber']=$credentials['telNumber'];
        $_SESSION['user']['birthDate']=$credentials['birthDate'];
        $resu=$r->modifyPersoInfo($credentials);
        return $resu;

    }
    public function modifyCompteInfo(){
        
        $r= new userModel();
        $credentials=[
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'id' => $_POST['id']
        ];
        foreach ($credentials as $key => $value) {
            if (empty($value)) {
                return "Erreur : $key ne peut pas etre vide !"; 
            }
        }
        $_SESSION['user']['username']=$credentials['username'];
        $_SESSION['user']['email']=$credentials['email'];
        $r->modifyCompteInfo($credentials);
        return 1;

    }

    public function modifyPassword(){
        
        $r= new userModel();
        $credentials=[
            'password' => $_POST['password'],
            'id' => $_SESSION['id']
        ];
        if (empty($credentials['password'])) {
            return "Erreur : le mot de passe ne peut pas etre vide !"; 
        }
        $result=passwordRules($credentials['password']);
        if ($result!=1){
            return $result;
        }
        $r->modifyPassword($credentials);
        return 1;
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

    public function modifyPdp(){
        $r= new userModel();
        $credentials=[
            'photoProfile' =>  $this->uploadPhoto2('photoProfile'),
            'id' => $_SESSION['user']['id']
        ];
        foreach ($credentials as $key => $value) {
            if (empty($value)) {
                return "Erreur : $key ne peut pas etre vide !"; 
            }
        }
        $_SESSION['user']['photoProfile']=$credentials['photoProfile'];
        $r->modifyPdp($credentials);
        echo $credentials['photoProfile'];
        
    }

    
}
?>