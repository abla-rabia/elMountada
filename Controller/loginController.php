<?php
require_once("Model\loginModel.php");
require_once("View\loginView.php");

class loginController{
    public function login(){
        $userName=$_POST['userName'];
        $password=$_POST['password'];
        $mdl=new loginModel();
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
    public function afficherPage(){
        $v=new loginView();
        $v->afficher_page();
    }
}
?>