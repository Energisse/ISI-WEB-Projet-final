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
        $this->post('pay1','/CB');
        $this->post('pay2','/Paypal/pay');
        $this->post('annuler','/CBPaypal/annuler');
        $this->get('pay3','/MoneyCheck');

    }

    public function index($data)
    {
        $this->sendView('viewBasket', ["basket" => $_SESSION["basket"]]);
    }

    public function buy($data)
    {
        if(!isset($_SESSION["User"])){
            $this->redirect("/user/User?goTo=/basket/buy");
            return;
        }

        //Si le panier est vide, on empeche le payement a moins de vouloir se faire livrer de l'air
        if( count($_SESSION["basket"]->getProducts()) == 0){
            $this->redirect("/basket");
            return;
        }
        
        $this->sendView('viewBasketBuy', ["deliveryAddresses"=>DeliveryAddress::getAllDeliveryAddressByUserId($_SESSION["User"]->getId())]);
    }

    public function bought($data){
        
    
        if(!isset($_SESSION["User"])){
            $this->redirect("/user/User?goTo=/basket/buy");
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

        switch($_POST["payement"]){                   //selon le mode de payement on renvoie vers une page dédiée si c'est par CB,Paypal ou chèque
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

        //Addresse inexistante
        $deliveryAddress = DeliveryAddress::getDeliveryAddressByIdAndUserId($_POST["address"], $_SESSION["User"]->getId());
        if($deliveryAddress == null){
            $this->redirect("/basket/buy");
            return;
        }

        echo $_POST["payement"];

        //Order::getOrderById(Order::createNewOrder($_SESSION["User"]->getId(),$deliveryAddress->getId() , $_SESSION["basket"]->getProducts(),$_POST["payement"]));
        $_SESSION["basket"]->clear();
    }

    public function clear($data)
    {
        $_SESSION["basket"]->clear();
        $this->sendView('viewBasket', ["basket" => $_SESSION["basket"]]);
    }

    public function pay1($data)
    {
        $this->sendView('CB');
    }

    public function pay2($data)
    {
        $this->sendView('Paypal');
    }

    public function pay3($data)
    {
        $this->sendView('MoneyCheck');
    }

    public function annuler($data)
    {
        $this->sendView('viewBasketBuy');
    }

   
}