<?php
session_start();
require_once 'Controllers/Routeur.php';
require_once 'utils/Request.php';
$routeur = new Routeur();
$routeur->routerRequete(new Request($_GET['controller'], $_GET['action'], $_SERVER['REQUEST_METHOD']));

?>