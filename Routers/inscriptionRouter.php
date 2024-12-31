<?php
if (!defined('ROOT')) {
    define('ROOT', dirname(__DIR__)); // Définit ROOT si ce n'est pas déjà fait
}
require_once(ROOT . '/Controller/userController.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rts=new userController();
    $result=$rts->inscriptionSimple();
    echo $result;
}
?>