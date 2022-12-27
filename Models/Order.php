<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';
require_once 'Models/OrderItems.php';

class Order extends Modele
{
    private $id;
    private $user_id;
    private $delivery_add_id;
    private $payment_type;
    private array|null $status;
    private array|null $orderItems;

    function __construct($data)
    {
        $this->id = $data["id"];
        $this->user_id = $data["user_id"];
        $this->delivery_add_id = $data["delivery_add_id"];
        $this->payment_type = $data["payment_type"];
        $this->status = null;
        $this->orderItems = null;
    }

    public static function getAllOrdersByUserId($user_id):Array{
        $sql = 'select * from orders where user_id=:user_id';
        $result = Order::executerRequete($sql, [":user_id" => $user_id]);
        $listeOrders = [];
        foreach ($result->fetchAll() as $order) {
            array_push($listeOrders,new Order($order));
        }
        return $listeOrders;
    }

    public function getOrderItems():array{
        if($this->orderItems == null){
            $this->orderItems = OrderItem::getAllOrderItemByOrderId($this->id);
        }
        return $this->orderItems;
    }

    public static function createNewOrder($userId,$deliveryAddressID,$ordersItems){
        $deliveryAddress = DeliveryAddress::getDeliveryAddressByIdAndUserId($deliveryAddressID, $userId);
        if($deliveryAddress==null)throw new Exception('Addresse de livraison inconnue!');
        $sql = 'insert into orders(user_id,delivery_add_id) values(:user_id,:delivery_add_id);';
        Order::executerRequete($sql, [":user_id" => $userId,":delivery_add_id"=>$deliveryAddressID]);
        OrderItem::createOrderItems(Order::lastInsertId(),$ordersItems);
    }

   
    
}

