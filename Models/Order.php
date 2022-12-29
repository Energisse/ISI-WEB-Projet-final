<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';
require_once 'Models/OrderItems.php';
require_once 'Models/OrderStatus.php';

class Order extends Modele
{
    private int $id;
    private int $user_id;
    private int $delivery_add_id;
    private string $payment_type;
    private OrderStatus|null $status;
    private array|null $statusHistory;
    private array|null $orderItems;

    function __construct($data)
    {
        $this->id = $data["id"];
        $this->user_id = $data["user_id"];
        $this->delivery_add_id = $data["delivery_add_id"];
        $this->payment_type = $data["payment_type"];
        $this->status = null;
        $this->statusHistory = null;
        $this->orderItems = null;
    }

    public static function getOrderByOrderIdAndUserId($order_id, $user_id): ?Order
    {
        $sql = 'SELECT * FROM `orders` where id=:order_id and user_id=:user_id ';
        return Order::queryOrder($sql, [":order_id" => $order_id, ":user_id" => $user_id]);
    }


    public static function getOrderById($order_id): ?Order
    {
        $sql = 'SELECT * FROM `orders` where id= :order_id ';
        return Order::queryOrder($sql, [":order_id" => $order_id]);
    }

    public static function getALlOrderNotFinished(): array
    {
        $sql = 'select * from orders where id not in (SELECT order_id from orderstatus where status = 2)  order by id desc';
        return Order::queryOrders($sql);
    }

    public static function getOrdersByUserId($user_id): array
    {
        $sql = 'SELECT * FROM `orders` where user_id=:user_id order by id desc';
        return Order::queryOrders($sql, [":user_id" => $user_id]);
    }

    private static function queryOrder($sql,$params = null)
    {
        $result = Order::executerRequete($sql, $params)->fetch();
        if ($result == null)
            return null;

        $order = new Order($result);

        $orderstatus = OrderStatus::getAllStatusByOrdersId([$order->getId()]);

        foreach ($orderstatus as $status) {
            $order->statusHistory[] = $status;
        }

        $order->status = $orderstatus[count($orderstatus) - 1];

        $pruducts = OrderItem::getAllOrderItemAndProductByOrdersId([$order->getId()]);

        foreach ($pruducts as $pruduct) {
            $order->orderItems[] = $pruduct;
        }
        return $order;
    }

    private static function queryOrders($sql,$params = null)
    {

        $result = Order::executerRequete($sql, $params);
        $orders = [];

        foreach ($result->fetchAll() as $order) {
            $orders[] = new Order($order);
        }

        if (count($orders) == 0)
            return [];
            
        $ordersId = [];
        foreach ($orders as $order) {
            $ordersId[] = $order->getId();
        }
        $orderstatus = OrderStatus::getAllStatusByOrdersId($ordersId);
        //merge les status (triée par id puis par date) avec les commandes (trié par id) 
        $orderIndex = 0;
        $statusIndex = 0;
        while ($orderIndex < count($orders)) {
            $orders[$orderIndex]->statusHistory = [];
            while ($statusIndex < count($orderstatus) && $orderstatus[$statusIndex]->getOrderId() == $orders[$orderIndex]->getId()) {
                $orders[$orderIndex]->status = $orderstatus[$statusIndex];
                $orders[$orderIndex]->statusHistory[] = $orderstatus[$statusIndex];
                $statusIndex++;
            }
            $orderIndex++;
        }

        $pruducts = OrderItem::getAllOrderItemAndProductByOrdersId($ordersId);


        $orderIndex = 0;
        $productsIndex = 0;
        while ($orderIndex < count($orders)) {
            while ($productsIndex < count($pruducts) && $pruducts[$productsIndex]->getOrderId() == $orders[$orderIndex]->getId()) {
                $orders[$orderIndex]->orderItems[] = $pruducts[$productsIndex];
                $productsIndex++;
            }
            $orderIndex++;
        }
        return $orders;
    }


  

    public static function createNewOrder($userId, $deliveryAddressID, $ordersItems)
    {
        $sql = 'insert into orders(user_id,delivery_add_id) values(:user_id,:delivery_add_id);';
        Order::executerRequete($sql, [":user_id" => $userId, ":delivery_add_id" => $deliveryAddressID]);
        $id = Order::lastInsertId();
        OrderStatus::createNewStatus($id);
        OrderItem::createOrderItems($id, $ordersItems);
    }




    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUser_id(): int
    {
        return $this->user_id;
    }

    /**
     * @return int
     */
    public function getDelivery_add_id(): int
    {
        return $this->delivery_add_id;
    }

    /**
     * @return OrderStatus
     */
    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    /**
     * @return array|null
     */
    public function getOrderItems(): array|null
    {
        if ($this->orderItems == null) {
            $this->orderItems = OrderItem::getAllOrderItemByOrderId($this->id);
        }
        return $this->orderItems;
    }

    /**
     * @return array|null
     */
    public function getStatusHistory(): array|null
    {
        if ($this->statusHistory == null) {
            $this->statusHistory = OrderStatus::getAllStatusByOrderId($this->id);
        }
        return $this->statusHistory;
    }

    /**
     * @param int $status 
     * @return self
     */
    public function setStatus(int $status): self
    {
        OrderStatus::changeStatus($this->getId(), $status);
        $newOrder = Order::getOrderById($this->getId());
        $this->status = $newOrder->status;
        $this->statusHistory = $newOrder->statusHistory;
        return $this;
    }
}
