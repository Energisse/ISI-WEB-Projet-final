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

        $this->get('UserForm', '/User');
        $this->post('User', '/User');
        $this->get('logout', '/logout');
        $this->get('orders', '/orders');
        $this->get('order', '/order/:id');
        $this->get('addresses', '/addresses');
        $this->get('createOrUpadteAddress', '/address/:id');
        $this->get('createOrUpadteAddress', '/address');
        $this->post('onCreateOrUpadteAddress', '/address/:id');
        $this->post('onCreateOrUpadteAddress', '/address');
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

    public function createOrUpadteAddress($data)
    {
        $deliveryAddresses = null;
        if (isset($data["params"]["id"])) {
            $deliveryAddresses = DeliveryAddress::getDeliveryAddressByIdAndUserId($data["params"]["id"], $_SESSION["User"]->getId());
        }
        $this->sendView("viewAddress", ["deliveryAddresses" => $deliveryAddresses, "error" => isset($data["error"]) ? $data["error"] : null]);
    }

    public function onCreateOrUpadteAddress($data)
    {
        try {
            if (isset($data["params"]["id"])) {
                $address = DeliveryAddress::getDeliveryAddressByIdAndUserId($data["params"]["id"], $_SESSION["User"]->getId());
                if ($address == null) {
                    $this->redirect('/accueil');
                    return;
                }
                DeliveryAddress::updateDeliveryAddressByIdAndUserId($_POST, $data["params"]["id"], $_SESSION["User"]->getId());
                if (isset($_GET["goTo"]))  $this->redirect($_GET["goTo"]);
                else {
                }
                $this->redirect("/user/addresses");
            } else {
                DeliveryAddress::createDeliveryAddress($_POST, $_SESSION["User"]->getId());
            }
            $this->redirect("/user/addresses");
        } catch (FormException $error) {
            $data["error"] = $error;
            $this->createOrUpadteAddress($data);
        }
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
}
