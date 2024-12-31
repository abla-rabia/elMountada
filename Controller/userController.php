<?php
require_once(ROOT . '/View/loginView.php');
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
                $_SESSION['userName']=$userName;
                $_SESSION['password']=$password;
                echo "Authentification effectuée avec succès";
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

            if(!($r->problemInscription($credentials))){
                $r->inscriptionSimple($credentials);
                $this->uploadPhoto();
                return 1;//pour indiquer que l'instruction a ete effectué avec succés
            }
            else{
                return 0; //cas d'erreur username ou email existent deja
            }
        }

    //fonction pour gerer les photos envoyées
    private function uploadPhoto($name) {
        //photo d'indetité
        if (isset($_FILES[$name]) && $_FILES[$name]['error'] === UPLOAD_ERR_OK) {
            // Déplacer la photo vers un dossier sur le serveur
            $targetDir = 'uploads';
            $targetFile = $targetDir . basename($_FILES[$name]['name']);
            move_uploaded_file($_FILES[$name]['tmp_name'], $targetFile);
            return $targetFile;  // Retourner le chemin de la photo
        }
        return null; //cas ou la photo n'a pas ete téléchargée
    }
}
?>