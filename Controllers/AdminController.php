<?php
require_once 'Controllers/Controller.php';
require_once 'Views/View.php';
require_once 'Models/Categorie.php';
require_once 'Models/DeliveryAddress.php';

class AdminController extends Controller
{
    function __construct()
    {
        parent::__construct('admin');
        //est connecté
        if (isset($_SESSION["User"])) {
            //est admin
            if ($_SESSION["User"]->isAdmin()) {
                $this->get('index', '/');
                $this->get('order', '/order/:id');
                $this->post('confirmPayement', '/order/payement/:id');
                $this->post('confirmShipment', '/order/shipment/:id');
                $this->post('confirmReception', '/order/reception/:id');
            }
            //rien car non admin
        }
        //demande de connection
        else {
            $this->get('redirection', '/(.*)');
        }
    }

    public function index($data)
    {
        $orders = Order::getAllOrderNotDelivered();
        $this->sendView("viewAdmin", ["orders" => $orders]);
    }

    public function order($data)
    {
        $order = Order::getOrderById($data["params"]["id"]);
        $this->sendView("viewOrder", ["order" => $order]);
    }

    public function redirection()
    {
        $this->redirect("/user/login");
    }

    public function confirmPayement($data)
    {
        $this->confirm($data["params"]["id"], OrderStatusCode::$Paid);
    }
    public function confirmShipment($data)
    {
        $this->confirm($data["params"]["id"],  OrderStatusCode::$InDelivery);
    }
    public function confirmReception($data)
    {
        $this->confirm($data["params"]["id"], OrderStatusCode::$Delivered);
    }

    private function confirm($id, $status)
    {
        $order = Order::getOrderById($id);
        if ($order == null) {
            $this->redirect("/admin");
            return;
        }
        if ($order->getStatus()->getStatusCode() != $status - 1) {
            $this->redirect("/admin");
            return;
        }
        $order = $order->setStatus($status);
        $this->redirect("/admin/order" . "/" . $id);
    }
}
