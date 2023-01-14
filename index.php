<?php
require_once 'utils/Basket.php';
require_once 'utils/Cached.php';
require_once 'Models/User.php';
require_once 'Models/Order.php';
require_once 'Models/Session.php';

$handler = new SysSession();
session_set_save_handler($handler, true);
session_start();

require_once 'Controllers/Routeur.php';
require_once 'utils/Request.php';

//use to store data while using prg (Post-Redirect-Get)
if (!isset($_SESSION["cached"])) {
    $_SESSION["cached"] = new Cached();
} else {
    $_SESSION["cached"]->checkExpired();
}
if (!isset($_SESSION["basketOrderId"])) {
    $order = Order::createNewOrder();
    $_SESSION["basketOrderId"] = $order->getId();
}



$routeur = new Routeur();
$routeur->routerRequete(new Request($_GET['controller'], $_GET['action'], $_SERVER['REQUEST_METHOD'], $_POST));
// Modele::showRequests();


// session_destroy();
