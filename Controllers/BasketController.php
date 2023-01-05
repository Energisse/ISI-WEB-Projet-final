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
        $this->post('bought', '/buy');
        $this->get('clear', '/clear');
        $this->post('pay','/CB');
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

        //Si le panier est vide, on empeche le payement a moins de vouloir se faire livrer de l'air
        if( count($_SESSION["basket"]->getProducts()) == 0){
            $this->redirect("/basket");
            return;
        }
        
        $this->sendView('viewBasketBuy', ["deliveryAddresses"=>DeliveryAddress::getAllDeliveryAddressByUserId($_SESSION["login"]->getId())]);
    }

    public function bought($data){
        if(!isset($_SESSION["login"])){
            $this->redirect("/user/login?goTo=/basket/buy");
            return;
        }

        //Si le panier est vide, on empeche le payement a moins de vouloir se faire livrer de l'air
        if( count($_SESSION["basket"]->getProducts()) == 0){
            $this->redirect("/basket");
            return;
        }

        if(!isset($_POST["address"]) || !isset($_POST["payement"])){
            $this->redirect("/basket/buy");
            return; 
        }

        switch("payement"){                   //selon le mode de payement on renvoie vers une pagge dédiée si c'est par CB,Paypal ou chèque
            case "creditCard" :
                $this->redirect("/basket/CB");
                break;
            case "paypal":
                $this->redirect("/basket/Paypal");
                break;
            case "moneyCheck":
                $this->redirect("/basket/MoneyCheck");
                break;
            default:
                $this->redirect("/basket/buy");
        }

        /*//Addresse inexistante
        $deliveryAddress = DeliveryAddress::getDeliveryAddressByIdAndUserId($_POST["address"], $_SESSION["login"]->getId());
        if($deliveryAddress == null){
            $this->redirect("/basket/buy");
            return;
        }

        echo $_POST["payement"];

        Order::createNewOrder($_SESSION["login"]->getId(),$deliveryAddress->getId() , $_SESSION["basket"]->getProducts(),$_POST["payement"]);
        $_SESSION["basket"]->clear();*/
    }

    public function clear($data)
    {
        $_SESSION["basket"]->clear();
        $this->sendView('viewBasket', ["basket" => $_SESSION["basket"]]);
    }

    public function payCB($data)
    {
        $this->sendView('viewaccept');
    }
}