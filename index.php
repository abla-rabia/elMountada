<?php
require_once("Controller/loginController.php");
require_once("Controller/homeController.php");
$rts=new homeController();
$rts->afficherPage();
?>