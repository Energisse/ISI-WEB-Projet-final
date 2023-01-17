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

        //Login
        $this->get('loginForm', '/login');
        $this->post('login', '/login');
        //Signin
        $this->get('signinForm', '/signin');
        $this->post('signin', '/signin');
        //logout
        $this->get('logout', '/logout');
        //All order from user
        $this->get('orders', '/orders');
        //All addresses from user
        $this->get('addresses', '/addresses');
        //TODO: to move in order
        $this->get('order', '/order/:id');
        $this->get('getFacture', '/order/facture/:id');
    }

    /**
     * Login form 
     * path = (get) /user/login
     * @param mixed $data
     * @return void
     */
    public function loginForm($data)
    {
        //check if user is already connected
        if (isset($_SESSION["User"])) {
            $this->redirect("/categorie");
            return;
        }

        //send view
        $this->sendView("viewLogin", [
            "goTo" => isset($_GET["goTo"]) ? $_GET["goTo"] : null,
            "error" => isset($data["prevRequestData"]["error"]) ? $data["prevRequestData"]["error"] : null
        ]);
    }

    /**
     * Process login data
     * path = (post) /user/login
     * @param mixed $data
     * @return void
     */
    public function login($data)
    {
        //check if user is already connected
        if (isset($_SESSION["User"])) {
            $this->redirect("/categorie");
            return;
        }

        if (isset($_POST["username"]) && $_POST["password"]) {
            //get user if exist
            $User = User::getUserByUsernameAndPassword($_POST["username"], $_POST["password"]);
            if ($User != null) {
                $_SESSION["User"] = $User;
                $order = Order::getOrderBySessionId(session_id());
                $order->setUserId($_SESSION["User"]->getId());
                $order->save();
                //Go to page if aked 
                if (isset($_GET["goTo"]))  $this->redirect($_GET["goTo"]);
                else $this->redirect("/categorie");
                return;
            }
        }

        //reirect to form
        $this->redirect("/user/login" . isset($_GET["goTo"]) ? "?goTo=" . $_GET["goTo"] : null, ["error" => true]);
    }

    /**
     * Signin form 
     * path = (get) /user/signin
     * @param mixed $data
     * @return void
     */
    public function signinForm()
    {
        //check if user is already connected
        if (isset($_SESSION["User"])) {
            $this->redirect("/categorie");
            return;
        }
        $this->sendView("viewSignin");
    }

    /**
     * Process signin data 
     * path = (post) /user/signin
     * @param mixed $data
     * @return void
     */
    public function signin()
    {
        //check if user is already connected
        if (isset($_SESSION["User"])) {
            $this->redirect("/categorie");
            return;
        }

        if (isset($_POST["username"]) && $_POST["password"]) {
            $_SESSION["User"] = User::signin($_POST["username"], $_POST["password"]);
            $order = Order::getOrderBySessionId(session_id());
            $order->setUserId($_SESSION["User"]->getId());
            $order->save();
            $this->redirect("/categorie");
            return;
        }

        $this->redirect("/user/signin", ["error" => true]);
    }


    /**
     * logout
     * path (get) /user/logout
     * @param mixed $data
     * @return void
     */
    public function logout($data)
    {
        session_destroy();
        $this->redirect("/user/login");
    }

    /**
     * Show all addresses from user
     * path (get) /user/addresses
     * @param mixed $data
     * @return void
     */
    public function addresses($data)
    {
        //check connected
        if (!isset($_SESSION["User"])) {
            $this->redirect("/user/login?goTo=/user/addresses");
            return;
        }

        $deliveryAddresses = DeliveryAddress::getAllDeliveryAddressByUserId($_SESSION["User"]->getId());
        $this->sendView("viewAddresses", ["deliveryAddresses" => $deliveryAddresses]);
    }

    /**
     * show all orders
     * path (get) /user/orders
     * @param mixed $data
     * @return void
     */
    public function orders($data)
    {
        //check connected
        if (!isset($_SESSION["User"])) {
            $this->redirect("/user/login?goTo=/user/orders");
            return;
        }

        $orders = Order::getOrdersByUserId($_SESSION["User"]->getId());

        $this->sendView("viewOrders", ["orders" => $orders]);
    }

    public function order($data)
    {
        //SI non connecté 
        if (!isset($_SESSION["User"])) {
            $this->redirect("/user/login");
            return;
        }

        $order = Order::getOrderByOrderIdAndUserId($data["params"]["id"], $_SESSION["User"]->getId());

        $this->sendView("viewOrder", ["order" => $order]);
    }

    public function getFacture($data)
    {
        //SI non connecté 
        if (!isset($_SESSION["User"])) {
            $this->redirect("/user/login");
            return;
        }

        $order = Order::getOrderByOrderIdAndUserId($data["params"]["id"], $_SESSION["User"]->getId());
        if (!$order) {
            $this->redirect("/user/orders");
            return;
        }
        $id = $order->getId();
        $file = "assets/factures/$id.pdf";
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));
        readfile($file);
    }
}
