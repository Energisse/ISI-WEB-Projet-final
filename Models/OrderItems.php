<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';

class OrderItem extends Modele
{
    private int $orderId;
    private int $productId;
    private int $quantity;

    private Product $product;

    function __construct($data)
    {
        $this->orderId = $data['order_id'];
        $this->productId = $data['product_id'];
        $this->quantity = $data['quantity'];
        $this->product = new Product($data);
    }

    public static function getAllOrderItemByOrderId($order_id){
        $sql = 'select * from orderitems where order_id=:order_id';
        $result = Order::executerRequete($sql, [":order_id" => $order_id]);
        $listeOrderItems = [];
        foreach ($result->fetchAll() as $orderItem) {
            $listeOrderItems[] = new OrderItem($orderItem);
        }
        return $listeOrderItems;
    }

    public static function getAllOrderItemAndProductByOrdersId($orders_id){
        $placeholders = str_repeat ('?, ',  count ($orders_id) - 1) . '?';
        $sql = "select * from orderitems o join products p on p.id = o.product_id  where order_id in ($placeholders) order by order_id desc";
        $result = Order::executerRequete($sql, $orders_id);
        $listeOrderItems = [];
        foreach ($result->fetchAll() as $orderItem) {
            $listeOrderItems[] = new OrderItem($orderItem);
        }
        return $listeOrderItems;
    }

    public static function createOrderItems($order_id,$ordersItems){
        $sql = 'INSERT INTO orderitems VALUES ';
        $insertQuery = array();
        $insertData = array();
        foreach ($ordersItems as $ordersItem) {
            $insertQuery[] = '(?, ?, ?)';
            $insertData[] = $order_id;
            $insertData[] = $ordersItem["product"]->getId();
            $insertData[] = $ordersItem["quantity"];
        }
        if (!empty($insertQuery)) {
            $sql .= implode(', ', $insertQuery);
            Order::executerRequete($sql,$insertData);
        }
    }

	/**
	 * @return int
	 */
	public function getOrderId(): int {
		return $this->orderId;
	}

	/**
	 * @return int
	 */
	public function getQuantity(): int {
		return $this->quantity;
	}

	/**
	 * @return Product
	 */
	public function getProduct(): Product {
		return $this->product;
	}
}