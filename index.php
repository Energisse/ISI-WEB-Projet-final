<?php
require_once 'utils/Basket.php';
session_start();
require_once 'Controllers/Routeur.php';
require_once 'utils/Request.php';

if (!isset($_SESSION["basket"])) {
    $_SESSION["basket"] = new Basket();
}

$routeur = new Routeur();
$routeur->routerRequete(new Request($_GET['controller'], $_GET['action'], $_SERVER['REQUEST_METHOD']));

?>
