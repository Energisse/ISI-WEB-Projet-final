<?php
require_once 'Controllers/Controller.php';
require_once 'Views/View.php';
require_once 'Models/Categorie.php';
require_once 'Models/Login.php';

class UserController extends Controller
{
    function __construct()
    {
        parent::__construct('user');
        
        $this->get('loginForm', '/login');
        $this->post('login', '/login');
        $this->get('logout', '/logout');
        $this->get('orders', '/orders');
        $this->get('order', '/order/:id');
        $this->get('addresses', '/addresses');
        $this->get('address', '/address/:id');
        $this->get('newAddress', '/address');
        $this->post('updateAddress', '/address/:id');
        $this->post('createAddress', '/address');

    }

    public function loginForm($data)
    {
        if (isset($_SESSION["login"])) {
            $this->redirect("/categorie");
            return;
        }
        $this->sendView("viewLogin",["goTo"=>isset($_GET["goTo"]) ? $_GET["goTo"] : null]);
    }

    public function logout($data)
    {
        session_destroy();
        $this->redirect("/user/login");
    }

    public function login($data)
    {
        if (isset($_SESSION["login"])) {
            $this->redirect("/categorie");
            return;
        }

        if (isset($_POST["username"]) && $_POST["password"]) {
            $login = Login::getLoginByUsernameAndPassword($_POST["username"], $_POST["password"]);
            if ($login != null) {
                $_SESSION["login"] = $login;
                //Si la connexion a été demandé par une autre page on y repars 
                if(isset($_GET["goTo"]))  $this->redirect($_GET["goTo"]);
                else $this->redirect("/categorie");
                return;
            }
        }
        $this->sendView("viewLogin", ["error" => true, "username" => $_POST["username"],"goTo"=>isset($_GET["goTo"]) ? $_GET["goTo"] : null]);
    }
    
    public function addresses($data){
        $addresses = DeliveryAddress::getAllDeliveryAddressByUserId($_SESSION["login"]->getId());
        // $this->sendView("viewAddresses", ["addresses" => $addresses]);
        var_dump($addresses);
    }

    public function address($data){
        $address = DeliveryAddress::getDeliveryAddressByIdAndUserId($data["params"]["id"],$_SESSION["login"]->getId());
        $this->sendView("viewEditAddress", ["address" => $address]);
    }

    public function updateAddress($data){
        $address = DeliveryAddress::getDeliveryAddressByIdAndUserId($data["params"]["id"],$_SESSION["login"]->getId());
        if($address == null){
            return;
        }
        DeliveryAddress::updateDeliveryAddressByIdAndUserId($_POST, $data["params"]["id"], $_SESSION["login"]->getId());
        $address = DeliveryAddress::getDeliveryAddressByIdAndUserId($data["params"]["id"],$_SESSION["login"]->getId());
        print $_GET["goTo"];
        if(isset($_GET["goTo"]))  $this->redirect($_GET["goTo"]);
        else $this->sendView("viewEditAddress", ["address" => $address]);
    }

    public function newAddress($data){
        $this->sendView("viewCreateAddress");
    }

    public function createAddress($data){
        DeliveryAddress::createDeliveryAddress($_POST, $_SESSION["login"]->getId());
        $this->redirect("/user/addresses");
    }

    

    public function orders($data){
        //SI non connecté 
        if (!isset($_SESSION["login"])) {
            $this->redirect("/user/login");
            return;
        }

        $orders = Order::getOrdersByUserId($_SESSION["login"]->getId());

        $this->sendView("viewOrders",["orders"=>$orders]);
    }

    public function order($data){
        //SI non connecté 
        if (!isset($_SESSION["login"])) {
            $this->redirect("/user/login");
            return;
        }

        $order = Order::getOrderByOrderIdAndUserId($data["params"]["id"],$_SESSION["login"]->getId());

        $this->sendView("viewOrder",["order"=>$order]);
    }
}