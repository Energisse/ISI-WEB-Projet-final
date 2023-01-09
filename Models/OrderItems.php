<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';


class OrderItem extends Modele
{
    /**
     * orderID unique couple with productId
     * @var int
     */
    private int $orderID;

    /**
     * productId unique couple with orderID
     * @var int
     */
    private int $productId;

    /**
     * quantity
     * @var int
     */
    private int $quantity;

    /**
     * constructor
     * @param mixed $data
     */
    protected function __construct($data)
    {
        $this->orderID = $data['order_id'];
        $this->productId = $data['product_id'];
        $this->quantity = $data['quantity'];
        if(array_key_exists("product",$data)){
            Product::create($data["product"]);
        }
    }
  
    /**
     * Create a new orderItems in database
     * @param mixed $orderID
     * @param mixed $ordersItems
     * @return void
     */
    public static function createOrderItems($orderID, $ordersItems)
    {
        $sql = 'INSERT INTO orderitems VALUES ';
        $insertQuery = array();
        $insertData = array();
        foreach ($ordersItems as $ordersItem) {
            $insertQuery[] = '(?, ?, ?)';
            $insertData[] = $orderID;
            $insertData[] = $ordersItem["product"]->getId();
            $insertData[] = $ordersItem["quantity"];
        }
        if (!empty($insertQuery)) {
            $sql .= implode(', ', $insertQuery);
            OrderItem::executeRequest($sql, $insertData);
        }
    }

     /**
     * Return Product linked
     * @return ?Product
     */
    public function getProduct(): ?Product
    {
        return Product::getProductById($this->getProductId());
    }

     /**
     * Return Product linked
     * @return ?Order
     */
    public function getOrder(): ?Order
    {
        return Order::getOrderById($this->getOrderId());
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderID;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }


    public function getId(){
        return $this->getOrderId() . "-" . $this->getProductId();
    } 

}
