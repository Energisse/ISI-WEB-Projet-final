<?php
require_once 'Controllers/Controller.php';
require_once 'Views/View.php';
require_once 'Models/Categorie.php';
require_once 'Models/DeliveryAddress.php';

class BasketController extends Controller
{
    function __construct()
    {
        parent::__construct('basket');
        $this->get('index', '/');
        $this->get('buy', '/buy');
        $this->get('clear', '/clear');
    }

    public function index($data)
    {
        $this->sendView('viewBasket', ["basket" => $_SESSION["basket"]]);
    }

    public function buy($data)
    {
        if(!isset($_SESSION["login"])){
            $this->redirect("/user/login?goTo=/basket/buy");
            return;
        }
        
        $this->sendView('viewBasketBuy', ["deliveryAddresses"=>DeliveryAddress::getAllDeliveryAddressByUserId($_SESSION["login"]->getId())]);

    }

    public function clear($data)
    {
        $_SESSION["basket"]->clear();
        $this->sendView('viewBasket', ["basket" => $_SESSION["basket"]]);
    }
}