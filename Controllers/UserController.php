<?php
require_once 'Controllers/Controller.php';
require_once 'Views/View.php';
require_once 'Models/Categorie.php';
require_once 'Models/User.php';

class UserController extends Controller
{
    function __construct()
    {
        parent::__construct('user');

        $this->get('UserForm', '/login');
        $this->post('User', '/login');
        $this->get('logout', '/logout');
        $this->get('orders', '/orders');
        $this->get('order', '/order/:id');
        $this->get('addresses', '/addresses');
        $this->get('address', '/address/:id');
        $this->get('newAddress', '/address');
        $this->post('updateAddress', '/address/:id');
        $this->post('createAddress', '/address');
        $this->post('createaccount','/CreateAccount');
        $this->get('signin','/CreateAccount');


    }

    public function UserForm($data)
    {
        if (isset($_SESSION["User"])) {
            $this->redirect("/categorie");
            return;
        }
        $this->sendView("viewLogin", ["goTo" => isset($_GET["goTo"]) ? $_GET["goTo"] : null]);
    }

    public function logout($data)
    {
        session_destroy();
        $this->redirect("/user/User");
    }

    public function User($data)
    {
        if (isset($_SESSION["User"])) {
            $this->redirect("/categorie");
            return;
        }

        if (isset($_POST["username"]) && $_POST["password"]) {
            $User = User::getUserByUsernameAndPassword($_POST["username"], $_POST["password"]);
            if ($User != null) {
                $_SESSION["User"] = $User;
                //Si la connexion a été demandé par une autre page on y repars 
                if (isset($_GET["goTo"]))  $this->redirect($_GET["goTo"]);
                else $this->redirect("/categorie");
                return;
            }
        }
        $this->sendView("viewLogin", ["error" => true, "username" => $_POST["username"], "goTo" => isset($_GET["goTo"]) ? $_GET["goTo"] : null]);
    }

    public function addresses($data)
    {
        $deliveryAddresses = DeliveryAddress::getAllDeliveryAddressByUserId($_SESSION["User"]->getId());
        $this->sendView("viewAddresses", ["deliveryAddresses" => $deliveryAddresses]);
    }

    public function orders($data)
    {
        //SI non connecté 
        if (!isset($_SESSION["User"])) {
            $this->redirect("/user/User");
            return;
        }

        $orders = Order::getOrdersByUserId($_SESSION["User"]->getId());

        $this->sendView("viewOrders", ["orders" => $orders]);
    }

    public function order($data)
    {
        //SI non connecté 
        if (!isset($_SESSION["User"])) {
            $this->redirect("/user/User");
            return;
        }

        $order = Order::getOrderByOrderIdAndUserId($data["params"]["id"], $_SESSION["User"]->getId());

        $this->sendView("viewOrder", ["order" => $order]);
    }

    public function signin(){
        $this->sendView("viewCreateAccount");
    }
    public function createaccount(){
        User::signin($_POST["username"],$_POST["password"]);

        
    }
    
}
