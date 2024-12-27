<?php
require_once("Controller\loginController.php");
class loginView{
    public function entetePage(){
        ?>
        <head>
            <title>El Mountada</title>
            <link rel="stylesheet" href="View/css/loginStyle.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        </head>
        <?php   
    }
    public function logo(){
        ?>
        <a href="index.php?router=Page%20d'accueil">
        <img src="View/assets/logo.png" alt="logo here" width="120px"></a>
        <?php
    }
    public function texte(){
        ?>
        
        <h2>Connexion</h2>
        <h4>Bienvenu !</h4>
        <?php
    }

    //fonction de l'input (text input)
    public function input($textLable,$name,$type){
        ?>
       <input type="<?= $type ?>" name="<?= $name ?>" placeholder="<?= $textLable ?>" id="<?= $name ?>">
        <?php
    }
    public function inputPassword(){
        ?>
        <div class="passwordInput">
        <?php
        $this->input("Mot de passe","password","password");
        ?>
        <a href="">Mot de passe oublié ?</a>
        </div>
        <?php
    }
    public function bouttonSubmit(){
        ?>
        <input type="submit" value="Se Connecter" >
        <?php
    }
    public function formulaireLogin(){
        ?>
        <form action="loginRouter.php" method="post">
        <?php
            $this->input("Email ou nom utilisateur","userName","text");
            $this->inputPassword();
            
            $this->bouttonSubmit();
        ?>
        </form>
        <?php
    }
    public function loginBox(){
        $this->texte();
        $this->formulaireLogin();
    }



public function afficher_page(){
    ?>
    <html >
        
        <?php
        $this->entetePage()
        ?>
        <body>
        <div class="left">
        <?php
            $this->logo();   
            ?>

            <div class="content">
            <div>
            <?php
            $this->loginBox()    
            
            ?>
            </div>
            </div>
            </div>
            <div class="right">

            </div>
        </body>

    </html>
    <?php

}
}
?>
