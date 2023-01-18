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
        $this->post('pay', '/pay');
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

        $order->setAddressId($deliveryAddress->getID());
        $order = $order->save();
        switch ($_POST["payement"]) {                   //selon le mode de payement on renvoie vers une pagge dédiée si c'est par CB,Paypal ou chèque
            case "creditCard":
                $this->sendView("viewCrediCardBuy", ["order" => $order, "deliveryAddress" => $deliveryAddress]);
                break;
            case "paypal":
                $this->sendView("viewPaypal", ["order" => $order, "deliveryAddress" => $deliveryAddress]);
                break;
            case "moneyCheck":
                $this->sendView("viewMoneyCheck", ["order" => $order, "deliveryAddress" => $deliveryAddress]);
                break;
            default:
                $this->redirect("/basket");
        }
    }

    public function clear($data)
    {
        Order::getOrderBySessionId(session_id())->clear();
        $this->redirect('/basket');
    }

    public function pay($data)
    {
        if (!isset($_POST["payment_type"])) {
            $this->redirect("/basket");
            return;
        }

        switch ($_POST["payment_type"]) {
            case "creditCard":
                //TODO: ADD verification 
                break;
            case "paypal":
                //TODO: ADD verification 
                break;
            case "moneyCheck":
                //TODO: ADD verification 
                break;
            default:
                $this->redirect("/basket");
                return;
        }

        //TODO:verifier avant que tout soit bien saisie ( dans ce cas la que l'address car on s'en fout un peu du payement)
        $order = Order::getOrderBySessionId(session_id());

        if ($order->getStatus()->getStatusCode() != OrderStatusCode::$InPayment) {
            $this->redirect("/basket", ["productAdded" => true]);
            return;
        }


        //remove product quantity
        foreach ($order->getOrderItems() as $item) {
            $item->getProduct()->setQuantity($item->getProduct()->getQuantity() - $item->getQuantity());
            $item->getProduct()->save();
        }

        $order->setUserId($_SESSION["User"]->getId());
        $order->removeSessionId();
        $order->setPaymentType($_POST["payment_type"]);
        $order->setStatus(OrderStatusCode::$WaintingPayment);
        if ($_POST["payment_type"] != "moneyCheck") {
            $order->setStatus(OrderStatusCode::$Paid);
        }
        $order->save();
        Facture::generateFacture($order);
        Order::createNewOrder(session_id(), $_SESSION["User"]->getId());
        $this->sendView("viewSucces", ["orderId" => $order->getId()]);
    }
}
