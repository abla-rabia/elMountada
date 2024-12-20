<?php
require_once("Controller/loginController.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rts=new loginController();
    $rts->login();
}
?>