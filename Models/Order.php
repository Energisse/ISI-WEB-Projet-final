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
     * @var int
     */
    private int $user_id;

    /**
     * delivery_add_id
     * @var int
     */
    private int $delivery_add_id;

    /**
     * payment_type
     * @var string
     */
    private string $payment_type;

    /**
     * Total price
     * @var float
     */
    private float $price;

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

    protected function __construct($data)
    {
        $this->id = $data["id"];
        $this->user_id = $data["user_id"];
        $this->delivery_add_id = $data["delivery_add_id"];
        $this->payment_type = $data["payment_type"];
        $this->price = $data["price"];
        $this->statusHistory = [];
        $this->orderItems = [];
        if (array_key_exists("status", $data)) {
            foreach (json_decode($data["status"], true) as $address) {
                $this->statusHistory[] = &OrderStatus::create($address);
            }
        }
        if (array_key_exists("orderitems", $data)) {
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
        $sql = "
        SELECT 
        o.*,
        ( SELECT 
            sum(price*quantity)
            FROM products p join orderitems oi
            on p.id = oi.product_id
            where oi.order_id = o.id
        ) as price, 
        (
            SELECT 
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'order_id',oi.order_id,
                        'product_id',oi.product_id,
                        'quantity',oi.quantity,
                        'product', JSON_OBJECT(
                                'id',p.id,
                                'cat_id',p.cat_id,
                                'name',p.name,
                                'description',p.description,
                                'image',p.image,
                                'price',p.price,
                                'quantity_remaining',p.quantity_remaining
                            ) 
                    ) 
                ) 
            FROM  orderitems oi 
            join products p on  p.id = oi.product_id 
            where o.id = oi.order_id
        ) as orderitems,
        (
            SELECT 
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'status',os.status,
                        'order_id',os.order_id,
                        'date',os.date
                    )
                ) 
            FROM orderStatus os 
            where o.id = os.order_id  
        ) as status
        FROM orders o where o.id = :order_id AND o.user_id = :user_id;";
        return Order::fetch($sql, [":order_id" => $order_id, ":user_id" => $user_id]);
    }

    /**
     * return an order by id
     * @param int $order_id
     * @return Order|null
     */
    public static function getOrderById(int $order_id): ?Order
    {
        if (self::getInstanceByID($order_id)) {
            return self::getInstanceByID($order_id);
        }

        $sql = "
        SELECT 
        o.*,
        ( SELECT 
            sum(price*quantity)
            FROM products p join orderitems oi
            on p.id = oi.product_id
            where oi.order_id = o.id
        ) as price, 
        (
            SELECT 
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'order_id',oi.order_id,
                        'product_id',oi.product_id,
                        'quantity',oi.quantity,
                        'product', JSON_OBJECT(
                                'id',p.id,
                                'cat_id',p.cat_id,
                                'name',p.name,
                                'description',p.description,
                                'image',p.image,
                                'price',p.price,
                                'quantity_remaining',p.quantity_remaining
                            ) 
                    ) 
                ) 
            FROM  orderitems oi 
            join products p on  p.id = oi.product_id 
            where o.id = oi.order_id
        ) as orderitems,
        (
            SELECT 
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'status',os.status,
                        'order_id',os.order_id,
                        'date',os.date
                    )
                ) 
            FROM orderStatus os 
            where o.id = os.order_id  
        ) as status
        FROM orders o where o.id = :order_id;";
        return Order::fetch($sql, [":order_id" => $order_id]);
    }

    /**
     * Return all order not delivered
     * @return Order[]
     */
    public static function getAllOrderNotDelivered(): array
    {
        $sql = "
        SELECT 
        o.*,
        ( SELECT 
            sum(price*quantity)
            FROM products p join orderitems oi
            on p.id = oi.product_id
            where oi.order_id = o.id
        ) as price, 
        (
            SELECT 
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'order_id',oi.order_id,
                        'product_id',oi.product_id,
                        'quantity',oi.quantity,
                        'product', JSON_OBJECT(
                                'id',p.id,
                                'cat_id',p.cat_id,
                                'name',p.name,
                                'description',p.description,
                                'image',p.image,
                                'price',p.price,
                                'quantity_remaining',p.quantity_remaining
                            ) 
                    ) 
                ) 
            FROM  orderitems oi 
            join products p on  p.id = oi.product_id 
            where o.id = oi.order_id
        ) as orderitems,
        (
            SELECT 
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'status',os.status,
                        'order_id',os.order_id,
                        'date',os.date
                    )
                ) 
            FROM orderStatus os 
            where o.id = os.order_id  
        ) as status
        FROM orders o where id not in (SELECT order_id from orderstatus where status = 3)  order by id desc;";
        return Order::fetchAll($sql);
    }

    /**
     * Return all order by user_id
     * @param int $user_id
     * @return Order[]
     */
    public static function getOrdersByUserId(int $user_id): array
    {
        $sql = "
            SELECT 
            o.*,
            ( SELECT 
            sum(price*quantity)
            FROM products p join orderitems oi
            on p.id = oi.product_id
            where oi.order_id = o.id
        ) as price, 
            (
                SELECT 
                    JSON_ARRAYAGG(
                        JSON_OBJECT(
                            'order_id',oi.order_id,
                            'product_id',oi.product_id,
                            'quantity',oi.quantity,
                            'product', JSON_OBJECT(
                                    'id',p.id,
                                    'cat_id',p.cat_id,
                                    'name',p.name,
                                    'description',p.description,
                                    'image',p.image,
                                    'price',p.price,
                                    'quantity_remaining',p.quantity_remaining
                                ) 
                        ) 
                    ) 
                FROM  orderitems oi 
                join products p on  p.id = oi.product_id 
                where o.id = oi.order_id
            ) as orderitems,
            (
                SELECT 
                    JSON_ARRAYAGG(
                        JSON_OBJECT(
                            'status',os.status,
                            'order_id',os.order_id,
                            'date',os.date
                        )
                    ) 
                FROM orderStatus os 
                where o.id = os.order_id  
            ) as status
            FROM orders o where o.user_id = :user_id;";
        return Order::fetchAll($sql, [":user_id" => $user_id]);
    }

    /**
     * create a new Order
     * @param int $userId
     * @param int $deliveryAddressID
     * @param array $ordersItems
     * @param string $paymentType
     * @return int
     */
    public static function createNewOrder(int $userId, int $deliveryAddressID, array $ordersItems, string $paymentType)
    {
        $sql = 'insert into orders(user_id,delivery_add_id,payment_type) values(:user_id,:delivery_add_id,:payment_type);';
        Order::executeRequest($sql, [":user_id" => $userId, ":delivery_add_id" => $deliveryAddressID, ":payment_type" => $paymentType]);
        $id = Order::lastInsertId();
        OrderStatus::createNewStatus($id);
        OrderItem::createOrderItems($id, $ordersItems);
        return $id;
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

    /**
     * Return user link to this order
     * @return User
     */
    public function getUser(): User
    {
        return User::getUserById($this->user_id);
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
        $this->statusHistory = $newOrder->statusHistory;
        return $this;
    }

    /**
     * Total price
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
