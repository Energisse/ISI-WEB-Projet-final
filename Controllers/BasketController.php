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
        $this->post('buy', '/');
        $this->get('clear', '/clear');
        $this->post('creditCard', '/creditCard');
        $this->post('paypal', '/paypal');
        $this->post('moneyCheck', '/moneyCheck');
    }

    public function index($data)
    {
        if (!isset($_SESSION["User"])) {
            $this->redirect("/user/login?goTo=/basket/");
            return;
        }

        $order = Order::getOrderBySessionId(session_id());

        $order = $order->setStatus(OrderStatusCode::$InPayment);
        $this->sendView('viewBasketBuy', [
            "deliveryAddresses" => DeliveryAddress::getAllDeliveryAddressByUserId($_SESSION["User"]->getId()),
            "order" => $order,
            "productAdded" => isset($data["prevRequestData"]["productAdded"]) ? $data["prevRequestData"]["productAdded"] : false,
        ]);
    }

    public function buy($data)
    {

        if (!isset($_SESSION["User"])) {
            $this->redirect("/user/login?goTo=/basket/");
            return;
        }

        $order = Order::getOrderBySessionId(session_id());

        // //Si le panier est vide, on empeche le payement a moins de vouloir se faire livrer de l'air
        if ($order->getQuantity() == 0) {
            $this->redirect("/basket");
            return;
        }

        if ($order->getStatus()->getStatusCode() != OrderStatusCode::$InPayment) {
            $this->redirect("/basket", ["productAdded" => true]);
            return;
        }

        if (!isset($_POST["address"]) || !isset($_POST["payement"])) {
            $this->redirect("/basket");
            return;
        }

        //Addresse inexistante
        $deliveryAddress = DeliveryAddress::getDeliveryAddressByIdAndUserId($_POST["address"], $_SESSION["User"]->getId());
        if ($deliveryAddress == null) {
            $this->redirect("/basket");
            return;
        }

        $order = $order->setAddressId($deliveryAddress->getID());

        switch ($_POST["payement"]) {                   //selon le mode de payement on renvoie vers une pagge dédiée si c'est par CB,Paypal ou chèque
            case "creditCard":
                $this->sendView("viewCrediCardBuy", ["order" => $order]);
                break;
            case "paypal":
                $this->sendView("viewPaypal", ["order" => $order]);
                break;
            case "moneyCheck":
                $this->sendView("viewMoneyCheck", ["order" => $order]);
                break;
            default:
                $this->redirect("/basket/buy");
        }
    }

    public function clear($data)
    {
        Order::getOrderBySessionId(session_id())->clear();
        $this->redirect('/basket');
    }

    public function creditCard($data)
    {
        //TODO:verifier avant que tout soit bien saisie ( dans ce cas la que l'address car on s'en fout un peu du payement)
        //TODO: decompter le stock
        $order = Order::getOrderBySessionId(session_id());
        $order->setUserId($_SESSION["User"]->getId());
        Order::createNewOrder(session_id());
        $order->removeSessionId();
        $order->setStatus(OrderStatusCode::$WaintingPayment);
        $order->setStatus(OrderStatusCode::$Paid);
        $this->sendView("viewSucces");
    }

    public function paypal($data)
    {
        //TODO:verifier avant que tout soit bien saisie ( dans ce cas la que l'address car on s'en fout un peu du payement)
        //TODO: decompter le stock
        $order = Order::getOrderBySessionId(session_id());
        $order->setUserId($_SESSION["User"]->getId());
        Order::createNewOrder(session_id());
        $order->removeSessionId();
        $order->setStatus(OrderStatusCode::$WaintingPayment);
        $order->setStatus(OrderStatusCode::$Paid);
        $this->sendView("viewSucces");
    }

    public function moneyCheck($data)
    {
        //TODO:verifier avant que tout soit bien saisie ( dans ce cas la que l'address car on s'en fout un peu du payement)
        //TODO: decompter le stock
        $order = Order::getOrderBySessionId(session_id());
        $order->setUserId($_SESSION["User"]->getId());
        Order::createNewOrder(session_id());
        $order->removeSessionId();
        $order->setStatus(OrderStatusCode::$WaintingPayment);
        $this->sendView("viewSucces");
    }
}
