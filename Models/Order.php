<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';
require_once 'Models/OrderItems.php';
require_once 'Models/OrderStatus.php';


class Order extends Modele
{
    /**
     * Unique id
     * @var int
     */
    private int $id;

    /**
     * user_id
     * @var int|null 
     */
    private int|null  $user_id;

    /**
     * delivery_add_id
     * @var int|null 
     */
    private int|null $delivery_add_id;

    /**
     * payment_type
     * @var string|null 
     */
    private string|null $payment_type;

    /**
     * Total price
     * @var float|null 
     */
    private float|null  $price;

    /**
     * statusHistory
     * @var OrderStatus[]|null
     */
    private array|null $statusHistory;

    /**
     * orderItems
     * @var OrderItem[]|null
     */
    private array|null $orderItems;

    /**
     * quantity of item
     * @var int
     */
    private int|null $quantity;


    protected function __construct($data)
    {
        $this->id = $data["id"];
        $this->user_id = $data["user_id"];
        $this->delivery_add_id = $data["delivery_add_id"];
        $this->payment_type = $data["payment_type"];
        $this->price = $data["price"];
        $this->quantity = $data["quantity"];
        $this->statusHistory = [];
        $this->orderItems = [];
        if (array_key_exists("statusHistory", $data)) {
            foreach (json_decode($data["statusHistory"], true) as $status) {
                $this->statusHistory[$status["status"]] = &OrderStatus::create($status);
            }
        }
        if (array_key_exists("orderitems", $data) && $data["orderitems"]) {
            foreach (json_decode($data["orderitems"], true) as $address) {
                $this->orderItems[] = &OrderItem::create($address);
            }
        }
    }

    /**
     * Return a, order by his id and his user_id
     * @param int $order_id
     * @param int $user_id
     * @return Order|null
     */
    public static function getOrderByOrderIdAndUserId(int $order_id, int $user_id): ?Order
    {
        $sql = "SELECT * FROM orderWithData o where o.id = :order_id AND o.user_id = :user_id and status != 0;";
        return Order::fetch($sql, [":order_id" => $order_id, ":user_id" => $user_id]);
    }

    /**
     * return an order by id
     * @param int $order_id
     * @return Order|null
     */
    public static function getOrderById(int $order_id, bool $force = false): ?Order
    {
        if (!$force && self::getInstanceByID($order_id)) {
            return self::getInstanceByID($order_id);
        }

        $sql = "SELECT * FROM orderWithData o where o.id = :order_id";
        return Order::fetch($sql, [":order_id" => $order_id]);
    }



    /**
     * Return all order not delivered
     * @return Order[]
     */
    public static function getAllOrderNotDelivered(): array
    {
        $sql = "SELECT * FROM orderWithData o where status between :min_status_id and :max_status_id  order by id desc;";
        return Order::fetchAll($sql, [':min_status_id' => OrderStatusCode::$WaintingPayment, ':max_status_id' => OrderStatusCode::$Paid]);
    }

    /**
     * Return all order by user_id
     * @param int $user_id
     * @return Order[]
     */
    public static function getOrdersByUserId(int $user_id): array
    {
        $sql = "SELECT * FROM orderWithData o where o.user_id = :user_id and status != 0;";
        return Order::fetchAll($sql, [":user_id" => $user_id]);
    }



    /**
     * create a new Order
     * @param int $userId
     * @param int $deliveryAddressID
     * @param array $ordersItems
     * @param string $paymentType
     * @return Order
     */
    // public static function createNewOrder(int $userId, int $deliveryAddressID, array $ordersItems, string $paymentType)
    public static function createNewOrder(): Order
    {
        $sql = 'INSERT INTO orders(id) VALUES(null)';
        Order::executeRequest($sql)->fetch();
        $id = Order::lastInsertId();
        OrderStatus::createNewStatus($id);
        return Order::getOrderById($id);
    }

    public static function getProductQuantityByOrderId(int $id): ?int
    {
        $sql = 'SELECT SUM(quantity) FROM orderitems oi where oi.order_id=:id';
        $quantity = Order::executeRequest($sql, [":id" => $id])->fetch();
        return $quantity ? $quantity[0] : null;
    }


    public function setAddressId(int $delivery_add_id): Order
    {
        $sql = 'UPDATE orders set delivery_add_id=:delivery_add_id where id=:id';
        self::executeRequest($sql, [":delivery_add_id" => $delivery_add_id, ":id" => $this->getId()]);

        return self::getOrderById($this->getId(), true);
    }

    /**
     * Return the count of order using a deliveryAddress
     * @param int $deliveryAddressId
     * @return int
     */
    public static function getAllCountOfOrderUsedByDeliveryAddressId(int $deliveryAddressId): int
    {
        $sql = 'select count(*) from orders where delivery_add_id= :delivery_add_id;';
        return self::executeRequest($sql, [":delivery_add_id" => $deliveryAddressId])->fetch()[0];
    }

    public function addItem(Product $product, int $quantity)
    {
        OrderItem::createOrAddOrderItem($this->id, $product, $quantity);
    }

    public function clear()
    {
        if ($this->getStatus()->getStatusCode() <= OrderStatusCode::$InPayment) {
            $sql = "DELETE FROM orderitems where order_id = :id";
            self::executeRequest($sql, ["id" => $this->id]);
        }
    }

    /**
     * Return user link to this order
     * @return User
     */
    public function getUser(): User
    {
        return User::getUserById($this->user_id);
    }

    public function setUserId($user_id)
    {
        $sql = 'UPDATE orders set user_id=:user_id where id=:id';
        self::executeRequest($sql, [":user_id" => $user_id, ":id" => $this->getId()]);
        return self::getOrderById($this->getId(), true);
    }

    /**
     * Return a deliveryAddress
     * @return DeliveryAddress
     */
    public function getDeliveryAddress(): DeliveryAddress
    {
        return DeliveryAddress::getDeliveryAddressById($this->getDeliveryAddId());
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
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return int
     */
    public function getDeliveryAddId(): int
    {
        return $this->delivery_add_id;
    }

    /**
     * @return OrderStatus
     */
    public function getStatus(): OrderStatus
    {
        return $this->statusHistory[count($this->statusHistory) - 1];
    }

    /**
     * @return OrderItem[]|null
     */
    public function getOrderItems(): array|null
    {
        return $this->orderItems;
    }

    /**
     * @return OrderStatus|null
     */
    public function getStatusHistory(int $status): ?OrderStatus
    {
        if ($this->statusHistory == null) {
            $this->statusHistory = OrderStatus::getAllStatusByOrderId($this->id);
        }
        return isset($this->statusHistory[$status]) ? $this->statusHistory[$status] : null;
    }

    /**
     * @param int $status 
     * @return Order
     */
    public function setStatus(int $status): self
    {
        OrderStatus::changeStatus($this->getId(), $status);
        return Order::getOrderById($this->getId(), true);
    }

    /**
     * Total price
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * quantity of item
     * @return int|null
     */
    public function getQuantity(): int|null
    {
        return $this->quantity;
    }
}
