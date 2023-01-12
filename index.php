<?php
require_once 'utils/Basket.php';
require_once 'utils/Cached.php';
require_once 'Models/User.php';
require_once 'Models/Order.php';
session_start();

require_once 'Controllers/Routeur.php';
require_once 'utils/Request.php';

//use to store data while using prg (Post-Redirect-Get)
if (!isset($_SESSION["cached"])) {
    $_SESSION["cached"] = new Cached();
} else {
    $_SESSION["cached"]->checkExpired();
}

if (!isset($_SESSION["basket"])) {
    $_SESSION["basket"] = new Basket();
}

$routeur = new Routeur();
$routeur->routerRequete(new Request($_GET['controller'], $_GET['action'], $_SERVER['REQUEST_METHOD'], $_POST));
// Modele::showRequests();
// var_dump($_SESSION["cached"]->list);
