<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';

class OrderItem extends Modele
{
    private $id;
    private $orderId;
    private $productId;
    private $quantity;

    function __construct($data)
    {
        $this->orderId = $data['order_id'];
        $this->productId = $data['product_id'];
        $this->quantity = $data['quantity'];
    }

    public static function getAllOrderItemByOrderId($order_id){
        $sql = 'select * from orderitems where order_id=:order_id';
        $result = Order::executerRequete($sql, [":order_id" => $order_id]);
        $listeOrderItems = [];
        foreach ($result->fetchAll() as $orderItem) {
            array_push($listeOrderItems,new OrderItem($orderItem));
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
}